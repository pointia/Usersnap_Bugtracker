<?php

class Usersnap_Bugtracker_Block_Track extends Mage_Core_Block_Template{

    protected $_configHelper;
    protected $_config;

    /**
     * Usersnap API Key
     * @return mixed
     */
    public function getApiKey(){
        return $this->getConfig()->getApiKey();
    }

    /**
     * Is Usersnap enabled?
     * @return mixed
     */
    public function isEnabled(){
        return $this->getConfig()->isEnabled();
    }

    /**
     * Don't display any output if Usesnap is disabled
     * @return string
     */
    protected function _toHtml(){
        if ($this->isEnabled()) {
            return parent::_toHtml();
        }
        return "";
    }

    /**
     * Get store config from backend
     *
     * @return string usersnap config values
     */
    public function getJsonConfig(){
        if(!$this->_config){
            $cacheKey = 'USERSNAP_CONFIG_JSON_STORE' . (string)Mage::app()->getStore()->getId();
            if (Mage::app()->useCache("config")) {
                $json = Mage::app()->loadCache($cacheKey);
            }
            if (empty($json)) {
                $config_array = $this->getConfigValues();
                $json =  "var _usersnapconfig = " . Mage::helper("core")->jsonEncode($config_array) . "; ";
                if (Mage::app()->useCache('config')) {
                    Mage::app()->saveCache($json, $cacheKey, array('config'));
                }
            }
            $this->_config = $json;
        }
        return $this->_config;
    }

    /**
     * Configured values from magento backend + modification to fit to Usersnap definition
     * @return array
     */
    public function getConfigValues(){
        $config = array(
            'type' => 'magento',
            'valign' => $this->getConfig()->getVerticalAlign(),
            'halign' => $this->getConfig()->getHorizontalAlign(),
            'btnText' => $this->getConfig()->getButtonText(),
            'commentBoxPlaceholder' => $this->getConfig()->getCommentValue(),
            'shortcut' => $this->getConfig()->isShortcutEnabled(),
            'hideTour' => $this->getConfig()->getHideTour()
        );

        $language = $this->getConfig()->getLanguage();
        if ($language) {
            $config['lang'] = $language;
        }

        $tools = $this->getConfig()->getTools();
        if ($tools) {
            $config ['tools'] = explode(",",str_replace(' ', '',$tools));
        }

        $noOptReqFields = array("email" => $this->getConfig()->getShowEmail(), "comment" => $this->getConfig()->getShowComment());
        foreach($noOptReqFields as $key => $config_value){
            switch($config_value){
                case "" : $config[$key.'Box'] = false; break;
                case "opt" : $config[$key.'Box'] = true; $config[$key.'Required'] = false; break;
                case "req" : default: $config[$key.'Box'] = true; $config[$key.'Required'] = true; break;
            }
        }

        $emailBoxValue = $this->getConfig()->getEmailValue();
        if ($emailBoxValue) {
            $config['emailBoxValue'] = $emailBoxValue;
        }

        if (!$this->getConfig()->getShowButton()) {
            $config['mode'] = "report";
        }

        return $config;
    }


    /**
     * Config Helper
     * @return Usersnap_Bugtracker_Helper_Config
     */
    protected function getConfig()
    {
        if (!$this->_configHelper) {
            $this->_configHelper = Mage::helper("bugtracker/config");
        }
        return $this->_configHelper;
    }

}