<?php


class Samumaretiya_Autoshippingmethod_Model_Observer
{
	private $_shippingCode = 'flatrate_flatrate';
	
	public function autoshippingmethod(Varien_Event_Observer $observer)
	{
		$event = $observer->getEvent();
		$cart = Mage::getSingleton('checkout/cart');
		$quote = $cart->getQuote();
	
 		$customerSession=Mage::getSingleton("customer/session");
		if($customerSession->isLoggedIn())
		{	
			 $quote->setShippingMethod('flatrate_flatrate');
	 		 $quote->save();
 		}
	    else
        {
			$shippingAddress = $quote->getShippingAddress();
			if (!$shippingAddress->getShippingMethod()) {
				$country = 'AU';
				$postcode = '3128';
				$regionId = '0'; 
				$method = 'flatrate_flatrate';
				$shippingAddress
					->setCountryId($country)
					->setRegionId($regionId)
					->setPostcode($postcode)
					->setShippingMethod($method)
					->setCollectShippingRates(true);
			//  $shippingAddress->setCountryId('AU')->setShippingMethod('flatrate_flatrate')->save();
			  $shippingAddress->save();
			  $quote->setTotalsCollectedFlag(false)->collectTotals();
			  $quote->save();
			}
		}
	}
}
