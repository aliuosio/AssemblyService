<?php declare(strict_types=1);
/**
 * @author     Osiozekhai Aliu
 * @package    BIWAC_AssemblyService
 * @copyright  Copyright (c) 2024 BIWAC
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace BIWAC\AssemblyService\Observer;

use BIWAC\AssemblyService\Api\ConfigInterface;
use BIWAC\ProductClassToPostcode\Model\ProductClassFactory;
use Magento\Catalog\Model\Product;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Quote\Model\Quote\Item;

class AddCustomOptionPriceToPostCode implements ObserverInterface
{

    public function __construct(
        readonly private ConfigInterface     $config,
        readonly private Http                $request,
        readonly private ProductClassFactory $productClassFactory
    )
    {
    }

    /**
     * @throws LocalizedException
     */
    public function execute(Observer $observer): void
    {
        /** @var Item $item */
        $item = $observer->getEvent()->getData('quote_item');

        /** @var Product $product */
        $product = $observer->getEvent()->getData('product');

        if ($this->config->getSKU() == $product->getSku()) {
            $item = ($item->getParentItem() ? $item->getParentItem() : $item);
            $price = $product->getPrice() + $this->getCustomPrice();
            $item->setCustomPrice($price);
            $item->setOriginalCustomPrice($price);
            $item->getProduct()->setIsSuperMode(true);
        }
    }

    /**
     * @throws LocalizedException
     */
    private function getCustomPrice(): bool|string
    {
        $options = $this->request->getParam('options');

        return $this->productClassFactory->create()
            ->getPostcodePrice(
                $options[4],
                $options[3]
            );
    }
}
