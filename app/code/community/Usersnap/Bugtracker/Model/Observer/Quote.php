<?php

class Usersnap_Bugtracker_Model_Observer_Quote {

    public function addQuoteInfo(Varien_Event_Observer $observer)
    {
        $observer->getDebugInfo()->setQuote($this->getQuoteInfo());
    }

    /**
     * Quote information including quote items, payment method, shipping method and billing/shipping address
     * @return array
     */
    protected function getQuoteInfo()
    {
        $quote_info = array();
        if (!Mage::helper('core')->isModuleEnabled("Mage_Sales")) {
            return $quote_info;
        }
        $quote = Mage::getModel('checkout/cart')->getQuote();
        if ($quote->getId()) {
            $quote_info = array(
                "id" => $quote->getId(),
                "quote_currency_code" => $quote->getQuoteCurrencyCode(),
                "store_currency_code" => $quote->getStoreCurrencyCode(),
                "base_currency_code" => $quote->getBaseCurrencyCode(),
                "applied_rule_ids" => $quote->getAppliedRuleIds(),
                "subtotal" => $quote->getSubtotal(),
                "subtotal_with_discount" => $quote->getBaseSubtotalWithDiscount(),
                "grand_total" => $quote->getGrandTotal(),
                "updated_at" => $quote->getUpdatedAt(),
                "customer_group_id" => $quote->getCustomerGroupId(),
                "customer_tax_class_id" => $quote->getCustomerTaxClassId(),
                "billing_address" => $this->formatAddress($quote->getBillingAddress()),
                "shipping_address" => $this->formatAddress($quote->getShippingAddress()),
                "items_count" => $quote->getItemsCount(),
                "items" => $this->getQuoteItems($quote)
            );
            if ($quote->getPayment() && $quote->getPayment()->getMethod()) {
                $quote_info['payment_method'] = $quote->getPayment()->getMethod();
            }
            if ($quote->getShippingAddress() && $quote->getShippingAddress()->getShippingMethod()) {
                $quote_info['shipping_method'] = $quote->getShippingAddress()->getShippingMethod();
            }
        }

        return $quote_info;
    }

    /**
     * Return selected address items (type, name, country, vat_id)
     * @param $address
     * @return array|string
     */
    protected function formatAddress($address)
    {
        if (!$address) {
            return "-";
        }
        /** @var $address Mage_Sales_Model_Quote_Address */
        return array(
            "type" => $address->getAddressType(),
            "name" => $address->getName(),
            "country" => $address->getCountryId(),
            "vat_id" => $address->getVatId(),
        );
    }

    /**
     * Info of quote all quote items
     * @param Mage_Sales_Model_Quote $quote
     * @return array
     */
    protected function getQuoteItems(Mage_Sales_Model_Quote $quote)
    {
        $items = array();
        if ($quote->getItemsCount() > 0) {
            $helper = Mage::helper('catalog/product_configuration');
            /** @var $item Mage_Sales_Model_Quote_Item */
            foreach ($quote->getAllItems() as $item) {
                $items[] = array(
                    "row_id" => $item->getId(),
                    "price" => $item->getPrice(),
                    "qty" => $item->getQty(),
                    "product_id" => $item->getProduct()->getId(),
                    "sku" => $item->getSku(),
                    "name" => $item->getName(),
                    "applied_rules" => $item->getAppliedRuleIds(),
                    "row_total" => $item->getRowTotal(),
                    "row_total_incl_tax" => $item->getRowTotalInclTax(),
                    "row_total_with_discount" => $item->getRowTotalWithDiscount(),
                    "options" => $helper->getCustomOptions($item),
                );
            }
        }
        return $items;
    }
}