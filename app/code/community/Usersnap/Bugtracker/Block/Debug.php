<?php

class Usersnap_Bugtracker_Block_Debug extends Mage_Core_Block_Template {

    const USERSNAP_DEBUG_EVENT = "usersnap_debug_info";

    /**
     * Is Debug Enabled
     * @return mixed
     */
    public function isEnabled(){
        return Mage::helper("bugtracker/config")->isDebug();
    }

    /**
     * Only output html if debug is enabled
     * @return string
     */
    protected function _toHtml(){
        if ($this->isEnabled()) {
            return parent::_toHtml();
        }
        return "";
    }

    /**
     * Returns the debug Info of the debug info object
     * @return string json
     */
    public function getDebugInfo(){
        $debug_info = new Varien_Object();
        Mage::dispatchEvent(self::USERSNAP_DEBUG_EVENT, array ("debug_info" => $debug_info));
        return Mage::helper("core")->jsonEncode($debug_info->getData());
    }
}