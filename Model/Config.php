<?php declare(strict_types=1);
/**
 * @author     Osiozekhai Aliu
 * @package    Osio_AssemblyService
 * @copyright  Copyright (c) 2024 Osiozekhai Aliu (https://github.com/aliuosio)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace BIWAC\AssemblyService\Model;

use BIWAC\AssemblyService\Api\ConfigInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Config implements ConfigInterface
{

    private const ENABLED = 'BIWAC/settings/enabled';
    private const GROUP_KEY = 'BIWAC/settings/product_edit/group_key';
    private const SKU = 'BIWAC/settings/product/sku';
    private const ASSEMBLY_PRICE = 'BIWAC/settings/assembly/price';
    private const ATTRIBUTE_ASSEMBLY = 'BIWAC/settings/product/attribute_name';

    public function __construct(
        readonly private ScopeConfigInterface $scopeConfig
    ) {}

    public function isEnabled(): string
    {
        return $this->scopeConfig->getValue(self::ENABLED);
    }

    public function getGroupKey(): string
    {
        return $this->scopeConfig->getValue(self::GROUP_KEY);
    }

    public function getSKU(): string
    {
        return $this->scopeConfig->getValue(self::SKU);
    }

    public function getAssemblyServicePrice(): string
    {
        return $this->scopeConfig->getValue(self::ASSEMBLY_PRICE);
    }

    public function getAttributeAssemblyName(): string
    {
        return $this->scopeConfig->getValue(self::ATTRIBUTE_ASSEMBLY);
    }
}
