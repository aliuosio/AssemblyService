<?php
namespace Osio\AssemblyService\Setup\Patch\Data;

use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Model\Entity\Attribute\Source\Boolean;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Eav\Setup\EavSetup;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Validator\ValidateException;
use Magento\Catalog\Model\Product;

class AttributeAssemblyService implements DataPatchInterface
{
    const CODE = 'assembly_service';
    const LABEL = 'Assembly Service';
    const GROUP = self::LABEL;

    protected EavSetup $eavSetup;

    public function __construct(
        readonly private ModuleDataSetupInterface $moduleDataSetup,
        readonly private EavSetupFactory $eavSetupFactory
    ) {}

    /**
     * @throws ValidateException
     * @throws LocalizedException
     */
    public function apply(): void
    {
        $this->moduleDataSetup->startSetup();
        $this->eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);

        $this->createAttributeGroup();
        $this->getAddAttribute();
        $this->addToAttributeSets();

        $this->moduleDataSetup->endSetup();
    }

    public static function getDependencies(): array
    {
        return [];
    }

    public function getAliases(): array
    {
        return [];
    }

    /**
     * @throws LocalizedException
     * @throws ValidateException
     */
    protected function getAddAttribute(): void
    {
        $this->eavSetup->addAttribute(
            Product::ENTITY,
            self::CODE,
            [
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
            ]
        );
    }

    protected function addToAttributeSets(): void
    {
        $attributeSetIds = $this->eavSetup->getAllAttributeSetIds(Product::ENTITY);
        foreach ($attributeSetIds as $attributeSetId) {
            $this->eavSetup->addAttributeToSet(
                Product::ENTITY,
                $attributeSetId,
                self::GROUP,
                self::CODE
            );
        }
    }

    /**
     * @throws LocalizedException
     */
    protected function createAttributeGroup(): void
    {
        foreach ($this->eavSetup->getAllAttributeSetIds(Product::ENTITY) as $attributeSetId) {
            $entityTypeId = $this->eavSetup->getEntityTypeId(Product::ENTITY);
            $attributeSetId = $this->eavSetup->getAttributeSetId($entityTypeId, $attributeSetId);

            $this->eavSetup->addAttributeGroup(
                $entityTypeId,
                $attributeSetId,
                self::GROUP,
                10
            );
        }
    }

}
