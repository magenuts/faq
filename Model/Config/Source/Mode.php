<?php
namespace Magenuts\Faq\Model\Config\Source;

class Mode implements \Magento\Framework\Option\ArrayInterface
{

    public function toOptionArray()
    {
        return [
            ['value' => 'normal', 'label' => 'Normal'],
            ['value' => 'category', 'label' => 'Category Wise']
        ];
    }
}
