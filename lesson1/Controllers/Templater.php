<?php

class Templater {

	// Шаблонизатор для вывода контента
	static function showMenuContent($template, $vars = [], $return = ""){
		if(!empty($vars)) {
			foreach ( $vars as $varName => $oneVar ) {
				$$varName = $oneVar;
			}
		}
		ob_start();
		include PLUGIN_PATH."Views/".$template;
		if(empty($return)) {
			echo ob_get_clean();
		} else {
			return ob_get_clean();
		}
	}
}