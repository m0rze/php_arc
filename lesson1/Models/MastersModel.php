<?php

class MastersModel {

	// Получение списка категорий из базы
	static public function getMastersList($masterId = "", $catId = "") {
		$getMasters = Database::getInstance()->getMasters($masterId, $catId);

		$masters = [];
		if ( ! empty( $getMasters ) ) {
			foreach ( $getMasters as $oneMaster ) {
				$masters[$oneMaster->m_id] = array( $oneMaster->m_fullname, $oneMaster->catname );
			}
		}
		return $masters;
	}

	static public function getMasterOrderTimes($masterId, $date = "") {
		$getMasters = Database::getInstance()->getMasterOrders($masterId, $date);
		return $getMasters;
	}
}