<?php
namespace Magenuts\Faq\Model\Config\Source;

/**
 * Class View
 * @package Magenuts\Faq\Model\Config\Source
 */
class View implements \Magento\Framework\Option\ArrayInterface
{

    /**
     * @return array
     */
    public function toOptionArray()
    {
        return
            [
                [
                    'value' => 'collapsed',
                    'label' => 'Collapse All'
                ],
                [
                    'value' => 'expanded',
                    'label' => 'Expand All'
                ],
                [
                    'value' => 'collapse all but expand first',
                    'label' => 'Collapse All but Expand First'
                ]
            ];
    }
}
