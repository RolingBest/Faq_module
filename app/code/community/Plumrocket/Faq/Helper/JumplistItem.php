<?php

class Plumrocket_Faq_Helper_JumplistItem extends Mage_Core_Helper_Abstract implements Countable, Iterator 
{
	
	protected $label;
	
	
	protected $faqItems = array();
	
	
	public function __construct($label = null, $faqItems = null)
	{
		$this->setLabel($label);
		if(!is_null($faqItems))
		{
			$this->setFaqItems($faqItems);
		}
	}
	
	
	public function getFaqItems()
	{
		return $this->faqItems;
	}
	
	
	public function setFaqItems(array $faqItems)
	{
		$this->faqItems = $faqItems;
	}
	
	public function addFaqItem($item)
	{
		$this->faqItems[] = $item;
	}
	
	
	public function getLabel()
	{
		return $this->label;
	}
	
	
	public function setLabel($label)
	{
		$this->label = (string) $label;
	}
	
	
	public function count()
	{
		return count($this->faqItems);
	}
	
	
	public function current()
	{
		return current($this->faqItems);
	}
	
	
	public function key()
	{
		return key($this->faqItems);
	}
	
	
	public function next()
	{
		next($this->faqItems);
	}
	
	
	
	public function rewind()
	{
		reset($this->faqItems);
	}
	
	
	public function valid()
	{
		return array_key_exists($this->key(), $this->faqItems);
	}
}