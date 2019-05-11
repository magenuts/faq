<?php
namespace Magenuts\Faq\Model;

/**
 * Class Faqcategory
 * @package Magenuts\Faq\Model
 */
class Faqcategory extends \Magento\Framework\View\Element\Template implements \Magento\Framework\Option\ArrayInterface
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
     * @var
     */
    protected $_globalCategory;

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $result = [];
        foreach (self::getOptionArray() as $index => $values) {
            $result[] = ['value' => $index, 'label' => $values];
        }
        return $result;
    }

    /**
     * Faqcategory constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param FaqcatFactory $faqCategoryFactory
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
    public function hasChild($id)
    {
        $faqModel = $this->_faqCategoryFactory->create();
        $faqCollection = $faqModel->load($id);
        if (count($faqCollection) > 0) {
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
        $faqModel = $this->_faqCategoryFactory->create();
        $faqCollection = $faqModel->getCollection()
            ->addFieldToFilter('is_active', 1);
        $non = html_entity_decode(
            '&#160;',
            ENT_NOQUOTES,
            'UTF-8'
        );
        foreach ($faqCollection AS $category) {
            if ($parent == $category['parent_cat_id']) {
                $this->_globalCategory['options']
                [$category['faq_cat_id']] =
                    str_repeat(
                        $non,
                        $level * 4
                    ) . $category['name'];
                if ($this->hasChild($category['faq_cat_id'])) {
                    $this->dumpTree($category['faq_cat_id'], $level + 1);
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
        $faqModel = $this->_faqCategoryFactory->create();
        $faqCollection = $faqModel->getCollection()
            ->addFieldToFilter('is_active', 1);
        $non = html_entity_decode(
            '&#160;',
            ENT_NOQUOTES,
            'UTF-8'
        );
        foreach ($faqCollection AS $category) {
            if ($parent == $category['parent_cat_id']) {
                $this->_globalCategory['optionsdesign']
                [$category['faq_cat_id']] =
                    $category['url_key'] .
                    '*' .
                    str_repeat(
                        $non,
                        $level * 4) .
                    $category['name'];
                if ($this->hasChild($category['faq_cat_id'])) {
                    $this->dumpTreedesign($category['faq_cat_id'], $level + 1);
                }
            }
        }
    }

    /**
     * @return mixed
     */
    public function getOptionArraytwo()
    {
        $this->_globalCategory['options'][0] = 'Create Parent';
        return $this->_globalCategory['options'];
    }

    /**
     * @return mixed
     */
    public function getOptionArray()
    {
        if (!isset($this->_globalCategory['options'])) {
            $this->_globalCategory['options'] = [];
        }
        return $this->_globalCategory['options'];
    }

    /**
     * @return mixed
     */
    public function getfrontOptionArray()
    {
        if (empty($this->_globalCategory['optionsdesign'])) {
            $this->_globalCategory['optionsdesign'] = [];
        }
        return $this->_globalCategory['optionsdesign'];
    }

    /**
     * @return array
     */
    public function getAllOptions()
    {
        $result = [];
        foreach (self::getOptionArray() as $index => $values) {
            $result[] = ['label' => $values, 'value' => $index];
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