<?php declare(strict_types=1);
/**
 * @author     Osiozekhai Aliu
 * @package    BIWAC_AssemblyService
 * @copyright  Copyright (c) 2024 BIWAC
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace BIWAC\AssemblyService\Override\Magento\Checkout\CustomerData;

use BIWAC\AssemblyService\Api\ConfigInterface;
use Magento\Catalog\Helper\Image;
use Magento\Catalog\Helper\Product\ConfigurationPool;
use Magento\Catalog\Model\Product\Configuration\Item\ItemResolverInterface;
use Magento\Checkout\CustomerData\DefaultItem as DefaultItemAOriginal;
use Magento\Checkout\Helper\Data as DataAlias;
use Magento\Framework\Escaper;
use Magento\Framework\UrlInterface;
use Magento\Msrp\Helper\Data;

class DefaultItem extends DefaultItemAOriginal
{

    public function __construct(
        readonly private ConfigInterface $config,
        Image                            $imageHelper,
        Data                             $msrpHelper,
        UrlInterface                     $urlBuilder,
        ConfigurationPool                $configurationPool,
        DataAlias                        $checkoutHelper,
        Escaper                          $escaper = null,
        ItemResolverInterface            $itemResolver = null
    )
    {
        parent::__construct($imageHelper, $msrpHelper, $urlBuilder, $configurationPool, $checkoutHelper, $escaper, $itemResolver);
    }

    protected function hasProductUrl(): bool
    {
        if ($this->item->getRedirectUrl()) {
            return true;
        }

        $product = $this->item->getProduct();

        /** ovverride START */
        if ($this->config->getSKU() == $product->getSku()) {
            return false;
        }
        /** ovverride END */

        $option = $this->item->getOptionByCode('product_type');
        if ($option) {
            $product = $option->getProduct();
        }

        if ($product->isVisibleInSiteVisibility()) {
            return true;
        } else {
            if ($product->hasUrlDataObject()) {
                $data = $product->getUrlDataObject();
                if (in_array($data->getVisibility(), $product->getVisibleInSiteVisibilities())) {
                    return true;
                }
            }
        }

        return false;
    }
}
