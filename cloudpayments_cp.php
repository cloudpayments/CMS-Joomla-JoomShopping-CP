<?php  
// Запрет прямого доступа.  
defined('_JEXEC') or die;  
class plgJshoppingAdminCloudpayments_Cp extends JPlugin  {   
    
    function install($parent) {     
        jimport('joomla.filesystem.folder');      
        jimport('joomla.filesystem.file');      
        JFolder::move(JUri::root().'/plugins/jshoppingadmin/cloudpayments_cp/install/pm_cloudpayments_cp', 
        JUri::root() . '/components/com_jshopping/payments/pm_cloudpayments_cp');     
    }     
    
    public function onBeforeChangeOrderStatusAdmin($order_id, $status, $status_id, $notify, $comments, $include_comment, $view_order)    {
        if ($status):  
            
            if ($status == 4) {
                self::refund_($order_id);            
            }
            
            $payment_params = self::getPaymentParams_();
            $delivered_status = $payment_params['transaction_delivered_status'];
            
            if ($status == $delivered_status && $payment_params['checksend'] != 0 && ($payment_params['kassa_method'] == 1 || $payment_params['kassa_method'] == 2 ||$payment_params['kassa_method'] == 3)) {
                self::check_order($order_id, $status); 
            }
        endif;    
    }    
    
    function check_order($order_id, $status) {
        $params = self::getPaymentParams_();
        $request['InvoiceId'] = $order_id;
        $order = self::get_order($order_id);
        self::SendReceipt($order, 'Income', $params);
    }
    
    public function SendReceipt($order, $type, $params) {
        $OrderItems = self::getOrderItems($order['order_id']);
        if ($OrderItems && count($OrderItems) > 0):
            $order_discount = 0;
            foreach ($OrderItems as $item):
                if ($order_discount == 0 && number_format(floatval($item['product_item_price'] * $item['product_quantity']), 2, ".", '') > $order['order_discount'] && $order['order_discount'] > 0) {
                  $amount = number_format(floatval($item['product_item_price'] * $item['product_quantity']), 2, ".", '') - $order['order_discount'];
                  $order_discount = $order['order_discount'];
                }
                else {
                    $amount = number_format(floatval($item['product_item_price'] * $item['product_quantity']), 2, ".", '');
                }
                $items[] = array(
                    'label' => $item['product_name'],
                    'price' => number_format($item['product_item_price'], 2, ".", ''),
                    'quantity' => $item['product_quantity'],
                    'amount' => $amount,
                    'vat' => $params['nds_product'],
                    'method'   => 4,
                    'object'   => (int)$params['kassa_object'],
                );
            endforeach;

            if ($order['order_shipping'] && $order['order_shipping'] > 0):
                $items[] = array(
                    'label' => "Доставка",
                    'price' => number_format($order['order_shipping'], 2, ".", ''),
                    'quantity' => 1,
                    'amount' => number_format($order['order_shipping'], 2, ".", ''),
                    'vat' => $params['nds_delivery'],
                    'method'   => 4,
                    'object'   => 4,
                );
            endif;

            if ($order['order_payment'] && $order['order_payment'] > 0):
                $items[] = array(
                    'label' => "Стоимость способа оплаты",
                    'price' => number_format($order['order_payment'], 2, ".", ''),
                    'quantity' => 1,
                    'amount' => number_format($order['order_payment'], 2, ".", ''),
                    'vat' => $params['nds_product'],
                    'method'   => 4,
                    'object'   => 4,
                );
            endif;

            if ($order['order_package'] && $order['order_package'] > 0):
                $items[] = array(
                    'label' => "Стоимость упаковки",
                    'price' => number_format($order['order_package'], 2, ".", ''),
                    'quantity' => 1,
                    'amount' => number_format($order['order_package'], 2, ".", ''),
                    'vat' => $params['nds_product'],
                    'method'   => 4,
                    'object'   => (int)$params['kassa_object'],
                );
            endif;

            $data['cloudPayments']['customerReceipt']['Items'] = $items;
            $data['cloudPayments']['customerReceipt']['taxationSystem'] = $params['TYPE_NALOG'];
            $data['cloudPayments']['customerReceipt']['calculationPlace'] = $params['calculationPlace'];
            $data['cloudPayments']['customerReceipt']['email'] = $order['email'];
            $data['cloudPayments']['customerReceipt']['phone'] = $order['phone'];
            $data['cloudPayments']['customerReceipt']['amounts']['advancePayment'] = number_format($order['order_total'], 2, '.', '');
        endif;

        $aData = array(
            'Inn' => $params['inn'],
            'InvoiceId' => $order['order_id'], //номер заказа, необязательный
            'Type' => $type,
            'CustomerReceipt' => $data['cloudPayments']['customerReceipt']
        );
        $API_URL = 'https://api.cloudpayments.ru/kkt/receipt';
        self::send_request($API_URL, $aData);
    }

