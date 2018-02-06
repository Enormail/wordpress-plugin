<?php

class Enormail_WooCommerce {

    public function get_customer_email_form_order($order_id)
    {
        if (empty($order_id)) {
            return false;
        }

        $order = wc_get_order($order_id);

        return (method_exists($order, 'get_billing_email')) ? $order->get_billing_email() : $order->billing_email;
    }

}