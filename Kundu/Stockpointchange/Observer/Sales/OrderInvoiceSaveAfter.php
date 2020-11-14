<?php
declare(strict_types=1);

namespace Kundu\Stockpointchange\Observer\Sales;

use Magento\CatalogInventory\Api\StockRegistryInterface;
use Magento\Catalog\Model\ProductRepository;

class OrderInvoiceSaveAfter implements \Magento\Framework\Event\ObserverInterface
{


    protected $productRepository;
    protected $stockRegistry;
    public function __construct(
        ProductRepository $productRepository,
        StockRegistryInterface $stockRegistry
    )
    {
        $this->productRepository = $productRepository;
        $this->stockRegistry = $stockRegistry;
    }

    /**
     * Execute observer
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(
        \Magento\Framework\Event\Observer $observer
    ) {
        try {
            $invoice = $observer->getEvent()->getInvoice();
            $invoiceItems = $invoice->getAllItems();
            foreach ($invoiceItems as $item) {
                $productId = $item->getProductId();
                $product = $this->productRepository->getById($productId);
                $sku = $product->getSku();
                $stockItem = $this->stockRegistry->getStockItemBySku($sku);
                $qty = $stockItem->getQty() - $item->getQty();
                $stockItem->setQty($qty);
                $stockItem->setIsInStock((bool)$qty);
                $this->stockRegistry->updateStockItemBySku($sku, $stockItem);
            }

            $objectManagerKundu = \Magento\Framework\App\ObjectManager::getInstance(); 
            $emailSenderKundu = $objectManagerKundu->create('\Magento\Sales\Model\Order\Email\Sender\InvoiceSender');
            $emailSenderKundu->send($invoice); 

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}

