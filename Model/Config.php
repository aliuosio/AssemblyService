<?php declare(strict_types=1);
/**
 * @author     Osiozekhai Aliu
 * @package    BIWAC_AssemblyService
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

    public function __construct(
        readonly private ScopeConfigInterface $scopeConfig
    ) {}

    public function isEnabled(): bool
    {
        return (bool)$this->scopeConfig->getValue(self::ENABLED);
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

    public function getProductClass(): string
    {
        return $this->scopeConfig->getValue(self::PRODUCT_CLASS);
    }

    public function getAttributeAssemblyName(): string
    {
        return $this->scopeConfig->getValue(self::ATTRIBUTE_ASSEMBLY);
    }

    public function getAssemblyOptionCode(): string
    {
        return $this->scopeConfig->getValue(self::ASSEMBLY_OPTION_CODE);
    }

    public function getAssemblyOptionPrice(): string
    {
        return $this->scopeConfig->getValue(self::ASSEMBLY_OPTION_PRICE);
    }
}
