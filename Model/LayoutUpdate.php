<?php
/**
 * Created by Steven.
 */
declare(strict_types=1);

namespace EBoost\LayoutUpdate\Model;

use EBoost\LayoutUpdate\Api\Data\LayoutUpdateInterface;
use Magento\Framework\Model\AbstractModel;

class LayoutUpdate extends AbstractModel implements LayoutUpdateInterface
{
    /**
     * @inheritDoc
     */
    public function _construct()
    {
        $this->_init(\EBoost\LayoutUpdate\Model\ResourceModel\LayoutUpdate::class);
    }

    /**
     * @inheritDoc
     */
    public function getLayoutUpdateId()
    {
        return $this->getData(self::LAYOUT_UPDATE_ID);
    }

    /**
     * @inheritDoc
     */
    public function setLayoutUpdateId($layoutUpdateId)
    {
        return $this->setData(self::LAYOUT_UPDATE_ID, $layoutUpdateId);
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * @inheritDoc
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * @inheritDoc
     */
    public function getHandle()
    {
        return $this->getData(self::HANDLE);
    }

    /**
     * @inheritDoc
     */
    public function setHandle($handle)
    {
        return $this->setData(self::HANDLE, $handle);
    }

    /**
     * @inheritDoc
     */
    public function getXml()
    {
        return $this->getData(self::XML);
    }

    /**
     * @inheritDoc
     */
    public function setXml($xml)
    {
        return $this->setData(self::XML, $xml);
    }

    /**
     * @inheritDoc
     */
    public function getSortOrder()
    {
        return $this->getData(self::SORT_ORDER);
    }

    /**
     * @inheritDoc
     */
    public function setSortOrder($sortOrder)
    {
        return $this->setData(self::SORT_ORDER, $sortOrder);
    }

    /**
     * @inheritDoc
     */
    public function getIsActive()
    {
        return $this->getData(self::IS_ACTIVE);
    }

    /**
     * @inheritDoc
     */
    public function setIsActive($isActive)
    {
        return $this->setData(self::IS_ACTIVE, $isActive);
    }
}