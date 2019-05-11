<?php
namespace Magenuts\Faq\Model\Config\Source;

class Sorting implements \Magento\Framework\Option\ArrayInterface
{

    public function toOptionArray()
    {
        return
            [
                [
                    'value' => 'desc',
                    'label' => __('Newest First')
                ],
                [
                    'value' => 'asc',
                    'label' => __('Oldest First')
                ]
            ];
    }

    public function toArray()
    {
        return [0 => __('Oldest'), 1 => __('Newest')];
    }
}
