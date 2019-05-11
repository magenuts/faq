<?php
namespace Magenuts\Faq\Block\Adminhtml\Faqcat\Edit;

/**
 * Class Tabs
 * @package Magenuts\Faq\Block\Adminhtml\Faqcat\Edit
 */
class Tabs extends \Magento\Backend\Block\Widget\Tabs
{

    /**
     *
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('faqcat_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Category Information'));
    }
}
