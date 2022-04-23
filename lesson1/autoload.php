<?php

// объявляем глобальную переменную объекта класса wpdb для работы с базой данных
global $wpdb;

// автозагрузчик классов
spl_autoload_register(function ($className){
	$dirs = [
		"Core",
		"Controllers",
		"Models",
		"Views"
	];
	foreach ($dirs as $oneDir){
		if(file_exists(PLUGIN_PATH.$oneDir.DIRECTORY_SEPARATOR.$className.".php")){
			include PLUGIN_PATH.$oneDir.DIRECTORY_SEPARATOR.$className.".php";
		}
	}
});

// создаем синглтон класса Database и передаем ему ссылку на объект $wpdb
Database::getInstance()->setDbConn($wpdb);
Database::getInstance()->setDbName(DB_NAME);