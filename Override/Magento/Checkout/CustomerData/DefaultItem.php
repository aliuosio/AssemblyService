<?php declare(strict_types=1);
/**
 * @author     Osiozekhai Aliu
 * @package    Osio_AssemblyService
 * @copyright  Copyright (c) 2024 Osio
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Osio\AssemblyService\Override\Magento\Checkout\CustomerData;

use Osio\AssemblyService\Api\ConfigInterface;
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
        if ($this->config->getSKU() == $this->item->getProduct()->getSku()) {
            return false;
        }

        return parent::hasProductUrl();
    }
}
