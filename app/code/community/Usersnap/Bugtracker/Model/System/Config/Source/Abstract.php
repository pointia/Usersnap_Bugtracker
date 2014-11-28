<?php

/**
 * Used in creating options for config value selection
 *
 */
class Usersnap_Bugtracker_Model_System_Config_Source_Abstract
{

    protected $_values = array();

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        $optionArray = array();
        foreach ($this->_values as $key => $value) {
            $optionArray [] = array('value' => $key, 'label' => $value);
        }

        return $optionArray;
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return $this->_values;
    }

    /**
     * @return Usersnap_Bugtracker_Helper_Data
     */
    protected function getHelper()
    {
        return Mage::helper("bugtracker");
    }

}
