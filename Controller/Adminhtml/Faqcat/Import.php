<?php
namespace Magenuts\Faq\Controller\Adminhtml\Faqcat;

use Magento\Framework\App\Filesystem\DirectoryList;

class Import extends \Magento\Backend\App\Action
{

    /**
     * @var PageFactory
     */
    protected $_storeManager;
    /**
     * @var \Magenuts\Faq\Model\FaqcatFactory
     */
    protected $_faqCategoryFactory;
    /**
     * @var
     */

    protected $_objectManager;

    /**
     * Index constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magenuts\Faq\Model\FaqcatFactory $faqCategoryFactory
    )
    {
        $this->_storeManager = $storeManager;
        $this->_faqCategoryFactory = $faqCategoryFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\View\Result\Page
     */
    public function is_array_empty($a)
    {
        foreach ($a as $elm)
            if (!empty($elm)) return false;
        return true;
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultRedirectFactory->create();
        $uploader = $this->_objectManager->create(
            'Magento\MediaStorage\Model\File\Uploader',
            ['fileId' => 'uploadFile']
        );
        $uploader->setAllowedExtensions(['csv']);
        $uploader->setAllowRenameFiles(false);
        $uploader->setFilesDispersion(false);
        $mediaDirectory = $this->_objectManager
            ->get('Magento\Framework\Filesystem')
            ->getDirectoryRead(DirectoryList::MEDIA);
        $result = $uploader->save($mediaDirectory
            ->getAbsolutePath('faq'));
        $csv_file = $result['path'] . '/' . $result['file'];
        if (is_file($csv_file)) {
            $input = fopen($csv_file, 'a+');
            $header = NULL;
            while (($row = fgetcsv($input, 1024, ',')) !== FALSE) {
                if (!$header) {
                    $header = $row;
                } else {
                    $check = $this->is_array_empty($row);
                    if (!$check) {
                        $data[] = array_combine($header, $row);
                    }
                }
            }
            unset($data['form_key']);
            if (count($data) > 0) {
                foreach ($data as $dataKey => $dataValue) {
                    $model = $this->_objectManager->create(
                        'Magenuts\Faq\Model\Faqcat'
                    );
                    foreach ($dataValue as $key => $val) {
                        $model->setData($key, $val);
                        if (!empty($dataValue['url_key'])) {
                            $data = preg_replace('/^-+|-+$/', '',
                                strtolower(preg_replace(
                                    '/[^a-zA-Z0-9]+/', '-',
                                    $dataValue['url_key']))
                            );
                            $model->setData('url_key', $data);
                        } else {
                            $model->setData('url_key', '');
                        }
                    }
                    try {
                        $model->save();
                    } catch (\Magento\Framework\Exception\LocalizedException $e) {
                        $this->messageManager->addError($e->getMessage());
                        return $resultRedirect->setPath('*/*/');
                    } catch (\RuntimeException $e) {
                        $this->messageManager->addError($e->getMessage());
                        return $resultRedirect->setPath('*/*/');
                    } catch (\Exception $e) {
                        $this->messageManager->addException(
                            $e,
                            __(
                                'Something went wrong while saving the entry.'
                            )
                        );
                        return $resultRedirect->setPath('*/*/');
                    }
                }
                $this->messageManager->addSuccess(
                    __(
                        'locations imported successfully.'
                    )
                );
            } else {
                $this->messageManager->addError(
                    __(
                        'Some Error occur in import , Please try again'
                    )
                );
            }

            return $resultRedirect->setPath('*/*/');
        } else {
            $this->messageManager->addError(
                __(
                    'Some Error occur in import , Please try again'
                )
            );
            return $resultRedirect->setPath('*/*/');
        }
    }

    /**
     * @return mixed
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magenuts_Faq::import');
    }
}
