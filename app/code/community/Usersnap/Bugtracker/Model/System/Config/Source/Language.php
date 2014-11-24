<?php

class Usersnap_Bugtracker_Model_System_Config_Source_Language extends Usersnap_Bugtracker_Model_System_Config_Source_Abstract {

    /**
     * Populate the language array and store it in config
     */
    public function __construct()
    {
        $cacheKey = 'USERSNAP_CONFIG_LANGUAGE_' . (string)Mage::app()->getLocale()->getLocale()->getLanguage();
        $languages = null;
        if (Mage::app()->useCache("config")) {
            $languages = json_decode(Mage::app()->loadCache($cacheKey));
        }
        if (empty($languages)) {
            $languages = array(
                Usersnap_Bugtracker_Helper_Config::LANG_DEFAULT => $this->getHelper()->__("Default"),
                Usersnap_Bugtracker_Helper_Config::LANG_STORE => $this->getHelper()->__("Store Specific Language")
            );
            $other_languages = Mage::app()->getLocale()->getTranslationList('language');
            uasort($other_languages,'strcoll');
            foreach ($other_languages as $code => $name) {
                $languages [$code] = $name;
            }

            if (Mage::app()->useCache('config')) {
                Mage::app()->saveCache(json_encode($languages), $cacheKey, array('config'));
            }
        }
        $this->_values = $languages;
    }
}