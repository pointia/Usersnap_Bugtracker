<?php


class Usersnap_Bugtracker_Model_System_Config_Source_DefaultNoOptReq extends Usersnap_Bugtracker_Model_System_Config_Source_Abstract {

    public function __construct()
    {
        $this->_values = array(
            "" => $this->getHelper()->__("Default"),
            "no" => Mage::helper('adminhtml')->__('No'),
            "opt" => Mage::helper('adminhtml')->__('Optional'),
            "req" => Mage::helper('adminhtml')->__('Required')
        );
    }
}