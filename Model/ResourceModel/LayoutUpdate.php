<?php
/**
 * Created by Steven.
 */
declare(strict_types=1);

namespace EBoost\LayoutUpdate\Model\ResourceModel;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class LayoutUpdate extends AbstractDb
{
    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init('eboost_layout_update', 'layout_update_id');
    }

    /**
     * @param AbstractModel $object
     * @return mixed
     */
    protected function _afterLoad(AbstractModel $object)
    {
        $this->getLinkData($object);
        return parent::_afterLoad($object);
    }

    /**
     * @param AbstractModel $object
     * @return mixed
     */
    protected function _afterSave(AbstractModel $object)
    {
        $this->processLinkTable($object);
        return parent::_afterSave($object);
    }

    /**
     * Get Link Data
     *
     * @param AbstractModel $object
     */
    protected function getLinkData(AbstractModel $object)
    {
        $this->getStoreLink($object);
    }

    /**
     * @param AbstractModel $object
     */
    protected function getStoreLink($object)
    {
        $stores = $this->lookupStoreIds($object->getId());
        $object->setData('store_ids', $stores);
    }

    /**
     * Process data to link table
     *
     * @param AbstractModel $object
     * @return $this
     */
    protected function processLinkTable(AbstractModel $object)
    {
        $this->processStoreTable($object);
        return $this;
    }

    /**
     * Get Store ids to which specified item is assigned
     *
     * @param integer $id
     * @return array
     */
    public function lookupStoreIds($id)
    {
        return $this->lookupIds(
            $id,
            $this->getStoreTable(),
            'store_id'
        );
    }

    /**
     * Save data to branch8_product_series_website table
     *
     * @param AbstractModel $object
     */
    protected function processStoreTable(AbstractModel $object)
    {
        $newIds = (array)$object->getStoreIds();
        if (!$newIds) {
            return;
        }
        $oldIds = $this->lookupStoreIds($object->getId());
        $this->updateForeignKey(
            $object->getId(),
            $newIds,
            $oldIds,
            $this->getStoreTable(),
            'store_id'
        );
    }

    /**
     * Get ids to which specified item is assigned
     *
     * @param  integer $id
     * @param  string  $tableName
     * @param  string  $field
     * @return array
     */
    protected function lookupIds($id, $tableName, $field)
    {
        $adapter = $this->getConnection();

        $select = $adapter->select()->from(
            $this->getTable($tableName),
            $field
        )->where(
            'layout_update_id = ?',
            (int)$id
        );

        return $adapter->fetchCol($select);
    }

    /**
     * @param $id
     * @param array  $newIds
     * @param array  $oldIds
     * @param $table
     * @param $field
     */
    protected function updateForeignKey(
        $id,
        array $newIds,
        array $oldIds,
        $table,
        $field
    ) {
        $insert = array_diff($newIds, $oldIds);
        $delete = array_diff($oldIds, $newIds);
        if ($delete) {
            $this->deleteLinkTable($id, $table, $field, $delete);
        }

        if ($insert) {
            $data = [];
            foreach ($insert as $storeId) {
                $data[] = [
                    'layout_update_id' => (int)$id,
                    $field    => (int)$storeId,
                ];
            }
            $this->getConnection()->insertMultiple($table, $data);
        }
    }

    /**
     * @param $bannerId
     * @param $table
     * @param $field
     * @param array $linkIds
     */
    protected function deleteLinkTable($bannerId, $table, $field, array $linkIds)
    {
        $where = [
            'layout_update_id = ?' => (int)$bannerId,
            $field . ' IN (?)' => $linkIds,
        ];
        $this->getConnection()->delete($table, $where);
    }

    /**
     * Get Website Table
     *
     * @return string
     */
    protected function getStoreTable()
    {
        return $this->getTable('eboost_layout_link');
    }
    
    public function getLayoutXmlByHandles($storeId, $handles)
    {
        $select = $this->getConnection()->select()->from(
            ['layout_update' => $this->getMainTable()],
            ['xml', 'handle']
        )->join(
            ['link' => $this->getTable('eboost_layout_link')],
            'link.layout_update_id=layout_update.layout_update_id',
            ''
        )->where(
            'link.store_id IN (0, :store_id)'
        )->where(
            'layout_update.is_active = 1'
        )->where(
            'layout_update.handle in (?)', $handles
        )->order(
            'layout_update.sort_order ' . \Magento\Framework\DB\Select::SQL_ASC
        );
// echo $select;exit;
        return $this->getConnection()->fetchAll($select, ['store_id' => $storeId]);
    }
}