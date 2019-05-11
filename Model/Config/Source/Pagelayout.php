<?php
namespace Magenuts\Faq\Model\Config\Source;

class Pagelayout implements \Magento\Framework\Option\ArrayInterface
{

    public function toOptionArray()
    {
        return
            [
                [
                    'value' => '1column',
                    'label' => __('1column')
                ],
                [
                    'value' => '2columns-left',
                    'label' => __('2columns Left Side Bar')
                ],
                [
                    'value' => '2columns-right',
                    'label' => __('2columns Right Side Bar')
                ],
                [
                    'value' => '3columns',
                    'label' => __('3columns')
                ]
            ];
    }
}
