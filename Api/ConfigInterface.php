<?php declare(strict_types=1);
/**
 * @author     Osiozekhai Aliu
 * @package    BIWAC_AssemblyService
 * @copyright  Copyright (c) 2024 BIWAC
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BIWAC\AssemblyService\Api;


interface ConfigInterface
{
    public const ENABLED = 'BIWAC/settings/enabled';
    public const GROUP_KEY = 'BIWAC/settings/product_edit/group_key';
    public const SKU = 'BIWAC/settings/product/sku';
    public const ATTRIBUTE_ASSEMBLY = 'BIWAC/settings/product/attribute_name';
    public const PRODUCT_CLASS = 'BIWAC/settings/product/class';
    public const ASSEMBLY_PRICE = 'BIWAC/settings/assembly/price';
    public const ASSEMBLY_OPTION_CODE = 'BIWAC/settings/assembly/options/code';
    public const ASSEMBLY_OPTION_PRICE= 'BIWAC/settings/assembly/options/price';

    public function isEnabled(): bool;

    public function getGroupKey(): string;

    public function getSKU(): string;

    public function getAssemblyServicePrice(): string;

    public function getProductClass(): string;

    public function getAttributeAssemblyName(): string;

    public function getAssemblyOptionCode(): string;

    public function getAssemblyOptionPrice(): string;

}
