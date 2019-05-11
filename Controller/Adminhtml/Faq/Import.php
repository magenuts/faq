<?php
namespace Magenuts\Faq\Controller\Adminhtml\Faq;

use Magento\Framework\App\Filesystem\DirectoryList;

/**
 * Class Import
 * @package Magenuts\Gallery\Controller\Adminhtml\Image
 */
class Import extends \Magento\Backend\App\Action
{

    /**
     * @var PageFactory
     */
    protected $uploadModel;
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;
    /**
     * @var
     */
    protected $_resultRedirectFactory;

    /**
     * @var \Magenuts\Gallery\Model\CategoryFactory
     */
    protected $_faqCategoryFactory;
    /**
     * @var
     */
    protected $_messageManager;
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
    ) {
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
        //echo "<pre>"; print_r($data); exit;
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
        $csvFile = $result['path'] . '/' . $result['file'];
        if (is_file($csvFile)) {
            $input = fopen($csvFile, 'a+');
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
                foreach ($data as $dataKey => $value) {
                    if (isset($value['faq_category'])
                        AND !empty($value['faq_category'])
                    ) {
                        $model = $this->_objectManager
                            ->create('Magenuts\Faq\Model\Faq');
                        foreach ($value as $key => $val) {
                            $model->setData($key, $val);
                            $valArr = explode(",", $val);
                            $collection = $this->_faqCategoryFactory
                                ->create()
                                ->getCollection();
                            $imageArr = [];
                            foreach ($collection as $_obj) {
                                if (in_array($_obj->getName(), $valArr)) {
                                    $imageArr[] = $_obj->getFaqCatId();
                                }
                            }
                            if (count($imageArr) > 0) {
                                $imageCategory = implode(",", $imageArr);
                                $model->setData('faq_category', $imageCategory);
                                $model->setData('faq_cat_id', $imageCategory);
                            }
                            unset($imageArr);
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
                                $e,__(
                                'Something went wrong while saving the entry.'
                            ));
                            return $resultRedirect->setPath('*/*/');
                        }
                    } else {
                        $this->messageManager->addError(__(
                            'please check image category is empty Error occur in import ,
                             Please try again.'
                        ));
                        return $resultRedirect->setPath('*/*/');
                    }
                }
                $this->messageManager->addSuccess(__(
                    'images imported successfully.'
                ));
            } else {
                $this->messageManager->addError(__(
                    'Some Error occur in import ,
                     Please try again'
                ));
            }
            return $resultRedirect->setPath('*/*/');
        } else {
            $this->messageManager->addError(__(
                'Some Error occur in import ,
                 Please try again'
            ));
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
