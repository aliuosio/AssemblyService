<?php declare(strict_types=1);
/**
 * @author     Osiozekhai Aliu
 * @package    BIWAC_AssemblyService
 * @copyright  Copyright (c) 2024 Osiozekhai Aliu (https://github.com/aliuosio)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace BIWAC\AssemblyService\Ui\DataProvider\Product\Form\Modifier;

use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Magento\Framework\Stdlib\ArrayManager;

class ProductClass extends AbstractModifier
{


    public function __construct(
        readonly private ArrayManager $arrayManager,
        readonly private array $data
    ) {
    }

    public function modifyMeta(array $meta): array
    {
        // Retrieve the value of the assembly_service attribute from the data array
        $assemblyServiceValue = $this->data['assembly_service'];

        // Check the condition (e.g., assembly_service value equals 1)
        $isVisible = ($assemblyServiceValue == 1);

        // Modify the meta array for the product_class attribute
        $productClassPath = $this->arrayManager->findPath('product_class', $meta, null, 'children');
        if ($productClassPath) {
            $meta = $this->arrayManager->merge(
                $productClassPath,
                $meta,
                [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'visible' => $isVisible
                            ]
                        ]
                    ]
                ]
            );
        }

        return $meta;
    }

    public function modifyData(array $data)
    {
        // TODO: Implement modifyData() method.
    }
}
