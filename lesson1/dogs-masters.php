<?php

/*
Plugin Name: Dogs Masters
Plugin URI: https://yandex.ru/
Description: Добавляет форму заказа услуги по шорткоду.
Version: 1.0
Author: Автор
License: GPLv2 or later
Text Domain: dogs_master
*/


// Защита от прямого открытия файла в браузере
if(empty(ABSPATH)){
	die();
}

// Задаем константу, в которую записываем абсолютный путь папки плагина
define( "PLUGIN_PATH", plugin_dir_path( __FILE__ ) );


// подключаем автозагрузчик
include_once plugin_dir_path(__FILE__)."autoload.php";

// Если есть POST, то отправляем его в обработку
if(!empty($_POST)){
	include_once plugin_dir_path(__FILE__)."ajax.php";
	// Добавляем хук обарботки аякса по действиям в админке
	add_action("wp_ajax_postajax", "makeAjax");
}

// создаем хук на дейтвие активации плагина
register_activation_hook(__FILE__, "activationActions");

// Создание шорт кода формы заказа для вставки на любую страницу
add_shortcode("dm_order_form", [new Shortcode(), "showOrderForm"]);


// Работаем дальше только, если все таблицы в наличии
if(Database::getInstance()->checkAllTablesForWork()){
	$adminMenu = new Adminmenu();
	$adminMenu->buildMenu();
} else {
	Database::getInstance()->createTables();
}


// функция, которая срабатывает по хуку активации плагина
function activationActions()
{
	// создание таблиц в базе
	Database::getInstance()->createTables();
}