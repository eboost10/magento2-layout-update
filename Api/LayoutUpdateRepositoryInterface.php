<?php
/**
 * Created by Steven.
 */
declare(strict_types=1);

namespace EBoost\LayoutUpdate\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface LayoutUpdateRepositoryInterface
{
    /**
     * Save layout_update
     * @param \EBoost\LayoutUpdate\Api\Data\LayoutUpdateInterface $layoutUpdate
     * @return \EBoost\LayoutUpdate\Api\Data\LayoutUpdateInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \EBoost\LayoutUpdate\Api\Data\LayoutUpdateInterface $layoutUpdate
    );

    /**
     * Retrieve layout_update
     * @param string $layoutUpdateId
     * @return \EBoost\LayoutUpdate\Api\Data\LayoutUpdateInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($layoutUpdateId);

    /**
     * Retrieve layout_update matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \EBoost\LayoutUpdate\Api\Data\LayoutUpdateSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete layout_update
     * @param \EBoost\LayoutUpdate\Api\Data\LayoutUpdateInterface $layoutUpdate
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \EBoost\LayoutUpdate\Api\Data\LayoutUpdateInterface $layoutUpdate
    );

    /**
     * Delete layout_update by ID
     * @param string $layoutUpdateId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($layoutUpdateId);
}