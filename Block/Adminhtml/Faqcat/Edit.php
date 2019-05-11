<?php
namespace Magenuts\Faq\Block\Adminhtml\Faqcat;

/**
 * Class Edit
 * @package Magenuts\Faq\Block\Adminhtml\Faqcat
 */
class Edit extends \Magento\Backend\Block\Widget\Form\Container
{

    /**
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * Edit constructor.
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context);
    }

    /**
     *
     */
    protected function _construct()
    {
        $this->_objectId = 'faq_cat_id';
        $this->_blockGroup = 'Magenuts_Faq';
        $this->_controller = 'adminhtml_faqcat';
        parent::_construct();
        $this->buttonList->update('save', 'label', __('Save Category'));
        $this->buttonList->update('delete', 'label', __('Delete'));
        $this->buttonList->add(
            'save_and_continue',
            [
                'label' => __('Save and Continue Edit'),
                'class' => 'save',
                'data_attribute' => [
                    'mage-init' => [
                        'button' => [
                            'event' => 'saveAndContinueEdit',
                            'target' => '#edit_form'
                        ],
                    ],
                ],
            ],
            10
        );
    }

    /**
     * @return mixed
     */
    protected function _getSaveAndContinueUrl()
    {
        return $this->getUrl(
            '*/*/save',
            ['_current' => true, 'back' => 'edit', 'tab' => '{{tab_id}}']
        );
    }
}
