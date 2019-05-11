<?php
namespace Magenuts\Faq\Model;

use Magento\Framework\Model\AbstractModel;

/**
 * Class Faq
 * @package Magenuts\Faq\Model
 */
class Faq extends AbstractModel
{

    /**
     *
     */
    protected function _construct()
    {
        $this->_init('Magenuts\Faq\Model\ResourceModel\Faq');
    }
}
