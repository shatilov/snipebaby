<?php
/**
 * @package			"VirtueMart Importer Addon for JoomShopping"
 * @version			1.5 [2011-09-06]
 * @compatibility	PHP 5.2/5.3, Joomla 1.5, JoomShopping 2.9.6, VirtueMart 1.1.9
 * @author			Vova Olar vovaolar@gmail.com
 * @copyright		Copyright (C) 2010-2011 Vova Olar - All rights reserved.
 * @license			GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */

defined('_JEXEC') or die('Direct access is not allowed.');

define('_JSHOP_IE_VMIMPORT_SEARCHING_FOR_JSHOP', 'Поиск JoomShopping');
define('_JSHOP_IE_VMIMPORT_SEARCHING_FOR_VMART', 'Поиск VirtueMart');
define('_JSHOP_IE_VMIMPORT_JSHOP', 'JoomShopping');
define('_JSHOP_IE_VMIMPORT_VMART', 'VirtueMart');
define('_JSHOP_IE_VMIMPORT_SETTINGS', 'Настройки');
define('_JSHOP_IE_VMIMPORT_NOTINSTALLED_WARNING', 'JoomShopping и VirtueMart должны быть установлены!');
define('_JSHOP_IE_VMIMPORT_DELETEJSDATA_WARNING', 'Задействованные JoomShopping-таблицы базы данныx будут очищены перед импортом, файлы (картинки, видео...) - удалены! Отключите соответствующую опцию если Вы не хотите этого.');
define('_JSHOP_IE_VMIMPORT_CURRENCIES_NOTICE', 'Если Вы используете в VirtueMart разные валюты, то для правильного преобразования цен при импорте необходимо сначала создать и настроить валюты в JoomShopping (с соответствующими кодами).');
define('_JSHOP_IE_VMIMPORT_YES', 'Да');
define('_JSHOP_IE_VMIMPORT_NO', 'Нет');

define('_JSHOP_IE_VMIMPORT_DELETEJSDATA', 'Удалить данные JoomShopping перед импортом?');
define('_JSHOP_IE_VMIMPORT_MAKESUBPRODUCTSRELATIVE', 'Делать подпродукты VirtueMart связанными?');
define('_JSHOP_IE_VMIMPORT_MAKESUBPRODUCTSRELATIVE_NOTICE', 'JoomShopping не поддерживает подпродукты (но поддерживает связи между продуктами). Включите эту опцию чтобы сделать подпродукты связанными с главным продуктом.');
define('_JSHOP_IE_VMIMPORT_ADDATTRSTOSUBPRODUCTTITLE', 'Добавлять аттрибуты подпродуктов VirtueMart в название товара JoomShopping?');
define('_JSHOP_IE_VMIMPORT_ADDATTRSTOSUBPRODUCTTITLE_NOTICE', 'JoomShopping не поддерживает аттрибуты подпродуктов. Включите эту опцию чтобы добавить аттрибуты в название товара JoomShopping.');
define('_JSHOP_IE_VMIMPORT_MAKEFREEATTRIBUTESREQUIRED', 'Сделать свободные аттрибуты обязательными для заполнения?');
define('_JSHOP_IE_VMIMPORT_MAKEFREEATTRIBUTESREQUIRED_NOTICE', 'Выберите \'Да\' чтобы сделать все импортируемые свободные аттрибуты обязательными для заполнения клиентом, или \'Нет\' в противном случае. В VirtueMart свободные аттрибуты задаются для каждого продукта и поэтому они являются обязательными для заполнения (если в этом продукте они Вам не нужны - Вы просто не задаёте их в продукте). В JoomShopping Вы можете в продукте только выбрать использовать аттрибут или нет, аттрибуты общие для всех продуктов, поэтому каждый из них может быть обязательным для заполнения или нет.');
define('_JSHOP_IE_VMIMPORT_ATTRSTYLE', 'Стиль обьявления расширеных аттрибутов');
define('_JSHOP_IE_VMIMPORT_ATTRSTYLE_NOTICE', 'JoomShopping поддерживает 2 стиля обьявления аттрибутов: такой же как в VirtueMart и стиль с зависимыми аттрибутами.');
define('_JSHOP_IE_VMIMPORT_CHARACTERISTICPREFIX', 'Добавлять к названию импортируемых параметров тип продукта?');
define('_JSHOP_IE_VMIMPORT_CHARACTERISTICPREFIX_NOTICE', 'JoomShopping не поддерживает групировку параметров в типы, так что Вы можете предварять имена импортируемых параметров префиксом с типом продукта');
define('_JSHOP_IE_VMIMPORT_IMAGEFULL', 'Полноразмерную');
define('_JSHOP_IE_VMIMPORT_IMAGETHUMB', 'Превью');
define('_JSHOP_IE_VMIMPORT_CATIMAGE', 'Какую картинку категории VirtueMart импортировать?');
define('_JSHOP_IE_VMIMPORT_STORELOGO', 'Какое лого магазина импортировать?');
define('_JSHOP_IE_VMIMPORT_VENDORLOGO', 'Какое лого продавца импортировать?');
define('_JSHOP_IE_VMIMPORT_RESIZEIMAGES', 'Изменять размер импортируемых картинок в соответствии с конфирурацией JoomShopping?');
define('_JSHOP_IE_VMIMPORT_AUTOFILLMETA', 'Автоматически заполнять META теги?');
define('_JSHOP_IE_VMIMPORT_GENERATEALIASES', 'Генерировать alias из названия?');

