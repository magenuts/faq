<?php
namespace Magenuts\Faq\Controller\Adminhtml\Faqcat;

/**
 * Class Delete
 * @package Magenuts\Faq\Controller\Adminhtml\Faqcat
 */
class Delete extends \Magento\Backend\App\Action
{
    /**
     * @return mixed
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('faq_cat_id');
        $resultRedirect = $this->_resultRedirectFactory->create();
        if ($id) {
            try {
                $model = $this->_objectManager->create(
                    'Magenuts\Faq\Model\Faqcat'
                );
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccess(__(
                    'The category has been deleted.'
                ));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath(
                    '*/*/edit',
                    [
                        'faq_cat_id' => $id
                    ]
                );
            }
        }
        $this->messageManager->addError(__(
            'We can\'t find a Category to delete.'
        ));

        return $resultRedirect->setPath('*/*/');
    }

    /**
     * @return mixed
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magenuts_Faq::faq');
    }
}
