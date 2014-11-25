<?php

/**
 * Class for Vertical Align
 */
class Usersnap_Bugtracker_Model_System_Config_Source_Valign extends Usersnap_Bugtracker_Model_System_Config_Source_Abstract {

    public function __construct()
    {
        $this->_values = array(
          "" => $this->getHelper()->__("Default"),
          "bottom" => $this->getHelper()->__("Bottom"),
          "middle" => $this->getHelper()->__("Middle")
        );
    }
}