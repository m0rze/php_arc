<?php

class Database {

	// инстанс синглтона
	private static $instance;
	// ссылка на объект wpdb
	private wpdb $dbConn;
	private $dbName;

	// массив с именами таблиц, которые используются плагином
	private $tables = [
		"dm_categories",
		"dm_masters",
		"dm_customers",
		"dm_orders"
	];

	private function __construct() {
	}

	// статическая функция получения инстанса синглтона
	static function getInstance() {
		if ( self::$instance == null ) {
			self::$instance = new Database();
		}

		return self::$instance;
	}

	// функция создания таблиц, необходимых для работы плагина
	public function createTables() {
		foreach ( $this->tables as $oneTable ) {
			if ( ! $this->checkTablesExists( $oneTable ) ) {
				switch ( $oneTable ) {
					case "dm_categories":
						$this->dbConn->query( "
						create table dm_categories
						(
    						cat_id   int auto_increment,
    						cat_name varchar(255) not null,
    						constraint dm_categories_pk
        					primary key (cat_id)
						);
						" );
						break;
					case "dm_masters":
						$this->dbConn->query( "
						create table dm_masters
						(
    						master_id int auto_increment,
    						fullname  text not null,
    						cat_id    int  not null,
    						constraint dm_masters_pk
        					primary key (master_id),
    						constraint dm_masters_cat_id_fk
        					foreign key (cat_id) references dm_categories (cat_id)
            				on delete cascade
						);
						" );
						break;
					case "dm_customers":
						$this->dbConn->query( "
						create table dm_customers
						(
    						customer_id int,
    						fullname    text         not null,
    						phone  text not null,
    						email  text not null,
    						constraint dm_customers_pk
        					primary key (customer_id)
						);
						" );
						$this->dbConn->query( "
						create unique index dm_customers_customer_id_uindex
    					on dm_customers (customer_id);
						" );
						break;
					case "dm_orders":
						$this->dbConn->query( "
						create table dm_orders
						(
    						order_id    int auto_increment,
    						customer_id int      not null,
    						cat_id      int      not null,
    						master_id   int      not null,
    						date_when  varchar(128)      not null,
    						time_when  varchar(128)      not null,
    						order_create  int not null,
    						constraint dm_orders_pk
        					primary key (order_id),
    						constraint dm_orders_cat_id_fk
        					foreign key (cat_id) references dm_categories (cat_id)
            				on delete cascade,
    						constraint dm_orders_customer_id_fk
        					foreign key (customer_id) references dm_customers (customer_id)
            				on delete cascade,
    						constraint dm_orders_master_id_fk
        					foreign key (master_id) references dm_masters (master_id)
            				on delete cascade
						);
						" );
						break;
					default:
						break;
				}
			}
		}
	}

	// Проверка всех таблиц на наличие в базе
	public function checkAllTablesForWork(){
		foreach ( $this->tables as $oneTable ) {
			if ( !$this->checkTablesExists( $oneTable ) ) {
				return false;
			}
		}
		return true;
	}

	// проверка существования таблицы в базе
	private function checkTablesExists( $tableName ) {
		if ( $this->dbConn->query( "SELECT 1 FROM " . $tableName . " LIMIT 1" ) !== false) {
			return true;
		}

		return false;
	}

	// сеттер для поля класса $dbConn
	public function setDbConn( $wpdb ) {
		$this->dbConn = $wpdb;
	}

	// сеттер для поля класса $dbName
	public function setDbName( $dbName ) {
		$this->dbName = $dbName;
	}

	// получение объекта с данными по заказам / заказу (по id заказчика)
	public function getOrderData( $customerId = "" ) {
		$where = "";
		if ( ! empty( $customerId ) ) {
			$where = " WHERE dm_customers.customer_id='" . intval( $customerId ) . "'";
		}

		return $this->dbConn->get_results( "
			select 
			       dm_orders.order_id as order_id,
			       dm_orders.date_when as date_when,
			       dm_orders.time_when as time_when,
			       dm_orders.order_create as order_create, 
			       dm_customers.fullname as c_fullname, 
			       dm_customers.customer_id as customer_id, 
			       dm_customers.phone as c_phone,
			       dm_customers.email as c_email,
			       dm_categories.cat_name as category, 
			       dm_masters.fullname as m_fullname 
			from ".$this->dbName.".dm_orders
    			inner join ".$this->dbName.".dm_customers using (customer_id)
    			inner join ".$this->dbName.".dm_categories using (cat_id)
    			inner join ".$this->dbName.".dm_masters using (master_id)" . $where );
	}


	// Получение мастера из БД
	public function getMasters( $masterId = "", $catId = "" ) {
		$where = "";
		if ( ! empty( $masterId ) ) {
			$where = " WHERE dm_masters.master_id='" . intval( $masterId ) . "'";
		}

		if ( ! empty( $catId ) ) {
			$where = " WHERE dm_masters.cat_id='" . intval( $catId ) . "'";
		}

		return $this->dbConn->get_results( "
			select 
			       dm_masters.master_id as m_id,
			       dm_masters.fullname as m_fullname,
			       dm_categories.cat_name as catname
			from ".$this->dbName.".dm_masters
    			inner join ".$this->dbName.".dm_categories using (cat_id)" . $where );
	}

	// Получение всех категорий
	public function getCategories( ) {

		return $this->dbConn->get_results( "select * from ".$this->dbName.".dm_categories");
	}


	// Вставка строки в БД
	public function insertToDb($tableName, $data){
		return $this->dbConn->insert($tableName, $data);
	}

	// Удаление строки из БД
	public function deleteFromDb($tableName, $conds){
		return $this->dbConn->delete($tableName, $conds);
	}

	// Получение списка заказов мастера из БД
	public function getMasterOrders( $masterId = "", $date = "") {
		$where = "";
		if ( ! empty( $masterId ) ) {
			$where = " WHERE dm_orders.master_id='" . intval( $masterId ) . "'";
		}
		if ( ! empty( $date ) ) {
			$where .= " AND dm_orders.date_when='" . esc_sql($date) . "'";
		}
		return $this->dbConn->get_results( "
			select
			       dm_orders.time_when
			from ".$this->dbName.".dm_orders" . $where );
	}

	// Получение заказчика из БД
	public function insertCustomer($customerId, $fullname = "", $phone = "", $email = "") {
		return $this->dbConn->query( "
		INSERT INTO ".$this->dbName.".dm_customers (customer_id, fullname, phone, email) VALUES(".$customerId.", '".$fullname."', '".$phone."', '".$email."') 
    ON DUPLICATE KEY UPDATE fullname = '".$fullname."', phone = '".$phone."',email = '".$email."';
		");
	}
}