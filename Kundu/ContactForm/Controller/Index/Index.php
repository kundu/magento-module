<?php declare(strict_types=1);


namespace Kundu\ContactForm\Controller\Index;


class Index extends \Magento\Framework\App\Action\Action
{

    protected $resultPageFactory;

    /**
     * Constructor
     *
     * @param \Magento\Framework\App\Action\Context  $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * Execute view action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {

        try {
            $post = (array) $this->getRequest()->getPost(); 

            if (!empty($post)) { 
                $button = ($post["submitClick"]);

                if($button =="Send Email"){
                    $name     =  $this->getRequest()->getParam('name');
                    $subject   =  $this->getRequest()->getParam('subject');
                    $email  =  $this->getRequest()->getParam('email');
                    $message  =  $this->getRequest()->getParam('message');
                     
                    $to = '';  
                    $message = $name. "\r\n" . "\r\n".$message; 
                    $headers = "From: ".$email; 
                    if(mail($to,$subject,$message,$headers)){
                        echo "<script>alert('Email Sent Successfully.')</script>"; 
                    } 
                    else{
                        // echo "<script>alert('Problem.')</script>"; 
                    } 

                    $this->_redirect('/');
                     
                } 
    

            } 

            return $this->resultPageFactory->create();
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }


        return $this->resultPageFactory->create();
    }
}

