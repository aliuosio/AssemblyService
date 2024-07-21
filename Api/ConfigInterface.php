<?php declare(strict_types=1);
/**
 * @author     Osiozekhai Aliu
 * @package    Osio_AssemblyService
 * @copyright  Copyright (c) 2024 Osio
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Osio\AssemblyService\Api;


interface ConfigInterface
{
    public const ENABLED = 'Osio/settings/enabled';
    public const GROUP_KEY = 'Osio/settings/product_edit/group_key';
    public const SKU = 'Osio/settings/product/sku';
    public const NAME = 'Osio/settings/product/name';
    public const ATTRIBUTE_ASSEMBLY = 'Osio/settings/product/attribute_name';
    public const PRODUCT_CLASS = 'Osio/settings/product/class';
    public const ASSEMBLY_PRICE = 'Osio/settings/assembly/price';
    public const ASSEMBLY_OPTION_CODE = 'Osio/settings/assembly/options/code';
    public const ASSEMBLY_OPTION_PRICE= 'Osio/settings/assembly/options/price';
    public const ASSEMBLY_OPTIONS= 'Osio/settings/assembly/options';

    public function isEnabled(): bool;

    public function getGroupKey(): string;

    public function getSKU(): string;

    public function getAssemblyServicePrice(): string;

    public function getProductClass(): string;

    public function getAttributeAssemblyName(): string;

    public function getAssemblyOptionCode(): string;

    public function getAssemblyOptionPrice(): string;

    public function getAssemblyOptions(): array;

    public function getName(): string;

}
