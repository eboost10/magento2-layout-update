<?php


namespace EBoost\LayoutUpdate\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface LayoutUpdateSearchResultsInterface extends SearchResultsInterface
{

    /**
     * Get list.
     * @return LayoutUpdateInterface[]
     */
    public function getItems();

    /**
     * Set name list.
     * @param LayoutUpdateInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
