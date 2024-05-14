<?php declare(strict_types=1);
/**
 * @author     Osiozekhai Aliu
 * @package    Osio_AssemblyService
 * @copyright  Copyright (c) 2024 Osiozekhai Aliu (https://github.com/aliuosio)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BIWAC\AssemblyService\Plugin;

use BIWAC\AssemblyService\Api\ConfigInterface;
use Magento\Quote\Model\Quote\Item;

class AddCustomOptionPriceToPostCode
{

    public function __construct
    (
        private readonly ConfigInterface $config
    )
    {
    }


    public function beforeSave(Item $subject): array
    {
        $subjectSku = $subject->getSku();
        $configSku = $this->config->getSKU();
        if ($subject->getSku() != $this->config->getSKU()) {
            return [];
        }


        $selectedOption = $this->getSelectedCustomOption($subject);
        $additionalPrice = 0;
        if ($selectedOption === 'option1') {
            $additionalPrice = 10;
        } elseif ($selectedOption === 'option2') {
            $additionalPrice = 20;
        }
        $originalPrice = $subject->getProduct()->getPrice();

        $newPrice = $originalPrice + $additionalPrice;

        $subject->setCustomPrice($newPrice);
        $subject->setOriginalCustomPrice($newPrice);

        return $selectedOption;
    }

    protected function getSelectedCustomOption(Item $item): array
    {
        $result = [];
        $productOptions = $item->getProduct()->getTypeInstance(true)->getOrderOptions($item->getProduct());
        $allOptions = $productOptions['options'];

        if (isset($productOptions['options'])) {
            foreach ($productOptions['options'] as $option) {
                if ($option['label'] == 'postcode') {
                    $result['postcode'] = $option['value']; // This is the selected custom option value
                }
                if ($option['label'] == 'class-id') {
                    $result['class-id'] = $option['value']; // This is the selected custom option value
                }
            }
        }

        return $result;
    }
}
