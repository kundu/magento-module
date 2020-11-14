<?php declare(strict_types=1);


namespace Kundu\ContactForm\Block\Index;


class Index extends \Magento\Framework\View\Element\Template
{

    /**
     * Constructor
     *
     * @param \Magento\Framework\View\Element\Template\Context  $context
     * @param \Magento\Framework\Data\Form\FormKey $formKey
     * @param array $data
     */


    public function __construct(
       \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Data\Form\FormKey $formKey,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->formKey = $formKey;
    }


    public function _prepareLayout(){   
        $this->pageConfig->getTitle()->set(__('Contact Us'));   
        return parent::_prepareLayout();  
    } 
    
    
    /**
     * get form key
     *
     * @return string
    */
    public function getFormKey()
    {
         return $this->formKey->getFormKey();
    }
}

