<?php
namespace Magenuts\Faq\Model;

/**
 * Class Categories
 * @package Magenuts\Faq\Model
 */
class Categories extends \Magento\Framework\View\Element\Template implements \Magento\Framework\Option\ArrayInterface
{

    /**
     *
     */
    const STATUS_CAT1 = 1;
    /**
     *
     */
    const STATUS_CAT2 = 2;
    /**
     *
     */
    const STATUS_CAT3 = 3;

    /**
     * @var FaqcatFactory
     */
    protected $_faqCategoryFactory;
    /**
     * @var
     */
    protected $_globalcat;

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $result = [];
        foreach (self::getOptionArray() as $index => $value) {
            $result[] = ['value' => $index, 'label' => $value];
        }

        return $result;
    }

    /**
     * Categories constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param FaqcatFactory $faqcatFactory
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magenuts\Faq\Model\FaqcatFactory $faqCategoryFactory
    )
    {
        parent::__construct($context);
        $this->_faqCategoryFactory = $faqCategoryFactory;
    }

    /**
     * @param $id
     * @return bool
     */
    function hasChild($id)
    {
        $faqCategoryModel = $this->_faqCategoryFactory->create();
        $faqCategoryColl = $faqCategoryModel->load($id);
        if (count($faqCategoryColl) > 0) {
            return true;
        }
        return false;
    }

    /**
     * @param int $parent
     * @param int $level
     */
    public function dumpTree($parent = 0, $level = 0)
    {
        $faqCategoryModel = $this->_faqCategoryFactory->create();
        $faqCategoryColl = $faqCategoryModel->getCollection()
            ->addFieldToFilter('is_active', 1);
        $nonEscapableNbspChar = html_entity_decode('&#160;', ENT_NOQUOTES, 'UTF-8');
        foreach ($faqCategoryColl AS $cat) {
            if ($parent == $cat['parent_cat_id']) {
                $this->_globalcat['options'][$cat['faq_cat_id']] =
                    str_repeat($nonEscapableNbspChar, $level * 4) . $cat['name'];
                if ($this->hasChild($cat['faq_cat_id'])) {
                    $this->dumpTree($cat['faq_cat_id'], $level + 1);
                }
            }
        }
    }

    /**
     * @param int $parent
     * @param int $level
     */
    public function dumpTreedesign($parent = 0, $level = 0)
    {
        $faqCategoryModel = $this->_faqCategoryFactory->create();
        $faqCategoryColl = $faqCategoryModel->getCollection()
            ->addFieldToFilter('is_active', 1);
        $nonEscapableNbspChar = html_entity_decode('&#160;', ENT_NOQUOTES, 'UTF-8');
        foreach ($faqCategoryColl AS $cat) {
            if ($parent == $cat['parent_cat_id']) {
                $this->_globalcat['optionsdesign'][$cat['faq_cat_id']] =
                    $cat['url_key'] . '*' .
                    str_repeat($nonEscapableNbspChar, $level * 4) .
                    $cat['name'];
                if ($this->hasChild($cat['faq_cat_id'])) {
                    $this->dumpTreedesign($cat['faq_cat_id'], $level + 1);
                }
            }
        }
    }

    /**
     * @return mixed
     */
    public function getOptionArraytwo()
    {
        $this->_globalcat['options'][0] = 'Create Parent';
        $val = $this->dumpTree();
        return $this->_globalcat['options'];
    }

    /**
     * @return mixed
     */
    public function getOptionArray()
    {
        $categorieModel = $this->_faqCategoryFactory->create();
        $categorieDetail = $categorieModel->getCollection();
        $categoryData = [];
        foreach ($categorieDetail as $detail) {
            $categoryData[$detail['faq_cat_id']] = $detail['name'];
        }
        return $categoryData;
    }

    /**
     * @return mixed
     */
    public function getfrontOptionArray()
    {
        if (empty($this->_globalcat['optionsdesign'])) {
            $this->_globalcat['optionsdesign'] = [];
        }
        $val = $this->dumpTreedesign();
        return $this->_globalcat['optionsdesign'];
    }

    /**
     * @return array
     */
    public function getAllOptions()
    {
        $result = [];
        foreach (self::getOptionArray() as $index => $value) {
            $result[] = ['label' => $value, 'value' => $index];
        }
        return $result;
    }

    /**
     * @param $optionId
     * @return null
     */
    public function getOptionText($optionId)
    {
        $options = self::getOptionArray();
        return isset($options[$optionId]) ? $options[$optionId] : null;
    }
}