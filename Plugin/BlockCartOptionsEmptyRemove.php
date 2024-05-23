<?php declare(strict_types=1);
/**
 * @author     Osiozekhai Aliu
 * @package    BIWAC_AssemblyService
 * @copyright  Copyright (c) 2024 Osiozekhai Aliu (https://github.com/aliuosio)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */


namespace BIWAC\AssemblyService\Plugin;

use Magento\Quote\Model\Quote\Item;

class BlockCartOptionsEmptyRemove
{

    public function afterGetOptions(Item $item, array $result): array
    {
        foreach ($result as $key => $option) {
            if ($option->getCode() === 'option_3' && $option->getValue() == 0) {
                unset($result[$key]);
            }
        }

        return array_values($result);
    }
}