define('_JSHOP_IE_VMIMPORT_STARTED', 'Начинаю импорт');
define('_JSHOP_IE_VMIMPORT_DELETINGJSDATA', 'Удаляю данные JoomShopping');
define('_JSHOP_IE_VMIMPORT_IMPORTING', 'Импортирую');
define('_JSHOP_IE_VMIMPORT_SUCCEEDED', 'OK');
define('_JSHOP_IE_VMIMPORT_FAILED', 'НЕУДАЧНО');

define('_JSHOP_IE_VMIMPORT_ATTRIBUTES', 'Расширенные аттрибуты');
define('_JSHOP_IE_VMIMPORT_CATEGORIES', 'Категории');
define('_JSHOP_IE_VMIMPORT_CHARACTERISTICS', 'Types parameters');
define('_JSHOP_IE_VMIMPORT_COUPONS', 'Купоны');
define('_JSHOP_IE_VMIMPORT_FREEATTRIBUTES', 'Пользовательские аттрибуты');
define('_JSHOP_IE_VMIMPORT_MANUFACTURERS', 'Производителей');
define('_JSHOP_IE_VMIMPORT_PRODUCTS', 'Товары');
define('_JSHOP_IE_VMIMPORT_PRODUCTSFILES', 'Файлы товаров');
define('_JSHOP_IE_VMIMPORT_PRODUCTSSHIPMENTPRICES', 'Цены за партии для товаров');
define('_JSHOP_IE_VMIMPORT_PRODUCTSRELATIONS', 'Связи между товарами');
define('_JSHOP_IE_VMIMPORT_PRODUCTSREVIEWS', 'Оценки товаров');
define('_JSHOP_IE_VMIMPORT_PRODUCTSTOCATEGORIES', 'Принадлежность товаров категориям');
define('_JSHOP_IE_VMIMPORT_SHIPPINGMETHODS', 'Способы доставки');
define('_JSHOP_IE_VMIMPORT_STOREINFO', 'Инфо о магазине');
define('_JSHOP_IE_VMIMPORT_TAXES', 'Налоги');
define('_JSHOP_IE_VMIMPORT_VENDORS', 'Продавцов');
define('_JSHOP_IE_VMIMPORT_USERGROUPS', 'Группы покупателей');
define('_JSHOP_IE_VMIMPORT_USERSEXTENDEDDATA', 'Расширенные данные покупателей');

define('_JSHOP_IE_VMIMPORT_FINISHED', 'Импорт завершен');
define('_JSHOP_IE_VMIMPORT_BACKTOIMPORT', 'Вернуться к странице VirtueMart Import for JoomShopping');
?>