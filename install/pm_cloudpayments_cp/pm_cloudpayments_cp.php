<?php

  /**
   * @version      4.13.0 05.11.2013
   * @author       MAXXmarketing GmbH
   * @package      Jshopping
   * @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
   * @license      GNU/GPL
   */
  defined('_JEXEC') or die();

  class pm_cloudpayments_cp extends PaymentRoot
  {

    function showEndForm($params, $order)
    {
        $params['PAYMENT_ID'] = $order->order_id;
        $params['PAYMENT_BUYER_EMAIL'] = $order->email;
        $params['PAYMENT_BUYER_PHONE'] = $order->phone;
        $order->order_total = self::fixOrderTotal($order);
        $params['sum'] = $order->order_total;

        if (!empty($params['checksend'])):
            $OrderItems = self::getOrderItems($order->order_id);
            if ($OrderItems && count($OrderItems) > 0):

                $order_discount = 0;
                foreach ($OrderItems as $item):
                    if ($order_discount == 0 && number_format(floatval($item['product_item_price'] * $item['product_quantity']), 2, ".", '') > $order->order_discount && $order->order_discount > 0) {
                        $amount = number_format(floatval($item['product_item_price'] * $item['product_quantity']), 2, ".", '') - $order->order_discount;
                        $order_discount = $order->order_discount;
                    }
                    else {
                        $amount = number_format(floatval($item['product_item_price'] * $item['product_quantity']), 2, ".", '');
                    }
                    $items[] = array(
                        //'label' => iconv("utf-8","cp1251",$item['product_name']),
                        'label' => $item['product_name'],
                        'price' => number_format($item['product_item_price'], 2, ".", ''),
                        'quantity' => $item['product_quantity'],
                        'amount' => $amount,
                        'vat' => $params['nds_product'],
                        'method'   => (int)$params['kassa_method'],
                        'object'   => (int)$params['kassa_object'],
                    );
                endforeach;

                if ($order->order_shipping && $order->order_shipping > 0):
                    $items[] = array(
                        //'label' => iconv("utf-8","cp1251","Доставка"),
                        'label' => "Доставка",
                        'price' => number_format($order->order_shipping, 2, ".", ''),
                        'quantity' => 1,
                        'amount' => number_format($order->order_shipping, 2, ".", ''),
                        'vat' => $params['nds_delivery'],
                        'method'   => (int)$params['kassa_method'],
                        'object'   => 4,
                    );
                endif;

                if ($order->order_payment && $order->order_payment > 0):
                    $items[] = array(
                        //'label' => iconv("utf-8","cp1251","Стоимость способа оплаты"),
                        'label' => "Стоимость способа оплаты",
                        'price' => number_format($order->order_payment, 2, ".", ''),
                        'quantity' => 1,
                        'amount' => number_format($order->order_payment, 2, ".", ''),
                        'vat' => $params['nds_product'],
                        'method'   => (int)$params['kassa_method'],
                        'object'   => 4,
                    );
                endif;

                if ($order->order_package && $order->order_package > 0):
                    $items[] = array(
                        //'label' => iconv("utf-8","cp1251","Стоимость упаковки"),
                        'label' => "Стоимость упаковки",
                        'price' => number_format($order->order_package, 2, ".", ''),
                        'quantity' => 1,
                        'amount' => number_format($order->order_package, 2, ".", ''),
                        'vat' => $params['nds_product'],
                        'method'   => (int)$params['kassa_method'],
                        'object'   => (int)$params['kassa_object'],
                    );
                endif;

                $data['cloudPayments']['customerReceipt']['Items'] = $items;
                $data['cloudPayments']['customerReceipt']['taxationSystem'] = $params['TYPE_NALOG'];
                $data['cloudPayments']['customerReceipt']['calculationPlace'] = $params['calculationPlace'];
                $data['cloudPayments']['customerReceipt']['email'] = $params['PAYMENT_BUYER_EMAIL'];
                $data['cloudPayments']['customerReceipt']['phone'] = $params['PAYMENT_BUYER_PHONE'];
                $data['cloudPayments']['customerReceipt']['amounts']['electronic'] = number_format($params['sum'], 2, '.', '');
            endif;
        endif;
        
        //$descr = iconv("utf-8","cp1251","заказ № " . $params['PAYMENT_ID'] . " на " . $_SERVER["HTTP_HOST"] . " от " . date("d-m-y h:i:s"));
        $descr = "заказ № " . $params['PAYMENT_ID'] . " на " . $_SERVER["HTTP_HOST"] . " от " . date("d-m-y h:i:s");

        $output = '<script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>    
                <script src="https://widget.cloudpayments.ru/bundles/cloudpayments?cms=Joomshoping"></script>
                <button class="cloudpay_button" id="payButton">Pay</button>
                <div id="result" style="display:none"></div>
                <script type="text/javascript">
                    var payHandler = function () {
                        var widget = new cp.CloudPayments({' . "language:'" . $params['lang_widget'] . "'});
                        widget.".$params['payment_scheme']."({ // options
                                publicId: '" . trim($params["publicId"]) . "',
                                description: '".$descr."', 
                                amount: " . number_format($params['sum'], 2, '.', '') . ",
                                currency: '" . $params['PAYMENT_CURRENCY'] . "',
                                skin: '" . $params['skin_widget']."',
                                email: '" . $params['PAYMENT_BUYER_EMAIL'] . "',
                                invoiceId: '" . $params["PAYMENT_ID"] . "',
                                accountId: '',";
        if (!empty($params['checksend'])):
            $output .= "data: " . self::cur_json_encode($data) . ",";
        endif;

        $output .= "
                    },
                    function (options) { ";
        $output .= '
                    window.location.href="/index.php?option=com_jshopping&controller=checkout&task=step7&act=return&js_paymentclass=pm_cloudpayments_cp&InvoiceId='.$params["PAYMENT_ID"].'";';
        $output .= '
                    },
                    function (reason, options) { ';
        $output .= '
                      window.location.href="/index.php?option=com_jshopping&controller=checkout&task=step7&act=cancel&js_paymentclass=pm_cloudpayments_cp&InvoiceId='.$params["PAYMENT_ID"].'"';
        $output .= '
                     });
                     };
                     $("#payButton").on("click", payHandler); 
                     $("#payButton").trigger("click");
                     </script>';
        echo $output;
        die();
    }

    function showPaymentForm($params, $pmconfigs)
    {
        include(dirname(__FILE__) . "/paymentform.php");
    }

    function loadLanguageFile()
    {
        $lang = JFactory::getLanguage();
        $lang_tag = $lang->getTag();
        $lang_dir = JPATH_ROOT . '/components/com_jshopping/payments/pm_cloudpayments_cp/lang/';
        $lang_file = $lang_dir . $lang_tag . '.php';
        if (file_exists($lang_file)) require_once $lang_file;
        else require_once $lang_dir . 'en-GB.php';
    }

    //function call in admin
    function showAdminFormParams($params)
    {   
        if (isset($params[$key])) {
            $array_params = array('testmode', 'email_received', 'transaction_end_status', 'transaction_pending_status', 'transaction_failed_status');
            foreach ($array_params as $key) {
                if (!isset($params[$key]))
                    $params[$key] = '';
            }
            if (!isset($params['use_ssl'])) $params['use_ssl'] = 0;
            if (!isset($params['address_override'])) $params['address_override'] = 0;
        }
        $ssl_options = array();
        $ssl_options[] = JHTML::_('select.option', 4, 'TLSv1_0', 'id', 'name');
        $ssl_options[] = JHTML::_('select.option', 5, 'TLSv1_1', 'id', 'name');
        $ssl_options[] = JHTML::_('select.option', 6, 'TLSv1_2', 'id', 'name');

        $orders = JSFactory::getModel('orders', 'JshoppingModel'); //admin model
        self::loadLanguageFile();
        include(dirname(__FILE__) . "/adminparamsform.php");
    }

    function getUrlParams($pmconfigs)
    {
        $params = array();
        $data['order_id'] = $_REQUEST['InvoiceId'];
        $data['status'] = 5;
        $data['status_id'] = '';
        $data['sendmessage'] = 0;
        $data['notify'] = 0;
        $data['comments'] = '';
        $data['include'] = '';
        $data['view_order'] = 0;

        $params['order_id'] = $_REQUEST['InvoiceId'];
        $params['hash'] = "";
        $params['checkHash'] = 0;
        $params['checkReturnParams'] = 1;
        return $params;
    }

    function checkTransaction($pmconfigs, $order, $act)
    {
        if ($act == 'check_') {
            return self::processCheckAction($pmconfigs, $_REQUEST);
        } elseif ($act == 'fail_') {
            return self::processFailAction($pmconfigs, $_REQUEST);
        } elseif ($act == 'pay_') {
            return self::processSuccessAction($pmconfigs, $_REQUEST);
        } elseif ($act == 'refund_') {
            return self::processrefundAction($pmconfigs, $_REQUEST);
        } elseif ($act == 'confirm_') {
            return self::processconfirmAction($pmconfigs, $_REQUEST);
        } elseif ($act == 'cancel_') {
            return self::processCancelAction($pmconfigs, $_REQUEST);
        }
        else
        {
            $return = 1;
            return array(2, "Status pending. Order ID ".$order->order_id, $transaction, $transactiondata);
        }

    }

    public function processCheckAction($pmconfigs, $request)
    {

        $order = self::get_order($request);
        if (!$order):
            json_encode(array("ERROR" => 'order empty'));
            die();
        endif;
        $accesskey = trim($pmconfigs['secret_api']);
        if (self::CheckHMac($accesskey)) {
            if (self::isCorrectSum($request, $order)) {
                $data['CODE'] = 0;
        } else {
            $data['CODE'] = 11;
            $errorMessage = 'Incorrect payment sum';
        }

        $data['CODE'] = 0;
        $orderID = $request['InvoiceId'];

        if ($order['order_status'] == $pmconfigs['transaction_pay_status']):
          $data['CODE'] = 13;
          $errorMessage = 'Order already paid';
          self::addError($errorMessage);
        else:
          $data['CODE'] = 0;
        endif;


        if (($order['order_status'] == $pmconfigs['transaction_pay_status']) || ($order['order_status'] == $pmconfigs['transaction_refund_status'])) {
          $data['CODE'] = 13;
        }
      } else {
        $errorMessage = 'ERROR HMAC RECORDS';
        self::addError($errorMessage);
        $data['CODE'] = 5204;
      }

      self::addError(json_encode($data));
      if ($data['CODE']==0) self::finish_order($order['order_id']);
      echo json_encode($data);
      die();
    }

  private function changeProductQTYinStock($change = "-",$order_id){
      $db = & JFactory::getDBO();
      $dispatcher = JDispatcher::getInstance();

      $query = "SELECT OI.*, P.unlimited FROM `#__jshopping_order_item` as OI left join `#__jshopping_products` as P on P.product_id=OI.product_id
                  WHERE order_id = '".$db->escape($order_id)."'";
      $db->setQuery($query);
      $items = $db->loadObjectList();
     // $dispatcher->trigger('onBeforechangeProductQTYinStock', array(&$items, &$this, &$change));

      foreach($items as $item){

        if ($item->unlimited) continue;

        if ($item->attributes!=""){
          $attributes = unserialize($item->attributes);
        }else{
          $attributes = array();
        }
        if (!is_array($attributes)) $attributes = array();

        $allattribs = JSFactory::getAllAttributes(1);
        $dependent_attr = array();
        foreach($attributes as $k=>$v){
          if ($allattribs[$k]->independent==0){
            $dependent_attr[$k] = $v;
          }
        }

        if (count($dependent_attr)){
          $where="";
          foreach($dependent_attr as $k=>$v){
            $where.=" and `attr_".(int)$k."`=".intval($v);
          }
          $query = "update `#__jshopping_products_attr` set `count`=`count`  ".$change." ".$item->product_quantity." where product_id='".intval($item->product_id)."' ".$where;
          $db->setQuery($query);
          $db->query();

          $query="select sum(count) as qty from `#__jshopping_products_attr` where product_id='".intval($item->product_id)."' and `count`>0 ";
          $db->setQuery($query);
          $qty = $db->loadResult();

          $query = "UPDATE `#__jshopping_products` SET product_quantity = '".$qty."' WHERE product_id = '".intval($item->product_id)."'";
          $db->setQuery($query);
          $db->query();
        }else{
          $query = "UPDATE `#__jshopping_products` SET product_quantity = product_quantity ".$change." ".$item->product_quantity." WHERE product_id = '".intval($item->product_id)."'";
          $db->setQuery($query);
          $db->query();
        }
      //  $dispatcher->trigger('onAfterchangeProductQTYinStock', array(&$item, &$change, &$this));
      }

      if ($change=='-'){
        $product_stock_removed = 1;
      }else{
        $product_stock_removed = 0;
      }
      $query = "update #__jshopping_orders set product_stock_removed=".$product_stock_removed." WHERE order_id = '".$db->escape($order_id)."'";
      $db->setQuery($query);
      $db->query();
    //  $dispatcher->trigger('onAfterchangeProductQTYinStockPSR', array(&$items, &$this, &$change, &$product_stock_removed));
    }


    private function processSuccessAction($pmconfigs,$request)
    {
      $order = self::get_order($request);
      self::addError("---------processSuccessAction--------");
      $data['CODE'] = 0;

      $data2['order_id'] = $_REQUEST['InvoiceId'];
      if ( $pmconfigs['payment_scheme'] == 'charge' ) {
        $data2['status'] = $pmconfigs['transaction_pay_status'];
      }
      else {
          $data2['status'] = $pmconfigs['transaction_auth_status'];
      };
      $data2['status_id'] = '';
      $data2['sendmessage'] = 0;
      $data2['notify'] = 0;
      $data2['comments'] = '';
      $data2['include'] = '';
      $data2['view_order'] = 0;
      self::updateStatus($data2);

      $data3['order_id'] = $_REQUEST['InvoiceId'];
      $data3['transaction'] = $_REQUEST['TransactionId'];
      self::SetTransaction($data3);
      self::changeProductQTYinStock("-",$data3['order_id']);
     // self::SetTransactionId($order, $request['TransactionId']);
      $checkout = JSFactory::getModel('checkout', 'jshop');
      $checkout->sendOrderEmail($data2['order_id'], 0);

      echo json_encode($data);
      die();
    }
    
    private function processconfirmAction($pmconfigs,$request)       ///
    {
      $order = self::get_order($request);
      self::addError("---------processconfirmAction--------");
      $data['CODE'] = 0;

      $data2['order_id'] = $_REQUEST['InvoiceId'];
      $data2['status'] = $pmconfigs['transaction_pay_status'];
      $data2['status_id'] = '';
      $data2['sendmessage'] = 0;
      $data2['notify'] = 0;
      $data2['comments'] = '';
      $data2['include'] = '';
      $data2['view_order'] = 0;
      self::updateStatus($data2);

      $data3['order_id'] = $_REQUEST['InvoiceId'];
      $data3['transaction'] = $_REQUEST['TransactionId'];
      self::SetTransaction($data3);
      self::changeProductQTYinStock("-",$data3['order_id']);
     // self::SetTransactionId($order, $request['TransactionId']);
      $checkout = JSFactory::getModel('checkout', 'jshop');
      $checkout->sendOrderEmail($data2['order_id'], 0);


      self::addError('PAY_COMPLETE');
      self::addError('----------data============');
      self::addError($data);
      self::addError($data2);
      echo json_encode($data);
      die();
    }

    private function processFailAction($pmconfigs,$request)    // ok
    {
      $order = self::get_order($request);

      $data['CODE'] = 0;
      $data2['order_id'] = $_REQUEST['InvoiceId'];
      $data2['status'] = $pmconfigs['transaction_refund_status'];
      $data2['status_id'] = '';
      $data2['sendmessage'] = 0;
      $data2['notify'] = 0;
      $data2['comments'] = '';
      $data2['include'] = '';
      $data2['view_order'] = 0;
      self::updateStatus($data2);
      return $result;
    }

    private function processrefundAction($pmconfigs, $request)
    {
      $data2['order_id'] = $_REQUEST['InvoiceId'];
      $data2['status'] = $pmconfigs['transaction_refund_status'];
      $data2['status_id'] = '';
      $data2['sendmessage'] = 0;
      $data2['notify'] = 0;
      $data2['comments'] = '';
      $data2['include'] = '';
      $data2['view_order'] = 0;
      self::updateStatus($data2);
      $data['CODE'] = 0;
      echo json_encode($data);
      die();
    }///ok

    private function processCancelAction($pmconfigs, $request)
    {
      $data2['order_id'] = $_REQUEST['InvoiceId'];
      $data2['status'] = 3;
      $data2['status_id'] = '';
      $data2['sendmessage'] = 0;
      $data2['notify'] = 0;
      $data2['comments'] = '';
      $data2['include'] = '';
      $data2['view_order'] = 0;
      self::updateStatus($data2);
      $data['CODE'] = 0;
      echo json_encode($data);
      die();
    }//ok

    function get_order($request)
    {
      if (!$request['InvoiceId'])
        return false;

      $db =& JFactory::getDBO();
      $q = "SELECT * FROM `#__jshopping_orders` where `order_id`=" . $request['InvoiceId'];
      $db->setQuery($q);
      $data_rows_assoc_list = $db->loadAssocList();

      return $data_rows_assoc_list[0];
    }//ok

    private function CheckHMac($APIPASS)   //ok
    {
      $headers = self::detallheaders();
      self::addError(print_r($headers, true));

      if (isset($headers['Content-HMAC']) || isset($headers['Content-Hmac'])) {
        self::addError('HMAC_1');
        self::addError($APIPASS);
        $message = file_get_contents('php://input');
        $s = hash_hmac('sha256', $message, $APIPASS, true);
        $hmac = base64_encode($s);

        self::addError(print_r($hmac, true));
        if ($headers['Content-HMAC'] == $hmac)
          return true;
        elseif ($headers['Content-Hmac'] == $hmac)
          return true;
      } else {return false;}
    }

    private function detallheaders()  ///OK
    {
      if (!is_array($_SERVER)) {
        return array();
      }
      $headers = array();
      foreach ($_SERVER as $name => $value) {
        if (substr($name, 0, 5) == 'HTTP_') {
          $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
        }
      }
      return $headers;
    }

    private function isCorrectSum($request, $order)  ////ok
    {
      $sum = $request['Amount'];
      $paymentSum = $order['order_total'];
      self::addError('get_total->' . $paymentSum);

      return round($paymentSum, 2) == round($sum, 2);
    }

    function finish_order($order_id)
    {
      self::addError("finish_order");
      $db = JFactory::getDbo();

      // Получаем объект запроса
      $query = $db->getQuery(true);

      // Поля для обновления
      $fields = array(
        $db->quoteName('order_created') . ' = 1',
        $db->quoteName('product_stock_removed') . ' = 1',
      );

      // Условия обновления
      $conditions = array(
        $db->quoteName('order_id') . ' = '.$order_id
      );

      $query->update($db->quoteName('#__jshopping_orders'))
        ->set($fields)
        ->where($conditions);

      // Устанавливаем и выполняем запрос
      $db->setQuery($query)
        ->execute();
    }

    function updateStatus($data)
    {
      self::addError("----updateStatus----");
      self::addError($data);
     // JPluginHelper::importPlugin( 'plugingroup' );
      //$dispatcher = JDispatcher::getInstance();
     // $dispatcher = JEventDispatcher::getInstance();
/*      $dispatcher->trigger(
        'onBeforeChangeOrderStatusAdmin',
        array(
          $data['order_id'], $data['status'], $data['status_id'], $data['notify'], $data['comments'], $data['include_comment'], $data['view_order']
        )
      );*/
      JPluginHelper::importPlugin('jshoppingadmin');
      $dispatcher = JDispatcher::getInstance();
      //$dispatcher->trigger('rsfp_afterConfirmPayment', array($updatedSubmissionId));
      $result =  $dispatcher->trigger(
        'onBeforeChangeOrderStatus',
        array(
          $data['order_id'], $data['status'], $data['sendmessage'], $data['comments']
        )
      );

      //$dispatcher = JDispatcher::getInstance();

      $model = JSFactory::getModel('orderChangeStatus', 'jshop');
      $model->setData($data['order_id'], $data['status'], $data['sendmessage'], $data['status_id'], $data['notify'], $data['comments'], $data['include'], $data['view_order']);
      $model->setAppAdmin(1);
      $model->store();
    }

    function nofityFinish($pmconfigs, $order, $rescode)
    {
      self::addError("nofityFinish");
    }

    function cur_json_encode($a = false)      /////ok
    {
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

    function pre($array)
    {
      echo '<pre>';
      print_r($array);
      echo '</pre>';
      die();
    }

    function fixOrderTotal($order)
    {
      $total = $order->order_total;
      if ($order->currency_code_iso == 'HUF') {
        $total = round($total);
      } else {
        $total = number_format($total, 2, '.', '');
      }
      return $total;
    }///ok

    function getOrderItems($ORDER_ID)
    {
      if (!$ORDER_ID)
        return false;

      $db =& JFactory::getDBO();
      $q = "SELECT * FROM `#__jshopping_order_item` where `order_id`=" . $ORDER_ID;
      $db->setQuery($q);
      $data_rows_assoc_list = $db->loadAssocList();

      return $data_rows_assoc_list;
    }

    function addError($str)
    {
      //$file = $_SERVER['DOCUMENT_ROOT'] . '/log_cloud1.txt';
      //$current = file_get_contents($file);
      //$current .= print_r($str, 1) . "\n";
      //file_put_contents($file, $current);
    }

    function SetTransaction($data)
    {
      self::addError("finish_order");
      $db = JFactory::getDbo();

      // Получаем объект запроса
      $query = $db->getQuery(true);

      // Поля для обновления
      $fields = array(
        $db->quoteName('transaction') . ' = '.$data['transaction'],
      );

      // Условия обновления
      $conditions = array(
        $db->quoteName('order_id') . ' = '.$data['order_id']
      );

      $query->update($db->quoteName('#__jshopping_orders'))
        ->set($fields)
        ->where($conditions);

      // Устанавливаем и выполняем запрос
      $db->setQuery($query)
        ->execute();
    }




  }