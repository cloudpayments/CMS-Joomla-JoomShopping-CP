<?php
//ini_set('display_errors','Off');
//error_reporting('E_ALL');
  /**
   * @version      4.12.2 05.11.2013
   * @author       MAXXmarketing GmbH
   * @package      Jshopping
   * @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
   * @license      GNU/GPL
   */
  defined('_JEXEC') or die();

  $nds_list = array();
  $nds_list[] = JHTML::_('select.option', '',SALE_HPS_NDS_0, 'value', 'text');
  $nds_list[] = JHTML::_('select.option', '10',SALE_HPS_NDS_1, 'value', 'text');
  $nds_list[] = JHTML::_('select.option', '20',SALE_HPS_NDS_2, 'value', 'text');
  $nds_list[] = JHTML::_('select.option', '0',SALE_HPS_NDS_3, 'value', 'text');
  $nds_list[] = JHTML::_('select.option', '110',SALE_HPS_NDS_4, 'value', 'text');
  $nds_list[] = JHTML::_('select.option', '120',SALE_HPS_NDS_5, 'value', 'text');

  $lang_list = array();
  $lang_list[] = JHTML::_('select.option', 'ru-RU',SALE_HPS_WIDGET_LANG_TYPE_0, 'id', 'name');
  $lang_list[] = JHTML::_('select.option', 'en-US',SALE_HPS_WIDGET_LANG_TYPE_1, 'id', 'name');
  $lang_list[] = JHTML::_('select.option', 'lv',SALE_HPS_WIDGET_LANG_TYPE_2, 'id', 'name');

  $lang_list[] = JHTML::_('select.option', 'az',SALE_HPS_WIDGET_LANG_TYPE_3, 'id', 'name');
  $lang_list[] = JHTML::_('select.option', 'kk',SALE_HPS_WIDGET_LANG_TYPE_4, 'id', 'name');
  $lang_list[] = JHTML::_('select.option', 'kk-KZ',SALE_HPS_WIDGET_LANG_TYPE_5, 'id', 'name');

  $lang_list[] = JHTML::_('select.option', 'uk',SALE_HPS_WIDGET_LANG_TYPE_6, 'id', 'name');
  $lang_list[] = JHTML::_('select.option', 'pl',SALE_HPS_WIDGET_LANG_TYPE_7, 'id', 'name');
  $lang_list[] = JHTML::_('select.option', 'pt',SALE_HPS_WIDGET_LANG_TYPE_8, 'id', 'name');
  $lang_list[] = JHTML::_('select.option', 'cs-CZ',SALE_HPS_WIDGET_LANG_TYPE_9, 'id', 'name');
  
  $skin_list = array();
  $skin_list[] = JHTML::_('select.option', 'classic',SALE_HPS_WIDGET_SKIN_TYPE_0, 'id', 'name');
  $skin_list[] = JHTML::_('select.option', 'modern',SALE_HPS_WIDGET_SKIN_TYPE_1, 'id', 'name');
  $skin_list[] = JHTML::_('select.option', 'mini',SALE_HPS_WIDGET_SKIN_TYPE_2, 'id', 'name');
  
  $payment_scheme_list = array();
  $payment_scheme_list[] = JHTML::_('select.option', 'charge',SALE_HPS_TYPE_SCHEME_0, 'id', 'name');
  $payment_scheme_list[] = JHTML::_('select.option', 'auth',SALE_HPS_TYPE_SCHEME_1, 'id', 'name');

  $currency_list = array();

  $currency_list[] = JHTML::_('select.option', 'RUB',RUB, 'id', 'name');
  $currency_list[] = JHTML::_('select.option', 'EUR',EUR, 'id', 'name');
  $currency_list[] = JHTML::_('select.option', 'USD',USD, 'id', 'name');
  $currency_list[] = JHTML::_('select.option', 'GBP',GBP, 'id', 'name');
  $currency_list[] = JHTML::_('select.option', 'UAH',UAH, 'id', 'name');
  $currency_list[] = JHTML::_('select.option', 'BYN',BYN, 'id', 'name');
  $currency_list[] = JHTML::_('select.option', 'KZT',KZT, 'id', 'name');
  $currency_list[] = JHTML::_('select.option', 'AZN',AZN, 'id', 'name');
  $currency_list[] = JHTML::_('select.option', 'CHF',CHF, 'id', 'name');
  $currency_list[] = JHTML::_('select.option', 'CZK',CZK, 'id', 'name');
  $currency_list[] = JHTML::_('select.option', 'CAD',CAD, 'id', 'name');
  $currency_list[] = JHTML::_('select.option', 'PLN',PLN, 'id', 'name');
  $currency_list[] = JHTML::_('select.option', 'SEK',SEK, 'id', 'name');
  $currency_list[] = JHTML::_('select.option', 'TRY',TRY_, 'id', 'name');
  $currency_list[] = JHTML::_('select.option', 'CNY',CNY, 'id', 'name');
  $currency_list[] = JHTML::_('select.option', 'INR',INR, 'id', 'name');
  $currency_list[] = JHTML::_('select.option', 'BRL',BRL, 'id', 'name');
  $currency_list[] = JHTML::_('select.option', 'ZAL',ZAL, 'id', 'name');
  $currency_list[] = JHTML::_('select.option', 'UZS',UZS, 'id', 'name');
  $currency_list[] = JHTML::_('select.option', 'BGL',BGL, 'id', 'name');  


  $nalog_type = array();
  $nalog_type[] = JHTML::_('select.option', '0','Общая система налогообложения', 'value', 'text');
  $nalog_type[] = JHTML::_('select.option', '1','Упрощенная система налогообложения (Доход)', 'value', 'text');
  $nalog_type[] = JHTML::_('select.option', '2','Упрощенная система налогообложения (Доход минус Расход)', 'value', 'text');
  $nalog_type[] = JHTML::_('select.option', '3','Единый налог на вмененный доход', 'value', 'text');
  $nalog_type[] = JHTML::_('select.option', '4','Единый сельскохозяйственный налог', 'value', 'text');
  $nalog_type[] = JHTML::_('select.option', '5','Патентная система налогообложения', 'value', 'text');
  
  $kassa_method_list = array();
  $kassa_method_list[] = JHTML::_('select.option', '0','Способ расчета не передается', 'value', 'text');
  $kassa_method_list[] = JHTML::_('select.option', '1','Предоплата 100%', 'value', 'text');
  $kassa_method_list[] = JHTML::_('select.option', '2','Предоплата', 'value', 'text');
  $kassa_method_list[] = JHTML::_('select.option', '3','Аванс', 'value', 'text');
  $kassa_method_list[] = JHTML::_('select.option', '4','Полный расчёт', 'value', 'text');
  $kassa_method_list[] = JHTML::_('select.option', '5','Частичный расчёт и кредит', 'value', 'text');
  $kassa_method_list[] = JHTML::_('select.option', '6','Передача в кредит', 'value', 'text');
  $kassa_method_list[] = JHTML::_('select.option', '7','Оплата кредита', 'value', 'text');
  
  $kassa_object_list = array();
  $kassa_object_list[] = JHTML::_('select.option', '0','Предмет расчета не передается', 'value', 'text');
  $kassa_object_list[] = JHTML::_('select.option', '1','Товар', 'value', 'text');
  $kassa_object_list[] = JHTML::_('select.option', '2','Подакцизный товар', 'value', 'text');
  $kassa_object_list[] = JHTML::_('select.option', '3','Работа', 'value', 'text');
  $kassa_object_list[] = JHTML::_('select.option', '4','Услуга', 'value', 'text');
  $kassa_object_list[] = JHTML::_('select.option', '5','Ставка азартной игры', 'value', 'text');
  $kassa_object_list[] = JHTML::_('select.option', '6','Выигрыш азартной игры', 'value', 'text');
  $kassa_object_list[] = JHTML::_('select.option', '7','Лотерейный билет', 'value', 'text');
  $kassa_object_list[] = JHTML::_('select.option', '8','Выигрыш лотереи', 'value', 'text');
  $kassa_object_list[] = JHTML::_('select.option', '9','Предоставление РИД', 'value', 'text');
  $kassa_object_list[] = JHTML::_('select.option', '10','Платеж', 'value', 'text');
  $kassa_object_list[] = JHTML::_('select.option', '11','Агентское вознаграждение', 'value', 'text');
  $kassa_object_list[] = JHTML::_('select.option', '12','Составной предмет расчета', 'value', 'text');
  $kassa_object_list[] = JHTML::_('select.option', '13','Иной предмет расчета', 'value', 'text');
  
