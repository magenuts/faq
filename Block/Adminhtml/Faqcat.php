<?php
namespace Magenuts\Faq\Block\Adminhtml;
/**
 * Class Faqcat
 * @package Magenuts\Faq\Block\Adminhtml
 */
class Faqcat extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     *
     */
    protected function _construct()
    {
        $this->_controller = 'adminhtml_faqcat';
        $this->_blockGroup = 'Magenuts_Faq';
        $this->_headerText = __('Manage FAQ Category');
        $this->_addButtonLabel = __('Add New Category');
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
                'label' => __('Import Category'),
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
            'faq/faqcat/importcategory'
        );
    }
}
