<?php

class Shortcode {

	private $ajaxUrl;

	public function __construct() {
		$this->ajaxUrl = admin_url( 'admin-ajax.php' );
		add_action( 'wp_enqueue_scripts', array($this, "addOrderFormStylesScripts"));
	}

	// Показ содержимого шорткода
	public function showOrderForm() {
		if( !is_user_logged_in() ){
			return "";
		}

		$cats = CategoriesModel::getCatsList();
		return Templater::showMenuContent("order_form.tpl.php", [
			"ajaxUrl" => $this->ajaxUrl,
			"cats" => $cats,


		], "yes");
	}

	public function addOrderFormStylesScripts() {

		wp_enqueue_style( 'dm_form_styles', plugins_url('css/form_styles.css', dirname(__FILE__)), [], null );
		wp_enqueue_style( 'dm_bootstrap',esc_url_raw('https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css'));

		wp_register_script( 'dm_form_js', plugins_url('js/order_form.js', dirname(__FILE__)), false, null, true );
		wp_enqueue_script( 'dm_form_js');

		wp_register_script( 'dm_jquery', "https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js", false, null, false );
		wp_enqueue_script( 'dm_jquery');
	}
}