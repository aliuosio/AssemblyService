<?php
namespace BIWAC\AssemblyService\Controller\Price;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\Controller\Result\Json;
use BIWAC\ProductClassToPostcode\Model\ResourceModel\ProductClass\CollectionFactory as ProductClassCollectionFactory;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\App\Request\Http;

class Index implements ActionInterface
{
    public function __construct(
        readonly private JsonFactory $resultJsonFactory,
        readonly private ProductClassCollectionFactory $productClassCollectionFactory,
        readonly private Http $request
    ) {}

    public function execute(): Json
    {
        $result = $this->resultJsonFactory->create();
        return $result->setData([
            'success' => true,
            'price' => $this->getPostcodePrice($this->request->getParam('postcode'))
        ]);
    }

    protected function getPostcodePrice(int $postcode): float|int
    {
        $price = 0;

        $collection = $this->productClassCollectionFactory->create();
        $collection->addFieldToFilter('postcode', ['eq' => $postcode])
            ->setPageSize(1);

        if ($collection->getSize() > 0) {
            $price = $collection->getFirstItem()->getPrice();
        }

        return $price;
    }
}
