<?php
/**
 * Created by Steven.
 */
declare(strict_types=1);

namespace EBoost\LayoutUpdate\Controller\Adminhtml\LayoutUpdate;

class Edit extends \EBoost\LayoutUpdate\Controller\Adminhtml\LayoutUpdate
{

    protected $resultPageFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Edit action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('layout_update_id');
        $model = $this->_objectManager->create(\EBoost\LayoutUpdate\Model\LayoutUpdate::class);

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This Layout Update no longer exists.'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        $this->_coreRegistry->register('eboost_layoutupdate_layout_update', $model);

        // 3. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $this->initPage($resultPage)->addBreadcrumb(
            $id ? __('Edit Layout XML') : __('New Layout XML'),
            $id ? __('Edit Layout XML') : __('New Layout XML')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Layout Updates'));
        $resultPage->getConfig()->getTitle()->prepend($model->getId() ? __('Edit Layout XML %1', $model->getName()) : __('New Layout XML'));
        return $resultPage;
    }
}