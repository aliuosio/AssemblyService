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

use Magento\Framework\Model\AbstractModel;
use BIWAC\AssemblyService\Model\ResourceModel\ProductClass as ResourceProductClass;

class ProductClass extends AbstractModel
{
    protected function _construct(): void
    {
        $this->_init(ResourceProductClass::class);
    }
}
