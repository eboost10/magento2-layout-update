<?php
/**
 * Created by Steven.
 */
declare(strict_types=1);

namespace EBoost\LayoutUpdate\Model\LayoutUpdate;

use EBoost\LayoutUpdate\Model\ResourceModel\LayoutUpdate\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Registry;
use Magento\Ui\DataProvider\AbstractDataProvider;

class DataProvider extends AbstractDataProvider
{

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    protected $loadedData;
    /**
     * @inheritDoc
     */
    protected $collection;
    /**
     * @var Registry
     */
    protected $registry;


    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        Registry $registry,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->registry = $registry;
    }

    /**
     * @inheritDoc
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $model = $this->getCurrentObject();
        if ($model) {
            $this->loadedData[$model->getId()] = $model->getData();    
        } else {
            $items = $this->collection->getItems();
            foreach ($items as $model) {
                $this->loadedData[$model->getId()] = $model->getData();
            }    
        }
        
        $data = $this->dataPersistor->get('eboost_layoutupdate_layout_update');

        if (!empty($data)) {
            $model = $this->collection->getNewEmptyItem();
            $model->setData($data);
            $this->loadedData[$model->getId()] = $model->getData();
            $this->dataPersistor->clear('eboost_layoutupdate_layout_update');
        }

        return $this->loadedData;
    }

    /**
     * @return RuleInterface | \Branch8\CategoryBanner\Model\Rule
     */
    protected function getCurrentObject()
    {
        return $this->registry->registry('eboost_layoutupdate_layout_update');
    }
}