<?php declare(strict_types=1);
/**
 * @author     Osiozekhai Aliu
 * @package    BIWAC_AssemblyService
 * @copyright  Copyright (c) 2024 BIWAC
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BIWAC\AssemblyService\Block;

use BIWAC\AssemblyService\Api\ConfigInterface;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Block\Product\ListProduct;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Registry;

class ProductAssemblyService extends Template
{

    public function __construct(
        readonly private ListProduct $listProduct,
        readonly private ConfigInterface $config,
        readonly private ProductRepositoryInterface $productRepository,
        Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * @throws NoSuchEntityException
     */
    public function getProduct(): ProductInterface
    {
        return $this->productRepository->get($this->config->getSKU());
    }

    /**
     * @throws NoSuchEntityException
     */
    public function getAddToCartUrl(): string
    {
        return $this->listProduct->getAddToCartUrl($this->getProduct());
    }

    public function getConfig(): ConfigInterface
    {
        return $this->config;
    }

    public function getParentProduct(): ?ProductInterface
    {
        try {
            return $this->productRepository->getById(
                $this->getRequest()->getParam('id')
            );
        } catch (NoSuchEntityException $e) {
            return null;
        }
    }

    public function hasParentAssemblyService(): bool
    {
        return (bool)$this->getParentProduct()->getData(
            $this->getConfig()->getAttributeAssemblyName()
        );
    }
}