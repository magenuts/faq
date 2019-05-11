<?php
namespace Magenuts\Faq\Block\Adminhtml\Faq\Edit\Tab;

/**
 * Class Visibility
 * @package Magenuts\Faq\Block\Adminhtml\Faq\Edit\Tab
 */
class Visibility extends \Magento\Backend\Block\Widget\Form\Generic implements
    \Magento\Backend\Block\Widget\Tab\TabInterface
{

    /**
     * @var \Magenuts\Faq\Model\Status
     */
    protected $_status;
    /**
     * @var \Magenuts\Faq\Model\Faqcategory
     */
    protected $_faqCategory;
    /**
     * @var
     */
    protected $_formFactory;
    /**
     * @var
     */
    protected $_coreRegistry;

    /**
     * Visibility constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Store\Model\System\Store $systemStore
     * @param \Magento\Framework\Registry $registry
     * @param \Magenuts\Faq\Model\Status $status
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magenuts\Faq\Model\Faqcategory $faqCategory
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Store\Model\System\Store $systemStore,
        \Magento\Framework\Registry $registry,
        \Magenuts\Faq\Model\Status $status,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magenuts\Faq\Model\Categories $faqCategory
    ) {
        $this->systemStore = $systemStore;
        $this->_status = $status;
        $this->_faqCategory = $faqCategory;
        parent::__construct($context, $registry, $formFactory);
    }

    /**
     * @return mixed
     */
    protected function _prepareForm()
    {
        $form = $this->_formFactory->create(
            [
                'data' =>
                    [
                        'html_id_prefix' => 'page_additional_'
                    ]
            ]
        );
        $model = $this->_coreRegistry->registry('faq');
        $isElementDisabled = false;
        $fieldSet = $form->addFieldset(
            'Additional_fieldset',
            [
                'legend' => __('Visibility'),
                'class' => 'fieldset-wide',
                'disabled' => $isElementDisabled
            ]
        );
		//echo "<pre>"; print_r($fieldSet); exit;
        $fieldSet->addField(
            'faq_category',
            'multiselect',
            [
                'name' => 'faq_category[]',
                'label' => __('Categories'),
                'title' => __('Categories'),
                'required' => true,
                'disabled' => $isElementDisabled,
                'values' => $this->_faqCategory->toOptionArray()
            ]
        );

        $fieldSet->addField(
            'store_id',
            'multiselect',
            [
                'name' => 'store_id[]',
                'label' => __('Store'),
                'title' => __('Store'),
                'values' => $this->systemStore
                    ->getStoreValuesForForm(false, true),
                'disabled' => $isElementDisabled
            ]
        );

        $fieldSet->addField(
            'is_active',
            'select',
            [
                'name' => 'is_active',
                'label' => __('Status'),
                'title' => __('Status'),
                'required' => true,
                'options' => $this->_status->getOptionArray(),
                'disabled' => $isElementDisabled
            ]
        );
        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * @return mixed
     */
    public function getTabLabel()
    {
        return __('Visibility');
    }

    /**
     * @return mixed
     */
    public function getTabTitle()
    {
        return __('Visibility');
    }

    /**
     * @return bool
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * @return bool
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * @param $resourceId
     * @return mixed
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}
