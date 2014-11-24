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
        $option_array = array();
        foreach ($this->_values as $key => $value) {
            $option_array [] = array('value' => $key, 'label'=>$value);
        }

        return $option_array;
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
    protected function getHelper(){
        return Mage::helper("bugtracker");
    }

}
