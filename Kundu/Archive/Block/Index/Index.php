<?php
declare(strict_types=1);

namespace Kundu\Archive\Block\Index;

class Index extends \Magento\Framework\View\Element\Template
{

    protected $_productCollectionFactory;

    protected $_categoryFactory;
        
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,        
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,   
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,     
        array $data = []
    )
    {    
        $this->_productCollectionFactory = $productCollectionFactory;    
        $this->_categoryFactory = $categoryFactory;
        parent::__construct($context, $data);
    }

    public function getProducts(){
        // $collection = $this->_productCollectionFactory->create();
        // $collection->addAttributeToSelect('*'); 
        // $collection->addAttributeToFilter('visibility', 4);
        // $collection->addAttributeToSort('name');




        $categoryId = [7];
        // $category = $this->_categoryFactory->create()->load($categoryId);
        $collection = $this->_productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        // $collection->addCategoryFilter($category);
        $collection->addCategoriesFilter(array('nin' => $categoryId));
        $collection->addAttributeToFilter('visibility', 4);
        $collection->addAttributeToSort('name');
        return $collection;




        // return $collection;
    }
}

