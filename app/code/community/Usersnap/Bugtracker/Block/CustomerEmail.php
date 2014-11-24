<?php

class Usersnap_Bugtracker_Block_CustomerEmail extends Mage_Core_Block_Template {

    /**
     * Only output the replace block if the email should be replaced
     * @return string
     */
    protected function _toHtml(){
        if (Mage::helper("bugtracker/config")->getReplaceEmail()) {
            return parent::_toHtml();
        }
    }

    /**
     * Get Email from current customer
     * @return string
     */
    public function getCustomerEmail(){
        $customer = Mage::helper("customer")->getCustomer();
        if ($customer->getId() && $customer->getEmail()) {
            return $customer->getEmail();
        }
        return "";
    }
}