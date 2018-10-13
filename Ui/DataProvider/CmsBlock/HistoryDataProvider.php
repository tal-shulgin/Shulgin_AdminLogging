<?php 

namespace Shulgin\AdminLogging\Ui\DataProvider\CmsBlock;

use Shulgin\AdminLogging\Model\ResourceModel\Log\CollectionFactory;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\ReportingInterface;
use Magento\Framework\Api\Search\SearchCriteria;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\App\RequestInterface;

/**
 * Class DataProvider
 */
class HistoryDataProvider extends \Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider
{
    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param ReportingInterface $reporting
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param RequestInterface $request
     * @param FilterBuilder $filterBuilder
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        ReportingInterface $reporting,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        RequestInterface $request,
        FilterBuilder $filterBuilder,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct(
            $request, 
            $filterBuilder, 
            $name, 
            $primaryFieldName, 
            $requestFieldName, 
            $reporting, 
            $searchCriteriaBuilder, 
            $meta,
            $data
        );
    }

    /**
     * @return AbstractCollection
     */
/*     public function getCollection()
    {
        $id = (int)$this->request->getParam('block_id');
        
        $this->collection->addFieldToFilter('block_id', ['eq' => $id ]);
        return $this->collection;
    } */
}