<?php

class Plumrocket_Faq_Block_Frontend_Detail extends Mage_Core_Block_Template {
	
	protected $_faq;
	protected $_images;
	
	
	protected function _prepareLayout()
    {
        $faq = $this->getFaq();
        if ($faq !== false && $head = $this->getLayout()->getBlock('head')) {
            $head->setTitle($this->htmlEscape($faq->getQuestion()) . ' - ' . $head->getTitle());
        }
    }
	
	
	public function getFaq() {
		if (!$this->_faq) {
			$id = intval($this->getRequest()->getParam('faq'));
			try {
				$this->_faq = Mage :: getModel('plumrocket_faq/faq')->load($id); 
				
				if ($this->_faq->getIsActive() != 1){
					Mage::throwException('Faq Item is not active');
				}
			}
			catch (Exception $e) {
				$this->_faq = false;
			}
		}
		
		return $this->_faq;
	}
	

	public function getImages($thumbSize = null, $imageSize = null) {
		if (!$faq = $this->getFaq()) {
			return false;
		}
		
		// read images from dataset
		$images = $faq->getImage();
		$result = array();
		
		// if we have found images - process them
		if (is_array($images) && !empty($images)) {
			
			// get media model
			$mediaConfig = Mage :: getSingleton('faq/faq_media_config');
			$mediaModel = Mage :: getSingleton('media/image')->setConfig($mediaConfig);
			
			// iterate through images
			foreach ($images as $image) {
				
				// only go on if the image can be found
				if (file_exists(Mage::getBaseDir('media') . DS . 'faq' . DS . $image)) {
					
					// gather needed information
					$newImage = array(
							'original' => $image,
							'galleryUrl' => $this->getGalleryUrl($image)
					);
					
					if ($thumbSize) {
						$newImage['src'] = $mediaModel->getSpecialLink($image, $thumbSize);
					}
					
					if ($imageSize) {
						$newImage['href'] = $mediaModel->getSpecialLink($image, $imageSize);
						$newImage['width'] = intval($imageSize);
					}
					else {
						$newImage['href'] = Mage::getBaseUrl('media') . '/faq/' . $image;
						$newImage['width'] = $mediaModel->setFileName($image)->getDimensions()->getWidth();
					}
					
					$result[] = $newImage;
				}
			}
		}
		
		return $result;
	}
	
	
	
	public function getGalleryUrl($image) {
		$params = array('faq' => $this->getFaq()->getFaqId() . '_' . urlencode(str_replace(array(' ', 'a', 'o', 'u', '?'), array('_', 'ae', 'oe', 'ue', 'ss'), (strtolower($this->getFaq()->getQuestion())))));
        if ($image) {
            $params['image'] = $image;
            return $this->getUrl('*/*/gallery', $params);
        }
        return $this->getUrl('*/*/gallery', $params);
	}
	
	
	
	public function getGalleryImages($type = null) {
		
		// only do processing once (since parameters don't change during gallery view)
		if (!$this->_images) {
			
			// get images and parameters
			$currentParam = $this->getRequest()->getParam('image');
			$images = $this->getImages();
			
			// initialization
			$result = array(
				'previous' => NULL,
				'current' => NULL,
				'next' => NULL
			);
			
			// if we have images -> process them
			if (is_array($images) && !empty($images)) {
				$previousImage = null;
				
				foreach ($images as $image) {
					
					// if we found the requested pic -> save it
					// if the requested pic was not found the first pic of the collection is used
					if ($image['original'] == $currentParam || !$result['current']) {
						$result['current'] = $image;
						
						// save the previous image to get back to it
						$result['previous'] = $previousImage;
						
						if ($image['original'] == $currentParam) {
							$current = true;
						}
					}
					// save next image for pagination
					elseif ($result['current']) {
						$result['next'] = $image;
						
						// if we found the requested image -> break
						if ($current) {
							break;
						}
					}
					
					// save current image as previous image for further processing
					$previousImage = $image;
				}
			}
			
			// save results in class variable
			$this->_images = $result;
		}
		
		// if the requested type is given - return the image
		if ($type) {
			return (isset($this->_images[$type]) ? $this->_images[$type] : false);
		}
		
		// if no type given -> return all the three images
		return $this->_images;
	}
	
	
	
	public function getCurrentImage() {
		return $this->getGalleryImages('current');
	}
	
	
	
	public function getPreviousImage() {
		return $this->getGalleryImages('previous');
	}
	
	
	
	public function getNextImage() {
		return $this->getGalleryImages('next');
	}
	
	
	public function getImageWidth() {
		$current = $this->getCurrentImage();
		return $current['width'];
	}
}