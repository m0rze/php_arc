<?php

class CategoriesModel {

	// Получение списка категорий из базы
	static public function getCatsList()
	{
		$getCats = Database::getInstance()->getCategories();
		$cats = [];
		if(!empty($getCats)){
			foreach ($getCats as $oneCat){
				$cats[$oneCat->cat_id] = $oneCat->cat_name;
			}
		}
		return $cats;
	}
}