<?php

class Usersnap_Bugtracker_Helper_Config extends Mage_Core_Helper_Abstract {

    const XML_PATH_API_KEY = 'usersnap/options/api_key';
    const XML_PATH_ENABLE = 'usersnap/options/enable';
    const XML_PATH_HIDE_TOUR = 'usersnap/options/hide_tour';
    const XML_PATH_TOOLS = 'usersnap/options/tools';

    const XML_PATH_DEBUG_ENABLE = 'usersnap/debug/enable';
    const XML_PATH_BUTTON_TEXT = 'usersnap/display/button_text';
    const XML_PATH_COMMENT_PLACEHOLDER = 'usersnap/display/comment_placeholder';
    const XML_PATH_EMAIL_VALUE = 'usersnap/display/email_value';
    const XML_PATH_ENABLE_SHORTCUT = 'usersnap/display/enable_shortcut';
    const XML_PATH_HALIGN = 'usersnap/display/halign';
    const XML_PATH_LANGUAGE = 'usersnap/display/language';
    const XML_PATH_SHOW_BUTTON = 'usersnap/display/show_button';
    const XML_PATH_SHOW_COMMENT = 'usersnap/display/show_comment';
    const XML_PATH_SHOW_EMAIL = 'usersnap/display/show_email';
    const XML_PATH_EMAIL_REPLACE = 'usersnap/display/email_replace';
    const XML_PATH_VALIGN = 'usersnap/display/valign';

    const USER_EMAIL = "{{USER_EMAIL}}";

    const LANG_DEFAULT = "default";
    const LANG_STORE = "store";

    public function isEnabled(){
        return Mage::getStoreConfig(self::XML_PATH_ENABLE);
    }

    public function getApiKey()
    {
        return Mage::getStoreConfig(self::XML_PATH_API_KEY);
    }

    public function getTools(){
        return Mage::getStoreConfig(self::XML_PATH_TOOLS);
    }

    public function getHideTour(){
        return Mage::getStoreConfig(self::XML_PATH_HIDE_TOUR);
    }

    public function getShowButton(){
        return Mage::getStoreConfig(self::XML_PATH_SHOW_BUTTON);
    }

    public function getButtonText(){
        return Mage::getStoreConfig(self::XML_PATH_BUTTON_TEXT);
    }

    public function isShortcutEnabled(){
        return Mage::getStoreConfig(self::XML_PATH_ENABLE_SHORTCUT);
    }

    public function getShowEmail(){
        return Mage::getStoreConfig(self::XML_PATH_SHOW_EMAIL);
    }

    public function getEmailValue(){
        return Mage::getStoreConfig(self::XML_PATH_EMAIL_VALUE);
    }

    public function getReplaceEmail(){
        return Mage::getStoreConfig(self::XML_PATH_EMAIL_REPLACE);
    }

    public function getShowComment(){
        return Mage::getStoreConfig(self::XML_PATH_SHOW_COMMENT);
    }

    public function getCommentValue(){
        return Mage::getStoreConfig(self::XML_PATH_COMMENT_PLACEHOLDER);
    }

    public function getVerticalAlign(){
        return Mage::getStoreConfig(self::XML_PATH_VALIGN);
    }

    public function getHorizontalAlign(){
        return Mage::getStoreConfig(self::XML_PATH_HALIGN);
    }

    /**
     * Returns the plain config value
     * @return string
     */
    public function getLanguageConfigValue(){
        return Mage::getStoreConfig(self::XML_PATH_LANGUAGE);
    }

    /**
     * Returns the parsed value according to the option
     * @return string
     */
    public function getLanguage()
    {
        $language = $this->getLanguageConfigValue();
        if ($language != self::LANG_DEFAULT ) {
            if ($language == self::LANG_STORE ) {
                $language = Mage::app()->getLocale()->getLocale()->getLanguage();
            }
            return $language;
        }
        return "";
    }

    public function isDebug(){
        return Mage::getStoreConfig(self::XML_PATH_DEBUG_ENABLE);
    }
}