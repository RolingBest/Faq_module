<?php

class Plumrocket_Faq_Adminhtml_FaqController extends Mage_Adminhtml_Controller_Action
{

    public function indexAction()
    {
        $this->loadLayout()->_setActiveMenu('plumrocketfaq');
        $this->_addContent($this->getLayout()->createBlock('plumrocketfaq/adminhtml_faqs'));
        $this->renderLayout();
    }
	
	public function newAction()
    {
        $this->_forward('edit');
    }
	
	public function editAction()
    {
        $id = (int) $this->getRequest()->getParam('id');
        $model = Mage::getModel('plumrocketfaq/faqs');

        if($data = Mage::getSingleton('adminhtml/session')->getFormData()){
            $model->setData($data)->setId($id);
        } else {
            $model->load($id);
        }
        Mage::register('current_faqs', $model);

        $this->loadLayout()->_setActiveMenu('plumrocketfaq');
        //$this->_addLeft($this->getLayout()->createBlock('plumrocketfaq/adminhtml_faqs_edit_tabs'));
        $this->_addContent($this->getLayout()->createBlock('plumrocketfaq/adminhtml_faqs_edit'));
        $this->renderLayout();
    }
	
	public function saveAction()
    {
      if ($data = $this->getRequest()->getPost()) {
            try {
                $model = Mage::getModel('plumrocketfaq/faqs');
                $model->setData($data)->setId($this->getRequest()->getParam('id'));
                if(!$model->getCreated()){
                    $model->setCreated(now());
                }
                $model->save();

                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Faqs was saved successfully'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array(
                    'id' => $this->getRequest()->getParam('id')
                ));
            }
            return;
        }
        Mage::getSingleton('adminhtml/session')->addError($this->__('Unable to find item to save'));
        $this->_redirect('*/*/');
    
    }

    public function deleteAction()
    {
        if ($id = $this->getRequest()->getParam('id')) {
            try {
                Mage::getModel('plumrocketfaq/faqs')->setId($id)->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('News was deleted successfully'));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $id));
            }
        }
        $this->_redirect('*/*/');
    }
	
	public function massDeleteAction()
    {
        $faqs = $this->getRequest()->getParam('faqs', null);

        if (is_array($faqs) && sizeof($faqs) > 0) {
            try {
                foreach ($faqs as $id) {
                    Mage::getModel('plumrocketfaq/faqs')->setId($id)->delete();
                }
                $this->_getSession()->addSuccess($this->__('Total of %d faqs have been deleted', sizeof($faqs)));
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        } else {
            $this->_getSession()->addError($this->__('Please select faqs'));
        }
        $this->_redirect('*/*');
    }

}