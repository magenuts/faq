<?php
namespace Magenuts\Faq\Model;

use Magento\Framework\Model\AbstractModel;

/**
 * Class Faqcat
 * @package Magenuts\Faq\Model
 */
class Faqcat extends AbstractModel
{

    /**
     *
     */
    protected function _construct()
    {
        $this->_init('Magenuts\Faq\Model\ResourceModel\Faqcat');
    }

    /**
     * @param $urlKey
     * @return mixed
     */
    public function checkUrlKey($urlKey)
    {
        return $this->_getResource()->checkUrlKey($urlKey);
    }
}
