<?php declare(strict_types=1);
/**
 * @author     Osiozekhai Aliu
 * @package    Osio_AssemblyService
 * @copyright  Copyright (c) 2024 Osiozekhai Aliu (https://github.com/aliuosio)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace BIWAC\AssemblyService\Model;

use BIWAC\Api\ConfigInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Config implements ConfigInterface
{

    public const ENABLED = 'BIWAC/settings/enabled';
    public const GROUP_KEY = 'BIWAC/settings/product_edit/group_key';

    public function __construct(
        readonly private ScopeConfigInterface $scopeConfig
    ) {}

    public function isEnabled(): string
    {
        return $this->scopeConfig->getValue(self::ENABLED);
    }

    public function getGroupKey(): string
    {
        return $this->scopeConfig->getValue(self::GROUP_KEY);
    }
}