    public function send_request($API_URL, $request) {
        $params = self::getPaymentParams_();
        if ($curl = curl_init()):
            $request2 = self::cur_json_encode($request);

            $str = date("d-m-Y H:i:s") . $request['Type'] . $request['InvoiceId'] . $request['AccountId'] . $request['CustomerReceipt']['email'];
            $reque = md5($str);
            $ch = curl_init($API_URL);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, $params['publicId'] . ":" . $params['secret_api']);
            curl_setopt($ch, CURLOPT_URL, $API_URL);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "X-Request-ID:" . $reque));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $request2);
            $content = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);
        endif;
    }
    
    function cur_json_encode($a = false) {
        if (is_null($a) || is_resource($a)) {
            return 'null';
        }
        if ($a === false) {
            return 'false';
        }
        if ($a === true) {
            return 'true';
        }
        if (is_scalar($a)) {
            if (is_float($a)) {
                //Always use "." for floats.
                $a = str_replace(',', '.', strval($a));
            }

            // All scalars are converted to strings to avoid indeterminism.
            // PHP's "1" and 1 are equal for all PHP operators, but
            // JS's "1" and 1 are not. So if we pass "1" or 1 from the PHP backend,
            // we should get the same result in the JS frontend (string).
            // Character replacements for JSON.
            static $jsonReplaces = array(
                array("\\", "/", "\n", "\t", "\r", "\b", "\f", '"'),
                array('\\\\', '\\/', '\\n', '\\t', '\\r', '\\b', '\\f', '\"')
            );

            return '"' . str_replace($jsonReplaces[0], $jsonReplaces[1], $a) . '"';
        }

        $isList = true;

        for ($i = 0, reset($a); $i < count($a); $i++, next($a)) {
            if (key($a) !== $i) {
                $isList = false;
                break;
            }
        }

        $result = array();

        if ($isList) {
            foreach ($a as $v) {
                $result[] = self::cur_json_encode($v);
            }

            return '[ ' . join(', ', $result) . ' ]';
        } else {
            foreach ($a as $k => $v) {
                $result[] = self::cur_json_encode($k) . ': ' . self::cur_json_encode($v);
            }

            return '{ ' . join(', ', $result) . ' }';
        }
    }
    
    function refund_($order_id)    {
        $order = self::get_order($order_id);
        $request = array(
            'TransactionId' => $order['transaction'],
            'Amount' => number_format($order['order_total'], 2, '.', ''),
        );      
        $url = 'https://api.cloudpayments.ru/payments/refund';
        $payment_params = self::getPaymentParams_();
        $accesskey = $payment_params['publicId'];
        $access_psw = $payment_params['secret_api'];
        if ($accesskey && $access_psw) {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, $accesskey . ":" . $access_psw);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
            $content = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);
            $out = self::Object_to_array(json_decode($content));
        }    
    }    
    public function addError($str)    {
        //$file = $_SERVER['DOCUMENT_ROOT'] . '/log_cloud1.txt';
        //$current = file_get_contents($file);
        //$current .= print_r($str, 1) . "\n";
        //file_put_contents($file, $current);
    }    
    public function Object_to_array($data)  {
        if (is_array($data) || is_object($data)) {
            $result = array();
            foreach ($data as $key => $value) {
                $result[$key] = self::Object_to_array($value);
            }        
            return $result;
        }
        return $data;
    }
    function get_order($order_id)    {
        if (!$order_id)        
            return false;
        $db =& JFactory::getDBO();
        $q = "SELECT * FROM `#__jshopping_orders` where `order_id`=" . $order_id;      $db->setQuery($q);
        $data_rows_assoc_list = $db->loadAssocList();
        return $data_rows_assoc_list[0];
    }
    function getPaymentParams_()    {
        $db =& JFactory::getDBO();
        $q = "SELECT * FROM `#__jshopping_payment_method` where `payment_class`='pm_cloudpayments_cp'";
        $db->setQuery($q);
        $data_rows_assoc_list = $db->loadAssocList();
        $params_tmp = str_replace(array("\r\n", "\r", "\n"), '+---+', $data_rows_assoc_list[0]['payment_params']);
        $params_ = explode("+---+", $params_tmp);
        foreach ($params_ as $value):
            $tmp_1 = explode("=",$value);
            $pm_params[$tmp_1[0]] =$tmp_1[1];
        endforeach;
        return $pm_params;
    }
    
    function getOrderItems($ORDER_ID) {
        if (!$ORDER_ID)
            return false;

        $db =& JFactory::getDBO();
        $q = "SELECT * FROM `#__jshopping_order_item` where `order_id`=" . $ORDER_ID;
        $db->setQuery($q);
        $data_rows_assoc_list = $db->loadAssocList();

        return $data_rows_assoc_list;
    }
}
