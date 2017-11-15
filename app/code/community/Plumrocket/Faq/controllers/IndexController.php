<?php

class Plumrocket_Faq_IndexController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
    {
        $faqs = Mage::getModel('plumrocketfaq/faqs')->getCollection()->setOrder('created', 'DESC');
        $viewUrl = Mage::getUrl('faqs/index/view');

        echo '<h1>Faqs</h1>';
        foreach ($faqs as $item) {
            echo '<h2><a href="' . $viewUrl . '?id=' . $item->getId() . '">' . $item->getTitle() . '</a></h2>';
        }
    }
	
	public function viewAction()
    {
        $faqsId = Mage::app()->getRequest()->getParam('id', 0);
        $faqs = Mage::getModel('plumrocketfaq/faqs')->load($faqsId);

        if ($faqs->getId() > 0) {
            echo '<h1>' . $faqs->getTitle() . '</h1>';
            echo '<div class="content">' . $faqs->getContent() . '</div>';
        } else {
            $this->_forward('noRoute');
        }
    }
}