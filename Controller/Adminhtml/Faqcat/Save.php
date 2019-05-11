<?php
namespace Magenuts\Faq\Controller\Adminhtml\Faqcat;

/**
 * Class Save
 * @package Magenuts\Faq\Controller\Adminhtml\Faqcat
 */
class Save extends \Magenuts\Faq\Controller\Adminhtml\Faqcat
{

    public function execute()
    {
        $formPostValues = $this->getRequest()->getPostValue();
        if (isset($formPostValues) && !empty($formPostValues)) {
            $faqCategoryData = $formPostValues;
            if (isset($faqCategoryData) && !empty($faqCategoryData)) {
                if (isset($formPostValues[
                        'store_id'
                        ]) && !empty(
                    $formPostValues['store_id'])
                ) {
                    $storeId = implode(',',
                        $formPostValues['store_id']
                    );
                    $faqCategoryData['store_id'] = $storeId;
                }
            }

            $faqCategoryId = isset($faqCategoryData[
                'faq_cat_id'
                ]) ? $faqCategoryData[
            'faq_cat_id'
            ] : null;
            $model = $this->_faqcatFactory->create();
            $modelUrl = $this->_faqcatFactory->create();
            if ($faqCategoryId) {
                $modelUrl->getCollection()
                    ->addFieldToFilter(
                        'faq_cat_id',
                        [
                            'neq' => $faqCategoryId
                        ]
                    );
            } else {
                $modelUrl->getCollection();
            }
            if ($faqCategoryData['url_key']) {
                $faqCategoryData['url_key'] = preg_replace(
                    '/^-+|-+$/',
                    '',
                    strtolower(
                        preg_replace(
                            '/[^a-zA-Z0-9]+/',
                            '-',
                            $faqCategoryData[
                            'url_key'
                            ]
                        )
                    )
                );
            }
            $model->setData($faqCategoryData);
            $data['created_at'] = date('Y-m-d');
            $model->setCreatedAt($data['created_at']);
            try {

                $model->save();
                $this->messageManager->addSuccess(__(
                    'The category has been saved.'
                ));
                $this->_getSession()->setFormData(false);

                if ($this->getRequest()->getParam('back') === 'edit') {
                    $this->_redirect(
                        '*/*/edit',
                        [
                            'faq_cat_id' => $model->getFaqCatId(),
                            '_current' => true
                        ]
                    );
                    return;
                } elseif ($this->getRequest()->getParam('back') === "new") {
                    $this->_redirect(
                        '*/*/new',
                        [
                            '_current' => true
                        ]
                    );
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (\Magento\Framework\Model\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                $this->messageManager->addException(
                    $e,
                    __(
                        'Something went wrong while saving the Category.'
                    )
                );
            }

            $this->_getSession()->setFormData($formPostValues);
            $this->_redirect(
                '*/*/edit',
                [
                    'faq_cat_id' => $this->getRequest()->getParam(
                        'faq_cat_id'
                    )
                ]
            );
            return;
        }
        $this->_redirect('*/*/');
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magenuts_Faq::faq');
    }
}