?>
<div class = "col100">
   <fieldset class = "adminform">
      <table class = "admintable" width = "100%">
         <tr>
            <td style = "width:250px;" class = "key">
              <?php echo _JSHOP_TESTMODE; ?>
            </td>
            <td>
              <?php
               if (isset($params['testmode']))
                {
                    print JHTML::_('select.booleanlist', 'pm_params[testmode]', 'class = "inputbox" size = "1"', $params['testmode']);
                }
                else print JHTML::_('select.booleanlist', 'pm_params[testmode]', 'class = "inputbox" size = "1"');
                
                echo " " . JHTML::tooltip(_JSHOP_PAYPAL_TESTMODE_DESCRIPTION);
              ?>
            </td>
         </tr>
         <!--
            - PublicID
            - SecretAPI;
            отображать урлы для обработки уведомлений;
            - Настройку параметров/выбор статусов  для обработчика уведомлений ;
            - выбор локализации модуля;
            - выбор языка виджета;
            - выбор дизайна виджета;
            - выбор валюты (опционально);
            - выбор НДС для товаров и НДС для доставки отдельно(опционально);
            - выбор системы налогообложения;
            - чекбокс включения отправки чеков.
            - Выбор валюты(если глобальный список валют меньше, чем список поддерживаемых валют CP)
          -->
         <tr>
            <td class = "key">
              <?php echo _JSHOP_SALE_HPS_CLOUDPAYMENT_SHOP_ID; ?>
            </td>
            <td>
               <input type = "text" class = "inputbox" name = "pm_params[publicId]" size = "45" value = "<?php if (isset($params['publicId'])) echo $params['publicId']; ?>"/>
              <?php echo JHTML::tooltip(_JSHOP_SALE_HPS_CLOUDPAYMENT_SHOP_ID_DESC); ?>
            </td>
         </tr>
         <tr>
            <td class = "key">
              <?php echo SALE_HPS_CLOUDPAYMENT_SHOP_KEY; ?>
            </td>
            <td>
               <input type = "text" class = "inputbox" name = "pm_params[secret_api]" size = "45" value = "<?php if (isset($params['secret_api'])) echo $params['secret_api']; ?>"/>
              <?php echo JHTML::tooltip(SALE_HPS_CLOUDPAYMENT_SHOP_KEY_DESC); ?>
            </td>
         </tr>
         <tr>
            <td class = "key">
              <?php echo SALE_HPS_CLOUDPAYMENT_TYPE_SYSTEM; ?>
            </td>
            <td>
              <?php
                if (isset($params['payment_scheme'])) {
                    print JHTML::_('select.genericlist', $payment_scheme_list, 'pm_params[payment_scheme]', 'class = "inputbox" size = "1"', 'id', 'name', $params['payment_scheme']);
                }
                else print JHTML::_('select.genericlist', $payment_scheme_list, 'pm_params[payment_scheme]', 'class = "inputbox" size = "1"', 'id', 'name');
              ?>
            </td>
         </tr>
         <tr>
            <td class = "key">
              <?php echo STATUS_PAY; ?>
            </td>
            <td>
              <?php
                if (isset($params['transaction_pay_status'])) {
                    print JHTML::_('select.genericlist', $orders->getAllOrderStatus(), 'pm_params[transaction_pay_status]', 'class = "inputbox" size = "1"', 'status_id', 'name', $params['transaction_pay_status']);
                }
                else print JHTML::_('select.genericlist', $orders->getAllOrderStatus(), 'pm_params[transaction_pay_status]', 'class = "inputbox" size = "1"', 'status_id', 'name');
                echo " " . JHTML::tooltip(SALE_HPS_CLOUDPAYMENT_SHOP_PAY_DESC);
              ?>
            </td>
         </tr>
         <tr>
        <tr>
            <td class = "key">
              <?php echo STATUS_AU; ?>
            </td>
            <td>
              <?php
                if (isset($params['transaction_auth_status'])) {
                    print JHTML::_('select.genericlist', $orders->getAllOrderStatus(), 'pm_params[transaction_auth_status]', 'class = "inputbox" size = "1"', 'status_id', 'name', $params['transaction_auth_status']);
                }
                else print JHTML::_('select.genericlist', $orders->getAllOrderStatus(), 'pm_params[transaction_auth_status]', 'class = "inputbox" size = "1"', 'status_id', 'name');
                echo " " . JHTML::tooltip(SALE_HPS_CLOUDPAYMENT_SHOP_AUTH_DESC);
              ?>
            </td>
         </tr>
         <tr>
            <td class = "key">
              <?php echo STATUS_CANCEL; ?>
            </td>
            <td>
              <?php
                if (isset($params['transaction_refund_status'])) {
                    print JHTML::_('select.genericlist', $orders->getAllOrderStatus(), 'pm_params[transaction_refund_status]', 'class = "inputbox" size = "1"', 'status_id', 'name', $params['transaction_refund_status']);
                }
                else print JHTML::_('select.genericlist', $orders->getAllOrderStatus(), 'pm_params[transaction_refund_status]', 'class = "inputbox" size = "1"', 'status_id', 'name');
                echo " " . JHTML::tooltip(SALE_HPS_CLOUDPAYMENT_SHOP_REFUND_DESC);
              ?>
            </td>
         </tr>
         <tr>
            <td class = "key">
              <?php echo SALE_HPS_CLOUDPAYMENT_WIDGET_LANG; ?>
            </td>
            <td>
              <?php
                if (isset($params['lang_widget'])) {
                    print JHTML::_('select.genericlist', $lang_list, 'pm_params[lang_widget]', 'class = "inputbox" size = "1"', 'id', 'name', $params['lang_widget']);
                }
                else print JHTML::_('select.genericlist', $lang_list, 'pm_params[lang_widget]', 'class = "inputbox" size = "1"', 'id', 'name');

              ?>
            </td>
         </tr>
         <tr>
            <td class = "key">
              <?php echo SALE_HPS_CLOUDPAYMENT_WIDGET_SKIN; ?>
            </td>
            <td>
              <?php
                if (isset($params['skin_widget'])) {
                    print JHTML::_('select.genericlist', $skin_list, 'pm_params[skin_widget]', 'class = "inputbox" size = "1"', 'id', 'name', $params['skin_widget']);
                }
                else print JHTML::_('select.genericlist', $skin_list, 'pm_params[skin_widget]', 'class = "inputbox" size = "1"', 'id', 'name');
              ?>
            </td>
         </tr>
         <tr>
            <td class = "key">
              <?php echo SALE_HPS_CLOUDPAYMENT_CURRENCY; ?>
            </td>
            <td>
              <?php
                if (isset($params['PAYMENT_CURRENCY'])) {
                    print JHTML::_('select.genericlist', $currency_list, 'pm_params[PAYMENT_CURRENCY]', 'class = "inputbox" size = "1"', 'id', 'name', $params['PAYMENT_CURRENCY']);
                }
                else print JHTML::_('select.genericlist', $currency_list, 'pm_params[PAYMENT_CURRENCY]', 'class = "inputbox" size = "1"', 'id', 'name');
              ?>
            </td>
         </tr>
         <tr>
            <td style = "width:250px;" class = "key">
              <?php echo SALE_HPS_CLOUDPAYMENT_CHECKONLINE; ?>
            </td>
            <td>
              <?php
                if (isset($params['checksend'])) {
                    print JHTML::_('select.booleanlist', 'pm_params[checksend]', 'class = "inputbox" size = "1"', $params['checksend']);
                }
                else print JHTML::_('select.booleanlist', 'pm_params[checksend]', 'class = "inputbox" size = "1"');
              ?>
            </td>
         </tr>
         <tr>
            <td class = "key">
              <?php echo SALE_HPS_CLOUDPAYMENT_INN; ?>
            </td>
            <td>
               <input type = "text" class = "inputbox" name = "pm_params[inn]" size = "45" value = "<?php if (isset($params['inn'])) echo $params['inn']; ?>"/>
              <?php echo JHTML::tooltip(SALE_HPS_CLOUDPAYMENT_INN_DESC); ?>
            </td>
         </tr>
         <tr>
            <td class = "key">
              <?php echo SALE_HPS_CLOUDPAYMENT_NDS; ?>
            </td>
            <td>
              <?php
                if (isset($params['nds_product'])) {
                    print JHTML::_('select.genericlist', $nds_list, $name = 'pm_params[nds_product]', $attribs = null, $key = 'value', $text = 'text', $params['nds_product'], $idtag = false, $translate = false);
                }
                else print JHTML::_('select.genericlist', $nds_list, $name = 'pm_params[nds_product]', $attribs = null, $key = 'value', $text = 'text', $idtag = false, $translate = false);
              ?>
            </td>
         </tr>
         <tr>
            <td class = "key">
              <?php echo SALE_HPS_CLOUDPAYMENT_NDS_DELIVERY; ?>
            </td>
            <td>
              <?php
                if (isset($params['nds_delivery'])) {
                    print JHTML::_('select.genericlist', $nds_list, $name = 'pm_params[nds_delivery]', $attribs = null, $key = 'value', $text = 'text', $params['nds_delivery'], $idtag = false, $translate = false);
                }
                else print JHTML::_('select.genericlist', $nds_list, $name = 'pm_params[nds_delivery]', $attribs = null, $key = 'value', $text = 'text', $idtag = false, $translate = false);
              ?>
            </td>
         </tr>
         <tr>
            <td class = "key">
              <?php echo SALE_HPS_CLOUDPAYMENT_TYPE_NALOG; ?>
            </td>
            <td>
              <?php
                if (isset($params['TYPE_NALOG'])) {
                    print JHTML::_('select.genericlist', $nalog_type, $name = 'pm_params[TYPE_NALOG]', $attribs = null, $key = 'value', $text = 'text', $params['TYPE_NALOG'], $idtag = false, $translate = false);
                }
                else print JHTML::_('select.genericlist', $nalog_type, $name = 'pm_params[TYPE_NALOG]', $attribs = null, $key = 'value', $text = 'text', $idtag = false, $translate = false);
              ?>
            </td>
         </tr>
         <tr>
         <td class = "key">
              <?php echo SALE_HPS_CLOUDPAYMENT_calculationPlace; ?>
            </td>
            <td>
               <input type = "text" class = "inputbox" name = "pm_params[calculationPlace]" size = "45" value = "<?php if (isset($params['calculationPlace'])) echo $params['calculationPlace'] ?>"/>
             <?php echo JHTML::tooltip(SALE_HPS_CLOUDPAYMENT_calculationPlace_DESC); ?>
            </td>
         </tr>
         <tr>
        <tr>
            <td class = "key">
              <?php echo SALE_HPS_CLOUDPAYMENT_KASSA_METHOD; ?>
            </td>
            <td>
              <?php
                if (isset($params['kassa_method'])) {
                    print JHTML::_('select.genericlist', $kassa_method_list, $name = 'pm_params[kassa_method]', $attribs = null, $key = 'value', $text = 'text', $params['kassa_method'], $idtag = false, $translate = false);
                }
                else print JHTML::_('select.genericlist', $kassa_method_list, $name = 'pm_params[kassa_method]', $attribs = null, $key = 'value', $text = 'text', $idtag = false, $translate = false);
              ?>
            </td>
         </tr>
          <tr>
            <td class = "key">
              <?php echo SALE_HPS_CLOUDPAYMENT_KASSA_OBJECT; ?>
            </td>
            <td>
              <?php
                if (isset($params['kassa_object'])) {
                print JHTML::_('select.genericlist', $kassa_object_list, $name = 'pm_params[kassa_object]', $attribs = null, $key = 'value', $text = 'text', $params['kassa_object'], $idtag = false, $translate = false);
                }
                else print JHTML::_('select.genericlist', $kassa_object_list, $name = 'pm_params[kassa_object]', $attribs = null, $key = 'value', $text = 'text', $idtag = false, $translate = false);
              ?>
            </td>
         </tr>
            <td class = "key">
              <?php echo STATUS_DELIVERED; ?>
            </td>
            <td>
              <?php
                if (isset($params['transaction_delivered_status'])) {
                    print JHTML::_('select.genericlist', $orders->getAllOrderStatus(), 'pm_params[transaction_delivered_status]', 'class = "inputbox" size = "1"', 'status_id', 'name', $params['transaction_delivered_status']);
                }
                else print JHTML::_('select.genericlist', $orders->getAllOrderStatus(), 'pm_params[transaction_delivered_status]', 'class = "inputbox" size = "1"', 'status_id', 'name');
                echo " " . JHTML::tooltip(SALE_HPS_CLOUDPAYMENT_SHOP_DELIVERED_DESC);
              ?>
            </td>
         </tr>
      </table>
   </fieldset>
</div>
<div class = "clr"></div>
<?php ini_set('display_errors','On'); ?>