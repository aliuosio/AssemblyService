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
        $productClassPath = $this->arrayManager->findPath('product_class', $meta, null, 'children');
        if ($productClassPath) {
            $meta = $this->arrayManager->merge(
                $productClassPath,
                $meta,
                [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'visible' => ($this->data['assembly_service'] == 1)
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

    }
}
