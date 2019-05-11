<?php
namespace Magenuts\Faq\Controller\Adminhtml\Faqcat;

/**
 * Class NewAction
 * @package Magenuts\Faq\Controller\Adminhtml\Faqcat
 */
class NewAction extends \Magenuts\Faq\Controller\Adminhtml\Faqcat
{

    /**
     *
     */
    public function execute()
    {
        $this->_forward('edit');
    }

    /**
     * @return mixed
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magenuts_Faq::faq');
    }
}
