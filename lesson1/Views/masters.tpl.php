<div class="dm-container">
	<div class="add-new-cat">
		<h3 class="add-cat-header">Добавление нового мастера</h3>
		<div class="add-cat-form">
			<input id="ajax-url" type="hidden" value="<?=$ajaxUrl?>">
			<input type="text" class="cat-name-input master-name-input" placeholder="ФИО мастера">
            <select class="master-select">
                <option>Категория услуг</option>
                <option></option>
	            <?php foreach ($cats as $catId => $oneCat): ?>
                    <option class="cat-selection" value="<?=$catId?>"><?=$oneCat?></option>
                <?php endforeach; ?>
            </select>
			<button class="add-master-button">Добавить</button>
		</div>
		<div class="add-result"></div>
	</div>

	<div class="cats-list">
		<h3 class="cats-list-header">Список мастеров</h3>
		<ul class="cats-list-ul">
			<?php foreach ($masters as $masterId => $oneMaster): ?>
				<li class="cat-list-item" data-li-masterid="<?=$masterId?>">
                    <span data-masterid="<?=$masterId?>" class="dashicons dashicons-trash delete-cat delete-master"></span>
                    <span class="span-master-name"><?=$oneMaster[0]?></span>
                    <span class="span-cat-name-masters">(<?=$oneMaster[1]?>)</span>
                </li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>