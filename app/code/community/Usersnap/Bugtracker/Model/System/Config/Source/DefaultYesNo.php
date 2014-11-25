<?php


class Usersnap_Bugtracker_Model_System_Config_Source_DefaultYesNo extends Usersnap_Bugtracker_Model_System_Config_Source_Abstract {

    public function __construct()
    {
        $this->_values = array(
            "-1" => $this->getHelper()->__("Default"),
            "1" => Mage::helper('adminhtml')->__('Yes'),
            "0" => Mage::helper('adminhtml')->__('No'),
        );
    }
}