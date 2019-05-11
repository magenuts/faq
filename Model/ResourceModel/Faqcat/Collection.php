<?php
namespace Magenuts\Faq\Model\ResourceModel\Faqcat;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    protected function _construct()
    {
        $this->_init(
            'Magenuts\Faq\Model\Faqcat',
            'Magenuts\Faq\Model\ResourceModel\Faqcat'
        );
    }
}
