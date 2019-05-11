<?php
namespace Magenuts\Faq\Controller\Adminhtml\Faq;

/**
 * Class Delete
 * @package Magenuts\Faq\Controller\Adminhtml\Faq
 */
class Delete extends \Magento\Backend\App\Action
{
    /**
     * @return mixed
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('faq_id');
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $model = $this->_objectManager->create(
                    'Magenuts\Faq\Model\Faq'
                );
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccess(__(
                    'The FAQ has been deleted.'
                ));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['faq_id' => $id]);
            }
        }
        $this->messageManager->addError(__('We can\'t find a FAQ to delete.'));
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
