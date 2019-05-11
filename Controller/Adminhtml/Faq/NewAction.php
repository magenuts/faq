<?php
namespace Magenuts\Faq\Controller\Adminhtml\Faq;

/**
 * Class NewAction
 * @package Magenuts\Faq\Controller\Adminhtml\Faq
 */
class NewAction extends \Magenuts\Faq\Controller\Adminhtml\Faq
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
