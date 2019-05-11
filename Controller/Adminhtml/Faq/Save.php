<?php
namespace Magenuts\Faq\Controller\Adminhtml\Faq;

/**
 * Class Save
 * @package Magenuts\Faq\Controller\Adminhtml\Faq
 */
class Save extends \Magenuts\Faq\Controller\Adminhtml\Faq
{
    /**
     *
     */
    public function execute()
    {
        $formPostValues = $this->getRequest()->getPostValue();

        if (isset($formPostValues) && !empty($formPostValues)) {
            $faqData = $formPostValues;
            if (isset($faqData) && !empty($faqData)) {
                if (isset($formPostValues[
                        'store_id'
                        ]) && !empty(
                    $formPostValues['store_id'])
                ) {
                    $storeids = implode(',', $faqData['store_id']);
                    $faqData['store_id'] = $storeids;
                }
            }

            if (isset($faqData['faq_category'])) {
                $faqData['faq_cat_id'] = implode(',', $faqData['faq_category']);


            }

            $faqId = isset($faqData['faq_id']) ? $faqData['faq_id'] : null;
            $model = $this->_faqFactory->create();
            if ($faqId) {
                $model->load($faqId);
            }

            if ($faqData['url_key']) {
                $faqData['url_key'] = preg_replace(
                    '/^-+|-+$/',
                    '',
                    strtolower(
                        preg_replace(
                            '/[^a-zA-Z0-9]+/',
                            '-',
                            $faqData['url_key']
                        )
                    )
                );
            } else {
                $faqData['url_key'] = preg_replace(
                    '/^-+|-+$/',
                    '',
                    strtolower(
                        preg_replace(
                            '/[^a-zA-Z0-9]+/',
                            '-',
                            $faqData['title']
                        )
                    )
                );
            }

            $modelUrl = $this->_faqFactory->create();
            if ($faqId) {
                $modelURL = $modelUrl->getCollection()
                    ->addFieldToFilter(
                        'faq_id',
                        [
                            'neq' => $faqId
                        ]
                    );
            } else {
                $modelURL = $modelUrl->getCollection();
            }
            $count = 0;
            foreach ($modelURL->getData() as $url) {
                if ($url['url_key'] == $faqData['url_key']) {
                    $count++;
                    if ($count = 1) {
                        $random = rand(1, 99);
                        $faqData['url_key'] = $faqData[
                            'url_key'
                            ] .
                            '-' .
                            $random;
                        break;
                    }
                }
            }
            $model->setData($faqData);
            $model->setFaqCategory($faqData['faq_cat_id']);
            try {
                $model->save();
                $this->messageManager->addSuccess(__(
                    'The FAQ has been saved.'
                ));
                $this->_getSession()->setFormData(false);

                if ($this->getRequest()->getParam('back') === 'edit') {
                    $this->_redirect(
                        '*/*/edit',
                        [
                            'faq_id' => $model->getFaqId(),
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
                $this->messageManager->addException($e, __(
                    'Something went wrong while saving the Category.'
                ));

            }

            $this->_getSession()->setFormData($formPostValues);
            $this->_redirect('*/*/edit',
                [
                    'faq_id' => $this->getRequest()->getParam('faq_id')
                ]
            );
            return;
        }
        $this->_redirect('*/*/');
    }

    /**
     * @return mixed
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magenuts_Faq::faq');
    }
}
