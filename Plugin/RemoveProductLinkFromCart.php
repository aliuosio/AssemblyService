<?php

namespace Osio\AssemblyService\Plugin;

use Osio\AssemblyService\Api\ConfigInterface;
use Magento\Checkout\Block\Cart\Item\Renderer;

class RemoveProductLinkFromCart
{

    public function __construct(
        readonly private ConfigInterface $config
    )
    {
    }

    /**
     * if assembly service is in cart.remove link assigned to it.
     *
     * @param Renderer $subject
     * @param bool $result
     * @return bool
     */
    public function afterHasProductUrl(Renderer $subject, bool $result): bool
    {
        return $this->config->getSKU() == $subject->getProduct()->getSku() ? false : $result;
    }
}
