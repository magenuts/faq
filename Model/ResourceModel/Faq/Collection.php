<?php
namespace Magenuts\Faq\Model\ResourceModel\Faq;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    protected function _construct()
    {
        $this->_init(
            'Magenuts\Faq\Model\Faq',
            'Magenuts\Faq\Model\ResourceModel\Faq'
        );
    }
}
