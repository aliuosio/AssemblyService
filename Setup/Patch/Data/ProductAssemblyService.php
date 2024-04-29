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

use Magento\Catalog\Api\Data\ProductInterfaceFactory;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Product\Attribute\Source\Status;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Framework\App\Area;
use Magento\Framework\App\State;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\StateException;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class ProductAssemblyService implements DataPatchInterface
{
    public function __construct(
        readonly private State $appState,
        readonly private ProductInterfaceFactory $productFactory,
        readonly private ProductRepositoryInterface $productRepository
    ) {}

    /**
     * @throws StateException
     * @throws CouldNotSaveException
     * @throws InputException
     * @throws LocalizedException
     */
    public function apply(): void
    {
        $this->appState->setAreaCode(Area::AREA_ADMINHTML);

        $product = $this->productFactory->create();
        $product->setName('Montage Service')
            ->setSku('ASSEMBLY_SERVICE')
            ->setPrice(299.00)
            ->setAttributeSetId(4)
            ->setStatus(Status::STATUS_ENABLED)
            ->setVisibility(Visibility::VISIBILITY_BOTH)
            ->setTypeId('simple');

        $this->productRepository->save($product);
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
