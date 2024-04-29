<?php declare(strict_types=1);
/**
 * @author     Osiozekhai Aliu
 * @package    Osio_AssemblyService
 * @copyright  Copyright (c) 2024 Osiozekhai Aliu (https://github.com/aliuosio)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace BIWAC\AssemblyService\Model\AttributeValues\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use BIWAC\AssemblyService\Model\ResourceModel\ProductClass\CollectionFactory as OptionCollectionFactory;

class ProductClass extends AbstractSource
{

    public function __construct(
        readonly private OptionCollectionFactory $optionCollectionFactory
    ) {}

    public function getAllOptions(): array
    {
        $options = [];
        $collection = $this->optionCollectionFactory->create();
        foreach ($collection as $item) {
            $options[] = ['label' => $item->getClassId(), 'value' => $item->getClassId()];
        }
        return $options;
    }
}
