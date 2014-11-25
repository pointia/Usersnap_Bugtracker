<?php

class Usersnap_Bugtracker_Block_Track extends Mage_Core_Block_Template{

    protected $_configHelper;
    protected $_config;

    /**
     * Usersnap API Key
     * @return mixed
     */
    public function getApiKey(){
        return $this->getConfigHelper()->getApiKey();
    }

    /**
     * Is Usersnap enabled?
     * @return mixed
     */
    public function isEnabled(){
        return $this->getConfigHelper()->isEnabled();
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
            'valign' => $this->getConfigHelper()->getVerticalAlign(),
            'halign' => $this->getConfigHelper()->getHorizontalAlign(),
            'btnText' => $this->getConfigHelper()->getButtonText(),
            'commentBoxPlaceholder' => $this->getConfigHelper()->getCommentValue(),
            'shortcut' => $this->getConfigHelper()->isShortcutEnabled(),
            'hideTour' => $this->getConfigHelper()->getHideTour()
        );

        $language = $this->getConfigHelper()->getLanguage();
        if ($language) {
            $config['lang'] = $language;
        }

        $tools = $this->getConfigHelper()->getTools();
        if ($tools) {
            $config ['tools'] = array_filter(explode(",",str_replace(' ', '',$tools)));
        }

        $noOptReqFields = array("email" => $this->getConfigHelper()->getShowEmail(), "comment" => $this->getConfigHelper()->getShowComment());
        foreach($noOptReqFields as $key => $config_value){
            switch($config_value){
                case "no" : $config[$key.'Box'] = false; break;
                case "opt" : $config[$key.'Box'] = true; $config[$key.'Required'] = false; break;
                case "req" : $config[$key.'Box'] = true; $config[$key.'Required'] = true; break;
                default: break;
            }
        }

        $emailBoxValue = $this->getConfigHelper()->getEmailValue();
        if ($emailBoxValue) {
            $config['emailBoxValue'] = $emailBoxValue;
        }

        if (!$this->getConfigHelper()->getShowButton()) {
            $config['mode'] = "report";
        }

        /**
         * Filter Empty Values
         */
        foreach ($config as $key => $value){
            if ($value === "" || $value === "-1" || $value === null) {
                unset($config[$key]);
            }
        }
        if (isset($config['shortcut'])) {
            $config['shortcut'] = ((bool)$config['shortcut']);
        }

        return $config;
    }


    /**
     * @return Usersnap_Bugtracker_Helper_Config
     */
    protected function getConfigHelper()
    {
        if (!$this->_configHelper) {
            $this->_configHelper = Mage::helper("bugtracker/config");
        }
        return $this->_configHelper;
    }

}