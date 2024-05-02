<?php declare(strict_types=1);

namespace BIWAC\AssemblyService\Setup\Patch\Data;

use BIWAC\AssemblyService\Api\ConfigInterface;
use Magento\Catalog\Api\Data\ProductCustomOptionInterface;
use Magento\Catalog\Api\Data\ProductCustomOptionInterfaceFactory;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\Data\ProductInterfaceFactory;
use Magento\Catalog\Api\ProductCustomOptionRepositoryInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Product\Attribute\Source\Status;
use Magento\Catalog\Model\Product\Visibility;
use Magento\CatalogInventory\Model\StockRegistry;
use Magento\Framework\App\Area;
use Magento\Framework\App\State;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class ProductAssemblyService implements DataPatchInterface
{
    const OPTIONS = [
        '0' => [
            'sort_order' => '1',
            'title' => 'Product to Assemble SKU',
            'price_type' => 'fixed',
            'price' => '0',
            'type' => 'field',
            'is_require' => '1',
            'is_hidden' => '1',
        ],
        '1' => [
            'sort_order' => '2',
            'title' => 'Product Class Price',
            'price_type' => 'fixed',
            'price' => '0',
            'type' => 'field',
            'is_require' => '0',
            'is_hidden' => '1',
        ]
    ];

    public function __construct(
        readonly private ConfigInterface                        $config,
        readonly private State                                  $appState,
        readonly private ProductInterfaceFactory                $productFactory,
        readonly private ProductRepositoryInterface             $productRepository,
        readonly private StockRegistry                          $stockRegistry,
        readonly private ProductCustomOptionInterfaceFactory    $customOptionFactory,
        readonly private ProductCustomOptionRepositoryInterface $customOptionRepository
    )
    {
    }

    /**
     * @throws NoSuchEntityException
     * @throws StateException
     * @throws CouldNotSaveException
     * @throws LocalizedException
     * @throws InputException
     */
    public function apply(): void
    {
        $this->appState->setAreaCode(Area::AREA_ADMINHTML);

        $product = $this->setProduct();
        $this->setStock($product);
        $this->addCustomOptions($product);
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
     * @throws CouldNotSaveException
     * @throws StateException
     * @throws InputException
     */
    private function setProduct(): ProductInterface
    {
        $product = $this->productFactory->create();
        $product->setName('Montage Service')
            ->setSku($this->config->getSKU())
            ->setPrice($this->config->getAssemblyServicePrice())
            ->setAttributeSetId(4)
            ->setStatus(Status::STATUS_ENABLED)
            ->setVisibility(Visibility::VISIBILITY_BOTH)
            ->setTypeId('simple');

        $this->productRepository->save($product);

        return $product;
    }

    /**
     * @throws NoSuchEntityException
     */
    private function setStock(ProductInterface $product): void
    {
        $this->stockRegistry->updateStockItemBySku(
            $product->getSku(),
            $this->stockRegistry
                ->getStockItemBySku($product->getSku())->setQty(9999999)
                ->setIsInStock(true)
        );
    }

    private function addCustomOptions(ProductInterface $product): void
    {
        foreach (self::OPTIONS as $arrayOption) {
            $option = $this->customOptionFactory->create();
            $option->setProductId($product->getId())
                ->setProductSku($product->getSku())
                ->setStoreId($product->getStoreId())
                ->addData($arrayOption);
            $this->customOptionRepository->save($option);
            $product->addOption($option);
        }
    }
}
