<?php declare(strict_types=1);
/**
 * @author     Osiozekhai Aliu
 * @package    Osio_AssemblyService
 * @copyright  Copyright (c) 2024 Osiozekhai Aliu (https://github.com/aliuosio)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Osio\AssemblyService\Plugin\Adminhtml;

use Osio\AssemblyService\Api\ConfigInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class DisableAssemblyServiceGroupInProductEdit
{

    public function __construct(
        readonly private ConfigInterface $config,
        readonly private ProductRepositoryInterface $productRepository,
        readonly private RequestInterface $request
    ) {
    }

    public function afterGetMeta($subject, $meta)
    {
        if (!$this->config->isEnabled() || $this->isAssemblyProduct()) {
            unset($meta[$this->config->getGroupKey()]);
        }

        return $meta;
    }

    private function isAssemblyProduct(): bool
    {
        return $this->getProductSku() == $this->config->getSKU();
    }

    private function getProductSku(): ?string
    {
        try {
            return $this->productRepository
                ->getById($this->request->getParam('id'))
                ->getSku();
        } catch (NoSuchEntityException $e) {
            return null;
        }
    }

}
