<?php

class Plumrocket_Faq_Helper_Jumplist extends Mage_Core_Helper_Abstract implements Countable, Iterator
{
	protected $items = array();
	
	const KEY_OTHER = 'other';
	
	public function __construct()
	{
		
		for($ord = 65; $ord <= 90; $ord++)
		{
			$chr = chr($ord);
			$this->items[$chr] = new Plumrocket_Faq_Helper_JumplistItem($chr);
		}
		
		
		$this->items[self::KEY_OTHER] = new Plumrocket_Faq_Helper_JumplistItem(self::KEY_OTHER);
	}
	
	public function setFaqItems(Plumrocket_Faq_Model_Mysql4_Faq_Collection $items)
	{
		foreach($items as $item)
		{
			$key = strtoupper(substr($item->getQuestion(), 0, 1));
			if(!array_key_exists($key, $this->items))
			{
				$key = self::KEY_OTHER;
			}
			$this->items[$key]->addFaqItem($item);
		}
	}

	public function current() 
	{
		return current($this->items);
	}
	

	public function key() 
	{
		return key($this->items);
	}
	

	public function next() 
	{
		return next($this->items);
	}
	

	public function rewind() 
	{
		return reset($this->items);
	}
	

	public function valid() 
	{
		return array_key_exists($this->key(), $this->items);
	}
	
	public function count() 
	{
		return count($this->items);
	}
}