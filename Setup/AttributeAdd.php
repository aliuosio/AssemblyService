<?php declare(strict_types=1);
/**
 * @author     Osiozekhai Aliu
 * @package    BIWAC_AssemblyService
 * @copyright  Copyright (c) 2024 Osiozekhai Aliu (https://github.com/aliuBIWAC)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BIWAC\AssemblyService\Setup;

use Magento\Catalog\Model\Product;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Validator\ValidateException;

class AttributeAdd
{
    const GROUP = 'Assembly Service';

    public function __construct(
        readonly private ModuleDataSetupInterface $moduleDataSetup,
        readonly private EavSetupFactory $eavSetupFactory
    ) {}

    public function getModuleDataSetup(): ModuleDataSetupInterface
    {
        return  $this->moduleDataSetup;
    }

    public function getEavSetup(): EavSetup
    {
        return $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
    }

    public function addToAttributeSets(string $code): void
    {
        $attributeSetIds = $this->getEavSetup()->getAllAttributeSetIds(Product::ENTITY);
        foreach ($attributeSetIds as $attributeSetId) {
            $this->getEavSetup()->addAttributeToSet(
                Product::ENTITY,
                $attributeSetId,
                self::GROUP,
                $code
            );
        }
    }

    /**
     * @throws LocalizedException
     */
    public function createAttributeGroup(): void
    {
        foreach ($this->getEavSetup()->getAllAttributeSetIds(Product::ENTITY) as $attributeSetId) {
            $entityTypeId = $this->getEavSetup()->getEntityTypeId(Product::ENTITY);
            $attributeSetId = $this->getEavSetup()->getAttributeSetId($entityTypeId, $attributeSetId);

            $this->getEavSetup()->addAttributeGroup(
                $entityTypeId,
                $attributeSetId,
                self::GROUP,
                10
            );
        }
    }

    /**
     * @throws LocalizedException
     * @throws ValidateException
     */
    public function getAddAttribute(string $code, array $attributeProperties): void
    {
        $this->getEavSetup()->addAttribute(
            Product::ENTITY,
            $code,
            $attributeProperties
        );
    }

    /**
     * @throws LocalizedException
     * @throws ValidateException
     */
    public function run(string $code, array $attributes): void
    {
        $this->getModuleDataSetup()->startSetup();
        $this->createAttributeGroup();
        $this->getAddAttribute($code, $attributes);
        $this->addToAttributeSets($code);
        $this->getModuleDataSetup()->endSetup();
    }

}
