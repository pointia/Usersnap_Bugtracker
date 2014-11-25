<?php

/**
 * Class for Horizontal Align
 */
class Usersnap_Bugtracker_Model_System_Config_Source_Halign extends Usersnap_Bugtracker_Model_System_Config_Source_Abstract {

    public function __construct()
    {
        $this->_values = array(
            "" => $this->getHelper()->__("Default"),
            "right" => $this->getHelper()->__("Right"),
            "left" => $this->getHelper()->__("Left")
        );
    }
}