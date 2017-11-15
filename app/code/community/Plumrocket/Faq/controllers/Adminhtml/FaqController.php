<?php

class Plumrocket_Faq_Adminhtml_FaqController extends Mage_Adminhtml_Controller_Action
{
	protected function _initAction()
	{
		$this->_usedModuleName = 'plumrocket_faq';
		
		$this->loadLayout()
				->_setActiveMenu('cms/faq')
				->_addBreadcrumb($this->__('CMS'), $this->__('CMS'))
				->_addBreadcrumb($this->__('FAQ'), $this->__('FAQ'));
		
		return $this;
	}

	public function indexAction()
	{
		$this->_initAction()
    			->_addContent($this->getLayout()->createBlock('plumrocket_faq/adminhtml_item'))
    			->renderLayout();
	}

	public function newAction()
	{
		$this->_forward('edit');
	}
	

	public function editAction()
	{
		$id = $this->getRequest()->getParam('faq_id');
		$model = Mage::getModel('plumrocket_faq/faq');
		
		// if current id given -> try to load and edit current FAQ item
		if ($id) {
			$model->load($id);
			if (!$model->getId()) {
				Mage::getSingleton('adminhtml/session')->addError(
					Mage::helper('plumrocket_faq')->__('This FAQ item no longer exists')
				);
				$this->_redirect('*/*/');
				return;
			}
		}
		
		$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
		if (!empty($data)) {
			$model->setData($data);
		}
		
		Mage::register('faq', $model);
		
		$this->_initAction()
				->_addBreadcrumb(
					$id
						? Mage::helper('plumrocket_faq')->__('Edit FAQ Item')
						: Mage::helper('plumrocket_faq')->__('New FAQ Item'),
					$id
						? Mage::helper('plumrocket_faq')->__('Edit FAQ Item')
						: Mage::helper('plumrocket_faq')->__('New FAQ Item')
				)
				->_addContent(
						$this->getLayout()
								->createBlock('plumrocket_faq/adminhtml_item_edit')
								->setData('action', $this->getUrl('adminhtml/faq/save'))
				)
				->_addLeft($this->getLayout()->createBlock('plumrocket_faq/adminhtml_item_edit_tabs'));
		
		$this->renderLayout();
	}

	public function saveAction()
	{
		// check if data sent
		if ($data = $this->getRequest()->getPost()) {
			
			// init model and set data
			$model = Mage::getModel('plumrocket_faq/faq');
			$model->setData($data);
			
			// try to save it
			try {
				// save the data
				$model->save();
				
				// display success message
				Mage::getSingleton('adminhtml/session')->addSuccess(
						Mage::helper('cms')->__('FAQ Item was successfully saved')
				);
				// clear previously saved data from session
				Mage::getSingleton('adminhtml/session')->setFormData(false);
				// check if 'Save and Continue'
				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array (
							'faq_id' => $model->getId() ));
					return;
				}
				// go to grid
				$this->_redirect('*/*/');
				return;
			
			}
			catch (Exception $e) {
				// display error message
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				// save data in session
				Mage::getSingleton('adminhtml/session')->setFormData($data);
				// redirect to edit form
				$this->_redirect('*/*/edit', array (
						'faq_id' => $this->getRequest()->getParam('faq_id') ));
				return;
			}
		}
		$this->_redirect('*/*/');
	}
	
	protected function _isAllowed()
	{
		return Mage::getSingleton('admin/session')->isAllowed('admin/cms/faq');
	}

	public function deleteAction()
	{
		// check if we know what should be deleted
		if ($id = $this->getRequest()->getParam('faq_id')) {
			try {
				
				// init model and delete
				$model = Mage::getModel('plumrocket_faq/faq');
				$model->load($id);
				$model->delete();
				
				// display success message
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('cms')->__('FAQ Entry was successfully deleted'));
				
				// go to grid
				$this->_redirect('*/*/');
				return;
			
			}
			catch (Exception $e) {
				
				// display error message
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				
				// go back to edit form
				$this->_redirect('*/*/edit', array (
						'faq_id' => $id ));
				return;
			}
		}
		
		// display error message
		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('cms')->__('Unable to find a FAQ entry to delete'));
		
		// go to grid
		$this->_redirect('*/*/');
	}
}