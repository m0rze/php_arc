<?php

class CustomerModel {

	// Запись заказчика в базу
	static public function saveCustomer($customerId = "", $fullname = "", $phone = "", $email = "") {
		$getMasters = Database::getInstance()->insertCustomer($customerId, $fullname, $phone, $email);

		return $getMasters;
	}
}