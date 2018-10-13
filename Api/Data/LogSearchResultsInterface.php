<?php

namespace Shulgin\AdminLogging\Api\Data;

/**
 * interface LogSearchResultsInterface
 */
interface LogSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get Log list.
     * @return \Shulgin\AdminLogging\Api\Data\LogInterface[]
     */
    public function getItems();

    /**
     * Set before_save list.
     * @param \Shulgin\AdminLogging\Api\Data\LogInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
