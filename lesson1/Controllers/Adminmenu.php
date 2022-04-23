<?php

class Adminmenu {

	private $ajaxUrl;

	public function __construct() {
		$this->ajaxUrl = admin_url( 'admin-ajax.php' );
	}

	// Функция создания меню в админ панели
	public function buildMenu(){
		add_action('admin_menu', function (){
			add_menu_page(
				"Мастера собак",
				"Мастера собак",
				"manage_options",
				"dogs-masters",
				"",
				"dashicons-buddicons-activity"
			);
			add_submenu_page(
				"dogs-masters",
				"Категории услуг",
				"Категории услуг",
				"manage_options",
				"dogs-masters",
				array($this, "dmCategories")
			);
			add_submenu_page(
				"dogs-masters",
				"Мастера",
				"Мастера",
				"manage_options",
				"dm-masters",
				array($this, "dmMasters")
			);
			add_submenu_page(
				"dogs-masters",
				"Заказы",
				"Заказы",
				"manage_options",
				"dm-orders",
				array($this, "dmOrders")
			);
		});
		// Добавление css и js в разделы меню
		add_action( 'admin_enqueue_scripts', array($this, "addAdminStylesScripts"));
	}

	// Контент пункта меню Категории услуг
	public function dmCategories(){
		// Получение категорий из БД
		$cats = CategoriesModel::getCatsList();
		// Рендеринг шаблона
		Templater::showMenuContent("categories.tpl.php", [
			"ajaxUrl" => $this->ajaxUrl,
			"cats" => $cats
		]);
	}

	// Контент пункта меню Мастера
	public function dmMasters(){
		// Получение категорий из БД
		$cats = CategoriesModel::getCatsList();
		// Получение имеющихся в БД мастеров
		$masters = MastersModel::getMastersList();
		// Рендеринг шаблона
		Templater::showMenuContent("masters.tpl.php", [
			"ajaxUrl" => $this->ajaxUrl,
			"cats" => $cats,
			"masters" => $masters
		]);
	}

	// Контент пункта меню Заказы
	public function dmOrders(){
		$orders = OrdersModel::getOrders();
		Templater::showMenuContent("orders.tpl.php", [
			"ajaxUrl" => $this->ajaxUrl,
			"orders" => $orders
		]);
	}


	// Добавление стилей и js для разделов админки
	public function addAdminStylesScripts($hook) {
		if(!stripos($hook, "dogs-masters") && !stripos($hook, "dm-masters") && !stripos($hook, "dm-orders")) {
			return;
		}
		wp_enqueue_style( 'dm_admin_styles', plugins_url('css/admin_styles.css', dirname(__FILE__)), [], null );

		wp_register_script( 'dm_admin_js', plugins_url('js/admin_menu.js', dirname(__FILE__)), false, null, true );
		wp_enqueue_script( 'dm_admin_js');

		wp_register_script( 'dm_jquery', "https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js", false, null, false );
		wp_enqueue_script( 'dm_jquery');
	}
}