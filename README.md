# CloudPayments module for Joomla -JoomShopping

Модуль позволит добавить на ваш сайт оплату банковскими картами через платежный сервис [CloudPayments](https://cloudpayments.ru/Docs/Connect). 
Для корректной работы модуля необходима регистрация в сервисе.
Порядок регистрации описан в [документации CloudPayments](https://cloudpayments.ru/Docs/Connect).

## Возможности

* Одностостадийная система;
* Двухстостадийная система;
* Выбор языка виджета;
* Выбор дизайна виджета;
* Выбор локализации виджета оплаты;
* Информирование СMS о статусе платежа;
* Поддержка онлайн-касс (ФЗ-54);
* Отправка чеков по email;
* Отправка чеков по SMS;
* Теги способа и предмета расчета;  

## Совместимость:
JoomShopping v.4.15.0 и выше;  
Joomla v.3.8.2 и выше.

### Установка через панель управления

1. Зайдите в инсталлятор расширений "Расширения" -> "Менеджер расширений" -> "Установка" -> `/administrator/index.php?option=com_installer`  
и загрузить архив. Повторите установку, для выполнения скрипта установки.

2. Активируйте расширение "PLG_jshoppingadmin_cloudpayments_cp" в  меню "Расширения" -> "Менеджер расширений" -> "Управление" -> `/administrator/index.php?option=com_installer&view=manage`.

3. Далее в настройках модуля "Компоненты" -> "JoomShopping" -> "Опции" -> "Способо оплаты":\
`/administrator/index.php?option=com_jshopping&controller=payments`  
добавьте новый способ оплаты:
 
 **Обязательные пункты:**
* Название - **Cloudpayments**;
* Псевдоним и Имя скрипта - **pm_cloudpayments_cp**; 
* Тип оплаты - **Расширенный**.   
 
![Cloudpayments](pics/CP1.png)

### Настройка модуля Cloudpayments

Далее перейдите в созданную платежную систему и измените настройки.

Вкладка "Конфигурация":

* **Public_id** - Public id сайта из личного кабинета CloudPayments;  
* **Пароль для API** - API Secret из личного кабинета CloudPayments;  
* **Тип схемы проведения платежей** - Выбор схемы оплата платежа;   
* **Статус оплаченного заказа** - Paid;  
* **Статус авторизованного платежа** - Confirmed;  
* **Статус возврата платежа** - Refunded;  
* **Язык виджета** - Выбор языка виджета;  
* **Дизайн виджета** - Выбор дизайна виджета из 3 возожных (classic, modern, mini); 
* **Валюта заказа** - Выбор валюты заказа;
* **Использовать функцуионал онлайн касс** - Включение/отключение формирования онлайн-чека при оплате.
* **ИНН организации** - ИНН вашей организации или ИП, на который зарегистрирована касса;
* **НДС для заказа** - Укажите ставку НДС товаров;
* **Выберите НДС на доставку** - Укажите ставку НДС службы доставки;
* **Система налогооблажения** - Тип системы налогообложения;
* **Место осуществления расчёта** - Адреса сайта точки продаж для печати в чеке; 
* **Способ расчета** - Выбор признака способа расчета;  
* **Предмет расчета** - Выбор признака предмета расчета;  
* **Статус доставки** - Complete. 
_Согласно ФЗ-54 владельцы онлайн-касс должны формировать чеки для зачета и предоплаты. Отправка второго чека возможна только при следующих способах расчета: Предоплата, Предоплата 100%, Аванс._


![CloudPayments settings](pics/CP_settings.png)

В личном кабинете CloudPayments в настройках сайта необходимо включить следующие уведомления:

* **Check уведомление**: \
`http://domain.ru/index.php?option=com_jshopping&controller=checkout&task=step7&act=check_&js_paymentclass=pm_cloudpayments_cp&no_lang=1`
* **Pay уведомление**: \
`http://domain.ru/index.php?option=com_jshopping&controller=checkout&task=step7&act=pay_&js_paymentclass=pm_cloudpayments_cp&no_lang=1`
* **Refund уведомление**: \
`http://domain.ru/index.php?option=com_jshopping&controller=checkout&task=step7&act=refund_&js_paymentclass=pm_cloudpayments_cp&no_lang=1`
* **Confirm уведомление**: \
`http://domain.ru/index.php?option=com_jshopping&controller=checkout&task=step7&act=confirm_&js_paymentclass=pm_cloudpayments_cp&no_lang=1`
* **Cancel уведомление**: \
`http://domain.ru/index.php?option=com_jshopping&controller=checkout&task=step7&act=cancel_&js_paymentclass=pm_cloudpayments_cp&no_lang=1`

Где domain.ru — доменное имя вашего сайта. Кодировка — UTF-8, HTTP-метод — POST, формат — CloudPayments.

### Интеграция с онлайн-кассой

Сервис [CloudKassir](https://cloudkassir.ru) предоставляет в аренду онлайн-кассы для Вашего интернет-магазина на платформе [JoomShopping](https://github.com/EvgeniyTr/CMS-JoomShopping-CK) в соответствии требованиям ФЗ-54.  
Для корректной работы модуля необходима регистрация в сервисе.
Порядок регистрации описан в [документации CloudKassir](https://cloudkassir.ru/#subscribe).

### Changelog

= 1.1.3 =
* Обновлена локализация виджета и поддерживаемые валюты
* Добавлены дополнительные параметры фискализации - [подробнее](https://static.cloudpayments.ru/docs/uz/CP_JoomShopping_UZ.pdf)

= 1.1.2 =
* Добавлены дополнительные параметры фискализации

= 1.1.1 =
* Устранены некоторые ошибки;
* Добавлена двухстадиная схема оплаты;
* Добавлен функционал 2го чека.

= 1.0.1 =
* Устранение ошибок.

= 1.0 =
* Публикация плагина.

