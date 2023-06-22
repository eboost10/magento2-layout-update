<?php
/**
 * Created by Steven.
 */

namespace EBoost\LayoutUpdate\Api\Data;


interface LayoutUpdateInterface
{
    const NAME = 'name';
    const LAYOUT_UPDATE_ID = 'layout_update_id';
    const HANDLE = 'handle';
    const SORT_ORDER = 'sort_order';
    const XML = 'xml';
    const IS_ACTIVE = 'is_active';

    /**
     * Get layout_update_id
     * @return string|null
     */
    public function getLayoutUpdateId();

    /**
     * Set layout_update_id
     * @param string $layoutUpdateId
     * @return \EBoost\LayoutUpdate\LayoutUpdate\Api\Data\LayoutUpdateInterface
     */
    public function setLayoutUpdateId($layoutUpdateId);

    /**
     * Get name
     * @return string|null
     */
    public function getName();

    /**
     * Set name
     * @param string $name
     * @return \EBoost\LayoutUpdate\LayoutUpdate\Api\Data\LayoutUpdateInterface
     */
    public function setName($name);

    /**
     * Get handle
     * @return string|null
     */
    public function getHandle();

    /**
     * Set handle
     * @param string $handle
     * @return \EBoost\LayoutUpdate\LayoutUpdate\Api\Data\LayoutUpdateInterface
     */
    public function setHandle($handle);

    /**
     * Get xml
     * @return string|null
     */
    public function getXml();

    /**
     * Set xml
     * @param string $xml
     * @return \EBoost\LayoutUpdate\LayoutUpdate\Api\Data\LayoutUpdateInterface
     */
    public function setXml($xml);

    /**
     * Get sort_order
     * @return string|null
     */
    public function getSortOrder();

    /**
     * Set sort_order
     * @param string $sortOrder
     * @return \EBoost\LayoutUpdate\LayoutUpdate\Api\Data\LayoutUpdateInterface
     */
    public function setSortOrder($sortOrder);

    /**
     * Get is_active
     * @return string|null
     */
    public function getIsActive();

    /**
     * Set is_active
     * @param string $isActive
     * @return \EBoost\LayoutUpdate\LayoutUpdate\Api\Data\LayoutUpdateInterface
     */
    public function setIsActive($isActive);
}