<?php

function makeAjax() {

	// Обработка Ajax по добавлению новой категории услуг
	if ( ! empty( $_POST["addnewcat"] ) && ! empty( $_POST["catname"] ) ) {
		$insert = Database::getInstance()->insertToDb( "dm_categories", [
			"cat_name" => $_POST["catname"]
		] );
		if ( $insert !== false ) {
			echo '{"result": true}';
		} else {
			echo '{"result": false}';
		}
		die();
	}

	// Обработка Ajax по удалению категории услуг
	if ( ! empty( $_POST["deletecat"] ) && ! empty( $_POST["catid"] ) ) {
		$delete = Database::getInstance()->deleteFromDb( "dm_categories", [
			"cat_id" => $_POST["catid"]
		] );
		if ( $delete !== false ) {
			echo '{"result": true}';
		} else {
			echo '{"result": false}';
		}
		die();
	}

	// Обработка Ajax по добавлению нового мастера
	if ( ! empty( $_POST["addnewmaster"] ) && ! empty( $_POST["mastername"]) && ! empty( $_POST["catid"] )) {
		$insert = Database::getInstance()->insertToDb( "dm_masters", [
			"fullname" => $_POST["mastername"],
			"cat_id" => $_POST["catid"]
		] );
		if ( $insert !== false ) {
			echo '{"result": true}';
		} else {
			echo '{"result": false}';
		}
		die();
	}

	// Обработка Ajax по удалению мастера
	if ( ! empty( $_POST["deletemaster"] ) && ! empty( $_POST["masterid"] ) ) {
		$delete = Database::getInstance()->deleteFromDb( "dm_masters", [
			"master_id" => $_POST["masterid"]
		] );
		if ( $delete !== false ) {
			echo '{"result": true}';
		} else {
			echo '{"result": false}';
		}
		die();
	}

	// Обработка Ajax по получению select мастеров выбранной категории
	if ( ! empty( $_POST["getmasters"] ) && ! empty( $_POST["catid"] ) ) {
		$masters = MastersModel::getMastersList("", $_POST["catid"]);

		if ( empty($masters) ) {
			echo '{"result": false}';
		} else {
			$mastersSelect = Templater::showMenuContent("masters_select.tpl.php", [
				"masters" => $masters,
			], "yes");
			$result = [
				"result" => true,
				"masters_select" => $mastersSelect
			];
			echo json_encode($result);
		}
		die();
	}

	// Обработка Ajax по получению select доступного времени мастера
	if ( ! empty( $_POST["getmastertime"] ) && ! empty( $_POST["masterid"] ) && ! empty( $_POST["date"] ) ) {
		$masterOrders = MastersModel::getMasterOrderTimes($_POST["masterid"], $_POST["date"]);
		if(empty($masterOrders)){
			$times = OrdersModel::$times;
		} else {
			$times = OrdersModel::$times;
			foreach ($masterOrders as $oneMasterOrder){
				$times = array_flip($times);
				unset($times[$oneMasterOrder->time_when]);
				$times = array_flip($times);
			}
		}
		$mastersSelect = Templater::showMenuContent("master_time_select.tpl.php", [
			"times" => $times,
		], "yes");

		$result = [
			"result" => true,
			"time" => $mastersSelect
		];

		echo json_encode($result);
		die();
	}

	// Сохранение заказа
	if ( ! empty( $_POST["sendorder"] )) {
		$result = [
			"error" => ""
		];
		$catId = intval($_POST["catid"]);
		$masterId = intval($_POST["masterid"]);
		$fullname = esc_sql($_POST["fullname"]);
		$phone = esc_sql($_POST["phone"]);
		$email = esc_sql($_POST["email"]);
		$userId = wp_get_current_user();
		$userId = $userId->ID;
		$date_when = esc_sql($_POST["date_when"]);
		$time_when = esc_sql($_POST["time_when"]);
		if(strlen($date_when) > 10 || strlen($time_when) > 5){
			$result = [
				"error" => 1
			];
			echo json_encode($result);
			die();
		}

		CustomerModel::saveCustomer($userId, $fullname, $phone, $email);
		if(!OrdersModel::saveNewOrder($userId, $catId, $masterId, $date_when, $time_when)){
			$result = [
				"error" => 2
			];
			echo json_encode($result);
			die();
		}
		$result["result"] = Templater::showMenuContent("success_order.tpl.php", [], "yes");

		echo json_encode($result);
		die();
	}

	// Обработка Ajax по удалению заказа
	if ( ! empty( $_POST["deleteorder"] ) && ! empty( $_POST["orderid"] ) ) {
		$delete = Database::getInstance()->deleteFromDb( "dm_orders", [
			"order_id" => $_POST["orderid"]
		] );
		if ( $delete !== false ) {
			echo '{"result": true}';
		} else {
			echo '{"result": false}';
		}
		die();
	}
}