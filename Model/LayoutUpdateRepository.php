<?php
/**
 * Created by Steven.
 */
declare(strict_types=1);

namespace EBoost\LayoutUpdate\Model;

use EBoost\LayoutUpdate\Api\Data\LayoutUpdateInterface;
use EBoost\LayoutUpdate\Api\Data\LayoutUpdateInterfaceFactory;
use EBoost\LayoutUpdate\Api\Data\LayoutUpdateSearchResultsInterfaceFactory;
use EBoost\LayoutUpdate\Api\LayoutUpdateRepositoryInterface;
use EBoost\LayoutUpdate\Model\ResourceModel\LayoutUpdate as ResourceLayoutUpdate;
use EBoost\LayoutUpdate\Model\ResourceModel\LayoutUpdate\CollectionFactory as LayoutUpdateCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class LayoutUpdateRepository implements LayoutUpdateRepositoryInterface
{
    /**
     * @var CollectionProcessorInterface
     */
    protected $collectionProcessor;

    /**
     * @var LayoutUpdate
     */
    protected $searchResultsFactory;

    /**
     * @var LayoutUpdateInterfaceFactory
     */
    protected $layoutUpdateFactory;

    /**
     * @var LayoutUpdateCollectionFactory
     */
    protected $layoutUpdateCollectionFactory;

    /**
     * @var ResourceLayoutUpdate
     */
    protected $resource;


    /**
     * @param ResourceLayoutUpdate $resource
     * @param LayoutUpdateInterfaceFactory $layoutUpdateFactory
     * @param LayoutUpdateCollectionFactory $layoutUpdateCollectionFactory
     * @param LayoutUpdateSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourceLayoutUpdate $resource,
        LayoutUpdateInterfaceFactory $layoutUpdateFactory,
        LayoutUpdateCollectionFactory $layoutUpdateCollectionFactory,
        LayoutUpdateSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->layoutUpdateFactory = $layoutUpdateFactory;
        $this->layoutUpdateCollectionFactory = $layoutUpdateCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @inheritDoc
     */
    public function save(LayoutUpdateInterface $layoutUpdate)
    {
        try {
            $this->resource->save($layoutUpdate);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the layoutUpdate: %1',
                $exception->getMessage()
            ));
        }
        return $layoutUpdate;
    }

    /**
     * @inheritDoc
     */
    public function get($layoutUpdateId)
    {
        $layoutUpdate = $this->layoutUpdateFactory->create();
        $this->resource->load($layoutUpdate, $layoutUpdateId);
        if (!$layoutUpdate->getId()) {
            throw new NoSuchEntityException(__('layout_update with id "%1" does not exist.', $layoutUpdateId));
        }
        return $layoutUpdate;
    }

    /**
     * @inheritDoc
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->layoutUpdateCollectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $items = [];
        foreach ($collection as $model) {
            $items[] = $model;
        }

        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * @inheritDoc
     */
    public function delete(LayoutUpdateInterface $layoutUpdate)
    {
        try {
            $layoutUpdateModel = $this->layoutUpdateFactory->create();
            $this->resource->load($layoutUpdateModel, $layoutUpdate->getLayoutUpdateId());
            $this->resource->delete($layoutUpdateModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the layout_update: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteById($layoutUpdateId)
    {
        return $this->delete($this->get($layoutUpdateId));
    }
}