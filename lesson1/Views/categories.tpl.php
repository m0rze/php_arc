<div class="dm-container">
    <div class="add-new-cat">
        <h3 class="add-cat-header">Добавление новой категории услуг</h3>
        <div class="add-cat-form">
            <input id="ajax-url" type="hidden" value="<?=$ajaxUrl?>">
            <input type="text" class="cat-name-input" placeholder="Название категории">
            <button class="add-cat-button">Добавить</button>
        </div>
        <div class="add-result"></div>
    </div>

    <div class="cats-list">
        <h3 class="cats-list-header">Список категорий</h3>
        <ul class="cats-list-ul">
            <?php foreach ($cats as $catId => $oneCat): ?>
                <li class="cat-list-item" data-li-catid="<?=$catId?>">
                    <span data-catid="<?=$catId?>" class="dashicons dashicons-trash delete-cat"></span>
                    <span class="span-cat-name"><?=$oneCat?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>