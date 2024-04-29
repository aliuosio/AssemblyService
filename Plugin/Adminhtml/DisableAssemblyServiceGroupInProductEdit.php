<?php declare(strict_types=1);
/**
 * @author     Osiozekhai Aliu
 * @package    Osio_AssemblyService
 * @copyright  Copyright (c) 2024 Osiozekhai Aliu (https://github.com/aliuosio)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace BIWAC\AssemblyService\Plugin\Adminhtml;

use BIWAC\AssemblyService\Model\Config;

class DisableAssemblyServiceGroupInProductEdit {

    public function __construct(
        readonly private Config $config
    )
    {}

    public function afterGetMeta($subject, $meta)
    {
        if (!$this->config->isEnabled() && $this->config->getGroupKey()) {
            unset($meta[$this->config->getGroupKey()]);
        }

        return $meta;
    }

}
