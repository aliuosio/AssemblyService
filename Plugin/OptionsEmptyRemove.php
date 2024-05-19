<?php declare(strict_types=1);
/**
 * @author     Osiozekhai Aliu
 * @package    BIWAC_AssemblyService
 * @copyright  Copyright (c) 2024 Osiozekhai Aliu (https://github.com/aliuosio)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BIWAC\AssemblyService\Plugin;

use Magento\Quote\Model\Quote\Item;

class OptionsEmptyRemove
{

    public function afterGetOptions(Item $subject, $options): array
    {
        $filteredOptions = [];

        foreach ($options as $option) {
            $optionTitle = $option->getTitle();
            $optionValue = $option->getValue();

            // Check if the option title matches the one you want to hide and its value is 0
            if ($optionTitle === 'Custom Option Name' && $optionValue == 0) {
                continue;
            }

            $filteredOptions[] = $option;
        }

        return $filteredOptions;
    }

}
