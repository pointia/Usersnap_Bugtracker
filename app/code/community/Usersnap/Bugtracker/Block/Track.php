<?php

class Usersnap_Bugtracker_Block_Track extends Mage_Core_Block_Template
{

    protected $_configHelper;
    protected $_config;

    /**
     * Usersnap API Key
     * @return mixed
     */
    public function getApiKey()
    {
        return $this->getConfigHelper()->getApiKey();
    }

    /**
     * Is Usersnap enabled?
     * @return mixed
     */
    public function isEnabled()
    {
        return $this->getConfigHelper()->isEnabled();
    }

    /**
     * Don't display any output if Usesnap is disabled
     * @return string
     */
    protected function _toHtml()
    {
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
    public function getJsonConfig()
    {
        if (!$this->_config) {
            $cacheKey = 'USERSNAP_CONFIG_JSON_STORE' . (string)Mage::app()->getStore()->getId();
            if (Mage::app()->useCache("config")) {
                $json = Mage::app()->loadCache($cacheKey);
            }
            if (empty($json)) {
                $configArray = $this->getConfigValues();
                $json = "var _usersnapconfig = " . Mage::helper("core")->jsonEncode($configArray) . "; ";
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
    public function getConfigValues()
    {
        $config = new Varien_Object(array(
            'type' => 'magento',
            'valign' => $this->getConfigHelper()->getVerticalAlign(),
            'halign' => $this->getConfigHelper()->getHorizontalAlign(),
            'btnText' => $this->getConfigHelper()->getButtonText(),
            'commentBoxPlaceholder' => $this->getConfigHelper()->getCommentValue(),
            'shortcut' => $this->getConfigHelper()->isShortcutEnabled(),
            'hideTour' => $this->getConfigHelper()->getHideTour()
        ));

        $this->addLanguage($config);
        $this->addTools($config);
        $this->addEmail($config);
        $this->addComment($config);
        $this->addEmailValue($config);
        $this->addShowButton($config);

        $this->filterEmptyValues($config);

        $this->convertToBool($config, 'shortcut');

        return $config;
    }

    /**
     * Add Language Option
     * @param Varien_Object $config
     */
    protected function addLanguage($config)
    {
        $language = $this->getConfigHelper()->getLanguage();
        if ($language) {
            $config->setData('lang', $language);
        }
    }

    /**
     * Add Tools Option
     * @param Varien_Object $config
     */
    protected function addTools($config)
    {
        $tools = $this->getConfigHelper()->getTools();
        if ($tools) {
            $config->setData('tools', array_filter(explode(",", str_replace(' ', '', $tools))));
        }
    }

    /**
     * Add Email Option
     * @param Varien_Object $config
     */
    protected function addEmail($config)
    {
        $this->addNoOptReqField($config, "email", $this->getConfigHelper()->getShowEmail());
    }

    /**
     * Add Comment Option
     * @param Varien_Object $config
     */
    protected function addComment($config)
    {
        $this->addNoOptReqField($config, "comment", $this->getConfigHelper()->getShowComment());
    }

    /**
     * Crates No Optional Required Config Values
     * @param Varien_Object $config
     * @param $key
     * @param $configValue
     */
    private function addNoOptReqField($config, $key, $configValue)
    {
        switch ($configValue) {
            case "no" :
                $config->setData($key . 'Box', false);
                break;
            case "opt" :
                $config->setData($key . 'Box', true);
                $config->setData($key . 'Required', false);
                break;
            case "req" :
                $config->setData($key . 'Box', true);
                $config->setData($key . 'Required', true);
                break;
            default:
                break;
        }
    }

    /**
     * Add Default Email Value
     * @param Varien_Object $config
     */
    protected function addEmailValue($config)
    {
        $emailBoxValue = $this->getConfigHelper()->getEmailValue();
        if ($emailBoxValue) {
            $config->setData('emailBoxValue', $emailBoxValue);
        }
    }

    /**
     * Hide Button if configured
     * @param Varien_Object $config
     */
    protected function addShowButton($config)
    {
        if (!$this->getConfigHelper()->getShowButton()) {
            $config->setData('mode', "report");
        }
    }

    /**
     * @param Varien_Object $config
     * @param $key
     */
    protected function convertToBool($config, $key)
    {
        if ($config->hasData($key)) {
            $config->setData($key, ((bool)$config->getData($key)));
        }
    }

    /**
     * Filter Empty Values
     * @param Varien_Object $config
     */
    protected function filterEmptyValues($config)
    {
        $data = $config->getData();
        foreach ($data as $key => $value) {
            if ($value === "" || $value === "-1" || $value === null) {
                $config->unsetData($key);
            }
        }
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