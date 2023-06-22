<?php
/**
 * Created by Steven.
 */
declare(strict_types=1);

namespace EBoost\LayoutUpdate\Model\ResourceModel\LayoutUpdate;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;


class Collection extends AbstractCollection
{
    /**
     * @inheritDoc
     */
    protected $_idFieldName = 'layout_update_id';

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(
            \EBoost\LayoutUpdate\Model\LayoutUpdate::class,
            \EBoost\LayoutUpdate\Model\ResourceModel\LayoutUpdate::class
        );
    }
}