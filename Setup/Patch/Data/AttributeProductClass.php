<?php declare(strict_types=1);
/**
 * @author     Osiozekhai Aliu
 * @package    BIWAC_AssemblyService
 * @copyright  Copyright (c) 2024 Osiozekhai Aliu (https://github.com/aliuBIWAC)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BIWAC\AssemblyService\Setup\Patch\Data;

use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Validator\ValidateException;
use BIWAC\AssemblyService\Setup\AttributeAdd;

class AttributeProductClass implements DataPatchInterface
{
    const LABEL = 'Product Class';
    const CODE = 'product_class';

    public function __construct(
        readonly private AttributeAdd $attributeAdd
    ) {}

    private function getAttributeProperties(): array
    {
        return [
            'type' => 'int',
            'label' => self::LABEL,
            'input' => 'select',
            'source' => 'BIWAC\AssemblyService\Model\AttributeValues\Source\ProductClass',
            'required' => false,
            'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
            'visible' => true,
            'user_defined' => true,
            'searchable' => false,
            'filterable' => false,
            'comparable' => false,
            'visible_on_front' => false,
            'used_in_product_listing' => true,
            'unique' => false
        ];
    }

    /**
     * @throws ValidateException
     * @throws LocalizedException
     */
    public function apply(): void
    {
        $this->attributeAdd->run(self::CODE, $this->getAttributeProperties());
    }

    public static function getDependencies(): array
    {
        return [];
    }

    public function getAliases(): array
    {
        return [];
    }

}
