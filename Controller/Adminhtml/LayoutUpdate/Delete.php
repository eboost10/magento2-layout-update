<?php
/**
 * Created by Steven.
 */
declare(strict_types=1);

namespace EBoost\LayoutUpdate\Controller\Adminhtml\LayoutUpdate;

class Delete extends \EBoost\LayoutUpdate\Controller\Adminhtml\LayoutUpdate
{

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('layout_update_id');
        if ($id) {
            try {
                // init model and delete
                $model = $this->_objectManager->create(\EBoost\LayoutUpdate\Model\LayoutUpdate::class);
                $model->load($id);
                $model->delete();
                // display success message
                $this->messageManager->addSuccessMessage(__('You deleted the Layout Update.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['layout_update_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a Layout Update to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}