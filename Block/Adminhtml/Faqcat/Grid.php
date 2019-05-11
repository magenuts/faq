<?php
namespace Magenuts\Faq\Block\Adminhtml\Faqcat;

/**
 * Class Grid
 * @package Magenuts\Faq\Block\Adminhtml\Faqcat
 */
class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{

    /**
     * @var \Magenuts\Faq\Model\FaqcatFactory
     */
    protected $_faqCategoryFactory;
    /**
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;
    /**
     * @var \Magenuts\Faq\Model\Status
     */
    protected $_status;

    /**
     * Grid constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magenuts\Faq\Model\Status $status
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Magenuts\Faq\Model\FaqcatFactory $faqCategoryFactory
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magenuts\Faq\Model\Status $status,
        \Magento\Backend\Helper\Data $backendHelper,
        \Magenuts\Faq\Model\FaqcatFactory $faqCategoryFactory
    ) {
        $this->_faqCategoryFactory = $faqCategoryFactory;
        $this->_coreRegistry = $coreRegistry;
        $this->_status = $status;
        parent::__construct($context, $backendHelper);
    }

    /**
     *
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('faqcatGrid');
        $this->setDefaultSort('faq_cat_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(false);
    }

    /**
     * @return mixed
     */
    protected function _prepareCollection()
    {
        $collection = $this->_faqCategoryFactory->create()->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * @return mixed
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'faq_cat_id',
            [
                'header' => __('Category ID'),
                'type' => 'number',
                'index' => 'faq_cat_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id',
            ]
        );
        $this->addColumn(
            'name',
            [
                'header' => __('Name'),
                'index' => 'name',
                'class' => 'xxx',
                'width' => '50px',
            ]
        );

        $this->addColumn(
            'sort_order',
            [
                'header' => __('Sort Order'),
                'index' => 'sort_order',
                'class' => 'xxx',
                'width' => '50px',
            ]
        );

        $this->addColumn(
            'is_active',
            [
                'header' => __('Status'),
                'index' => 'is_active',
                'class' => 'xxx',
                'width' => '50px',
                'type' => 'options',
                'options' => ['1' => 'Enabled', '2' => 'Disabled']
            ]
        );

        $this->addColumn(
            'action',
            [
                'header' => __('Action'),
                'index' => 'is_active',
                'type' => 'action',
                'getter' => 'getId',
                'class' => 'xxx',
                'width' => '20px',
                'actions' => [
                    [
                        'caption' => __('Edit'),
                        'url' => [
                            'base' => '*/*/edit',
                        ],
                        'field' => 'faq_cat_id'
                    ]
                ],
                'filter' => false,
                'sortable' => false
            ]
        );

        return parent::_prepareColumns();
    }

    /**
     * @return $this
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('faqcat');
        $this->getMassactionBlock()->addItem('delete', [
            'label' => __('Delete'),
            'url' => $this->getUrl('*/*/massDelete', ['' => '']),
            'confirm' => __('Are you sure?')
        ]);
        $statuses = $this->_status->getOptionArray();
        array_unshift($statuses, ['label' => '', 'value' => '']);
        $this->getMassactionBlock()->addItem('status', [
            'label' => __('Change status'),
            'url' => $this->getUrl('*/*/massStatus', ['_current' => true]),
            'additional' => [
                'visibility' => [
                    'name' => 'status',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => __('Status'),
                    'values' => $statuses
                ]
            ]
        ]);

        return $this;
    }

    /**
     * @param $row
     * @return mixed
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', ['faq_cat_id' => $row->getId()]);
    }
}
