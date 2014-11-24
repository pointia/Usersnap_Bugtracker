<?php
class Usersnap_Bugtracker_Helper_Data extends Mage_Core_Helper_Abstract
{

    /**
     * Escapes an array recursive
     * If object is given the class name will be used
     * @param $array
     * @return array
     */
    public function escapeHtmlArray($array){
        $return_array = array();
        foreach ($array as $key => $value) {
            if ( is_array($value)) {
                $return_array[$this->escapeHtml($key)] = $this->escapeHtmlArray($value);
            }
            elseif (is_object($value)) {
                $return_array[$this->escapeHtml($key)] = get_class($value);
            }
            else {
                $return_array[$this->escapeHtml($key)] = $this->escapeHtml($value);
            }
        }
        return $return_array;
    }
}
	 