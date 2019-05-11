<?php
namespace Magenuts\Faq\Controller\Adminhtml\Faq;

/**
 * Class Edit
 * @package Magenuts\Faq\Controller\Adminhtml\Faq
 */
class Edit extends \Magenuts\Faq\Controller\Adminhtml\Faq
{

    /**
     *
     */
    public function execute()
    {

        $id = $this->getRequest()->getParam('faq_id');
        $model = $this->_faqFactory->create();
        if ($id) {
            $model->load($id);
            if (!$model->getFaqId()) {
                $this->messageManager->addError(__(
                    'This FAQ no longer exists.'
                ));
                $this->_redirect('*/*/');
                return;
            }
        }
        $data = $this->_getSession()->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }
        $this->_coreRegistry->register('faq', $model);
        $this->_view->loadLayout();
        $this->_view->getLayout()->initMessages();
        $this->_view->renderLayout();
    }

    /**
     * @return mixed
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magenuts_Faq::faq');
    }
}
