<?php
/**
 * Created by Steven.
 */
declare(strict_types=1);

namespace EBoost\LayoutUpdate\Controller\Adminhtml;

abstract class Layoutupdate extends \Magento\Backend\App\Action
{

    protected $_coreRegistry;
    const ADMIN_RESOURCE = 'EBoost_LayoutUpdate::top_level';

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry
    ) {
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context);
    }

    /**
     * Init page
     *
     * @param \Magento\Backend\Model\View\Result\Page $resultPage
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function initPage($resultPage)
    {
        $resultPage->setActiveMenu(self::ADMIN_RESOURCE)
            ->addBreadcrumb(__('EBoost'), __('EBoost'))
            ->addBreadcrumb(__('Layout Update'), __('Layout Update'));
        return $resultPage;
    }
}