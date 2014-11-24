<?php

class Usersnap_Bugtracker_Model_Observer_Wishlist{

    public function addWishlistInfo(Varien_Event_Observer $observer)
    {
        $observer->getDebugInfo()->setWishlist($this->getWishlistInfo());
    }


    /**
     * Info of wishlist items
     * @return array
     */
    protected function getWishlistInfo()
    {
        $wishlist_info = array();
        if (!Mage::helper('core')->isModuleEnabled("Mage_Wishlist")) {
            return $wishlist_info;
        }
        $wishlistItems = Mage::helper('wishlist')->getWishlistItemCollection();
        if ($wishlistItems) {
            /** @var $item Mage_Wishlist_Model_Item */
            foreach ($wishlistItems as $item) {
                $wishlist_info [] = array(
                    "product_id" => $item->getProduct()->getId(),
                    "product_sku" => $item->getProduct()->getSku(),
                    "product_name" => $item->getProduct()->getName(),
                );
            }
        }
        return $wishlist_info;
    }
}