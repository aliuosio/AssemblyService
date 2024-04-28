<?php declare(strict_types=1);
/**
 * @author     Osiozekhai Aliu
 * @package    Osio_AssemblyService
 * @copyright  Copyright (c) 2024 Osiozekhai Aliu (https://github.com/aliuosio)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Osio\AssemblyService\Setup\Patch\Data;

use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Model\Entity\Attribute\Source\Boolean;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Validator\ValidateException;
use Osio\AssemblyService\Setup\AttributesAdd;

class AttributeAssemblyService implements DataPatchInterface
{
    const LABEL = 'Assembly Service';
    const CODE = 'assembly_service';

    public function __construct(
        readonly private AttributesAdd $attributesAdd
    ) {}

    private function getAttributeProperties(): array
    {
        return [
            'type' => 'int',
            'label' => self::LABEL,
            'input' => 'boolean',
            'source' => Boolean::class,
            'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
            'visible' => true,
            'required' => false,
            'default' => 0,
            'user_defined' => true,
            'visible_on_front' => true,
            'used_in_product_listing' => false,
            'apply_to' => 'configurable,simple',
        ];
    }

    /**
     * @throws ValidateException
     * @throws LocalizedException
     */
    public function apply(): void
    {
        $this->attributesAdd->getModuleDataSetup()->startSetup();
        $this->attributesAdd->createAttributeGroup();
        $this->attributesAdd->getAddAttribute(self::CODE, $this->getAttributeProperties());
        $this->attributesAdd->addToAttributeSets(self::CODE);
        $this->attributesAdd->getModuleDataSetup()->endSetup();
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
