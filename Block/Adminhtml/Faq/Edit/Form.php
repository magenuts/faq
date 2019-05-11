<?php
namespace Magenuts\Faq\Block\Adminhtml\Faq\Edit;

/**
 * Class Form
 * @package Magenuts\Faq\Block\Adminhtml\Faq\Edit
 */
class Form extends \Magento\Backend\Block\Widget\Form\Generic
{

    /**
     * @return mixed
     */
    protected $_formFactory;

    /**
     * @return mixed
     */
    protected function _prepareForm()
    {
        $form = $this->_formFactory->create(
            [
                'data' => [
                    'id' => 'edit_form',
                    'action' => $this->getUrl('*/*/save'),
                    'method' => 'post',
                    'enctype' => 'multipart/form-data',
                ],
            ]
        );
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
