<?php

class Usersnap_Bugtracker_Model_Observer_Debug
{

    public function addVersionInfo(Varien_Event_Observer $observer)
    {
        $observer->getDebugInfo()->setVersion($this->getVersionInfo());
    }

    public function addStoreInfo(Varien_Event_Observer $observer)
    {
        $observer->getDebugInfo()->setStore($this->getStoreInfo());
    }

    public function addControllerInfo(Varien_Event_Observer $observer)
    {
        $observer->getDebugInfo()->setController($this->getControllerInfo());
    }

    public function addCookieInfo(Varien_Event_Observer $observer)
    {
        $observer->getDebugInfo()->setCookie($this->getCookieInfo());
    }

    public function addLayoutHandleInfo(Varien_Event_Observer $observer)
    {
        $observer->getDebugInfo()->setLayoutHandles($this->getLayoutHandleInfo());
    }

    public function addDesignInfo(Varien_Event_Observer $observer)
    {
        $observer->getDebugInfo()->setDesign($this->getDesignInfo());
    }

    public function addCustomerInfo(Varien_Event_Observer $observer)
    {
        $observer->getDebugInfo()->setCustomer($this->getCustomerInfo());
    }


    public function addSessionInfo(Varien_Event_Observer $observer)
    {
        $observer->getDebugInfo()->setSession($this->getSessionInfo());
    }

    /**
     * Info of the loaded Modules except of Mage Core Modules
     * @return array
     */
    protected function getVersionInfo()
    {
        $items = array();
        $items[] = array('module' => 'Magento', 'codePool' => 'core', 'active' => true, 'version' => Mage::getVersion());
        $modulesConfig = Mage::getConfig()->getModuleConfig();
        foreach ($modulesConfig as $node) {
            foreach ($node as $module => $data) {
                if ($data->codePool != "core") { //Don't display Magento Core Modules
                    $items[] = array(
                        "module" => (string)$module,
                        "codePool" => (string)$data->codePool,
                        "active" => (string)$data->active,
                        "version" => (string)$data->version
                    );
                }
            }
        }

        return $items;
    }

    /**
     * Info of the current store including currency info
     * @return array
     */
    protected function getStoreInfo()
    {
        $store = Mage::app()->getstore();
        return array(
            "id" => $store->getId(),
            "name" => $store->getName(),
            "base_currency" => $store->getBaseCurrencyCode(),
            "current_currency" => $store->getCurrentCurrencyCode(),
        );
    }

    /**
     * Info of the current request (module, controller, action)
     * @return array
     */
    protected function getControllerInfo()
    {
        $controller = Mage::registry('controller');
        $request = $controller->getRequest();
        return array(
            "route_name" => $request->getRouteName(),
            "controller_module" => $request->getControllerModule(),
            "controller_name" => $request->getControllerName(),
            "action_name" => $request->getActionName(),
            "request_path" => $request->getPathInfo()
        );
    }

    /**
     * Info of currently set cookies
     * @return array
     */
    protected function getCookieInfo()
    {
        return Mage::helper("bugtracker")->escapeHtmlArray($_COOKIE);
    }

    /**
     * Info of currently set objects inside the session
     * @return array
     */
    protected function getSessionInfo()
    {
        return Mage::helper("bugtracker")->escapeHtmlArray($_SESSION);
    }

    /**
     * Info of used layout handles
     * @return array
     */
    protected function getLayoutHandleInfo()
    {
        return Mage::getSingleton('core/layout')->getUpdate()->getHandles();
    }

    /**
     * Design and Template Info
     * @return array
     */
    protected function getDesignInfo()
    {
        $designPackage = Mage::getSingleton('core/design_package');
        return array(
            'design_area' => $designPackage->getArea(),
            'package_name' => $designPackage->getPackageName(),
            'theme' => $designPackage->getTheme('template'),
        );
    }

    /**
     * Info of current Customer
     * @return array
     */
    protected function getCustomerInfo()
    {
        $customer = Mage::helper("customer")->getCustomer();
        if ($customer->getId()) {
            return array(
                "id" => $customer->getId(),
                "email" => $customer->getEmail(),
                "firstname" => $customer->getFirstname(),
                "lastname" => $customer->getLastname(),
                "group" => $customer->getGroupId(),
            );
        } else {
            return array(
                "id" => $customer->getId()
            );
        }
    }

}