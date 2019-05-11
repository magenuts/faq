<?php
namespace Magenuts\Faq\Block\Adminhtml\Faq\Edit;

/**
 * Class Tabs
 * @package Magenuts\Faq\Block\Adminhtml\Faq\Edit
 */
class Tabs extends \Magento\Backend\Block\Widget\Tabs
{

    /**
     *
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('faq_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('FAQ Information'));
    }
}
