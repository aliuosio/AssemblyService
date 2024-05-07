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
use Magento\Framework\Data\Form\FormKey;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Pricing\Helper\Data as PriceHeloer;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class ProductAssemblyService extends Template
{

    public function __construct(
        readonly private FormKey                    $formKey,
        readonly private PriceHeloer                $priceHeloer,
        readonly private ConfigInterface            $config,
        readonly private ProductRepositoryInterface $productRepository,
        Context                                     $context,
        array                                       $data = []
    )
    {
        parent::__construct($context, $data);
    }

    /**
     * @throws NoSuchEntityException
     */
    public function getProduct(): ProductInterface
    {
        return $this->productRepository->get($this->config->getSKU());
    }

    public function getAddToCartUrl(): string
    {
        try {
            return $this->getUrl(
                'checkout/cart/add',
                ['_query' => $this->getAllCustomOptions()]
            );
        } catch (NoSuchEntityException $e) {
            return '';
        } catch (LocalizedException $e) {
        }
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

    public function getOptionValues(): array
    {
        return [
            $this->getParentProduct()->getName(),
            $this->getParentProduct()->getSku(),
            $this->getParentProduct()->getData('product_class'),
            0
        ];
    }

    public function getPriceFormattted(float $price): float|string
    {
        return $this->priceHeloer->currency($price);
    }

    /**
     * @throws NoSuchEntityException
     */
    public function getCustomOptions(): array
    {
        return array_combine($this->extractingIDsFromProductOptions(), $this->getOptionValues());
    }

    /**
     * @throws NoSuchEntityException
     */
    public function extractingIDsFromProductOptions(): array
    {
        return array_map(function ($option) {
            return $option->getId();
        }, $this->getProduct()->getOptions());
    }

    /**
     * @throws NoSuchEntityException
     */
    public function getAssemblyCustomOptions(): array
    {
        $customOptions = [];
        $options = $this->getProduct()->getOptions();

        for ($i = 0; $i < count($options); $i++) {
            $customOptions[$options[$i]->getId()] = $this->getOptionValues()[$i];
        }

        return $customOptions;
    }


    /**
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function getAllCustomOptions(): array
    {
        return [
            'product' => $this->getProduct()->getId(),
            'form_key' => $this->formKey->getFormKey(),
            'options' => $this->getAssemblyCustomOptions(),
        ];
    }

    /**
     * @param int $i
     * @return string
     * @throws NoSuchEntityException
     */
    public function getTitle(int $i): string
    {
        return $this->getProduct()->getOptions()[$i]->getTitle();
    }
}
