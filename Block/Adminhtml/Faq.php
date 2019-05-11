<?php
namespace Magenuts\Faq\Block\Adminhtml;

/**
 * Class Faq
 * @package Magenuts\Faq\Block\Adminhtml
 */
class Faq extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     *
     */
    protected function _construct()
    {
        $this->_controller = 'adminhtml_faq';
        $this->_blockGroup = 'Magenuts_Faq';
        $this->_headerText = __('Manage Faq');
        $this->_addButtonLabel = __('Add New FAQ');
        parent::_construct();
    }

    /**
     * @return mixed
     */
    protected function _prepareLayout()
    {
        $this->buttonList->add(
            'import_location',
            [
                'label' => __('Import Faqs'),
                'onclick' => 'setLocation(\'' . $this->_getImportUrl() . '\')',
                'class' => 'primary import_location'
            ]
        );

        return parent::_prepareLayout();
    }

    /**
     * @return mixed
     */
    protected function _getImportUrl()
    {
        return $this->getUrl(
            'faq/faq/importfaq'
        );
    }
}
