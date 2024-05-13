<?php declare(strict_types=1);
/**
 * @author     Osiozekhai Aliu
 * @package    BIWAC_AssemblyService
 * @copyright  Copyright (c) 2024 Osiozekhai Aliu (https://github.com/aliuosio)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BIWAC\AssemblyService\Observer\Frontend;

use BIWAC\AssemblyService\Api\ConfigInterface;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Quote\Api\Data\ProductOptionInterfaceFactory;
use Magento\Framework\Event\Observer;
use Magento\Quote\Model\Quote\Item;
use Psr\Log\LoggerInterface;

class AddCustomOptions implements ObserverInterface
{

    public function __construct(
        private readonly ProductOptionInterfaceFactory $productOptionFactory,
        private readonly ConfigInterface               $config,
        private readonly LoggerInterface               $logger
    )
    {
    }

    /**
     * @throws LocalizedException
     */
    public function execute(Observer $observer): void
    {
        /** @var Item $quoteItem */
        $quoteItem = $observer->getEvent()->getQuoteItem();
        $product = $quoteItem->getProduct();

        if ($product && $product->getSku() == $this->config->getSKU()) {
            $postcode = $this->getPostcode();
            $postcodePrice = $this->getPostcodePrice();

            /*
            $postcodeOption = $this->productOptionFactory->create();
            $postcodeOption->setProduct($product->getEntityId());
            $postcodeOption->setLabel('Postcode');
            $postcodeOption->setValue($postcode);
            $postcodeOption->setPrice($postcodePrice);

            $quoteItem->setProductOption($postcodeOption);
            $quoteItem->addOption($postcodeOption);
            */
        }
    }

    private function getPostcode(): string
    {
        return '12345';
    }

    private function getPostcodePrice(): string
    {
        return '10.00';
    }
}
