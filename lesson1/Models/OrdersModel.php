<?php

class OrdersModel {

	static public $times = [
		"08:00",
		"09:00",
		"10:00",
		"11:00",
		"12:00",
		"13:00",
		"14:00",
		"15:00",
		"16:00",
		"17:00"
	];

	// Сохранение нового заказа
	static public function saveNewOrder($customerId, $catId, $masterId, $dateWhen, $timeWhen){
		return Database::getInstance()->insertToDb("dm_orders", [
			"customer_id" => $customerId,
			"cat_id" => $catId,
			"master_id" => $masterId,
			"date_when" => $dateWhen,
			"time_when" => $timeWhen,
			"order_create" => time()
		]);
	}

	static public function getOrders(){
		return Database::getInstance()->getOrderData();
	}
}