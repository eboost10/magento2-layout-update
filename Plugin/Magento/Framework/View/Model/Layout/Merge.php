<?php
/**
 * Created by Steven.
 */
namespace EBoost\LayoutUpdate\Plugin\Magento\Framework\View\Model\Layout;

class Merge
{
    /**
     * @var \EBoost\LayoutUpdate\Model\ResourceModel\LayoutUpdate
     */
    protected $layoutUpdate;
    private $cache;

    public function __construct(
        \EBoost\LayoutUpdate\Model\ResourceModel\LayoutUpdate $layoutUpdate
    )
    {
        $this->layoutUpdate = $layoutUpdate;
    }


    public function aroundGetDbUpdateString(
        \Magento\Framework\View\Model\Layout\Merge $subject,
        \Closure $proceed,
        $handle
    ) {
        $result = $proceed($handle);
        if ($xml = $this->getHandleLayoutXml($subject, $handle)) {
            $result .= $xml;
        }
        return $result;
    }
    
    public function getHandleLayoutXml(\Magento\Framework\View\Model\Layout\Merge $subject, $handle)
    {
        if (is_null($this->cache)) {
            $storeId = $subject->getScope()->getId();
            $handles = $subject->getHandles();
            $xmls = $this->layoutUpdate->getLayoutXmlByHandles($storeId, $handles);

            $layoutUpdateCache = [];
            // print_r($handles);
            // print_r($xmls);exit;
            foreach ($xmls as $layout) {
                if (!isset($layoutUpdateCache[$layout['handle']])) {
                    $layoutUpdateCache[$layout['handle']] = '';
                }
                $layoutUpdateCache[$layout['handle']] .= $layout['xml'];
            }

            $this->cache = $layoutUpdateCache;
            // print_r($this->cache);exit;
        }
        
        return $this->cache[$handle] ?? '';
    }
}