<?php
namespace Magenuts\Faq\Model\ResourceModel;

use Magento\Store\Model\Store;
use Magento\Framework\DB\Select;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Faq extends AbstractDb
{

    protected $store = null;
    protected $connection = null;

    protected function _construct()
    {
        $this->_init('magentician_faq', 'faq_id');
    }

    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context
    )
    {
        parent::__construct($context);
    }
}
