<div class="new_order">
    <h2 class="form_heading">Новый заказ</h2>
    <div class="order_form">

        <div class="form_fields">
            <div class="errors"></div>
            <input id="ajax-url" type="hidden" value="<?= $ajaxUrl ?>">
            <input type="text" class="order_form_input form-control" placeholder="Ваше ФИО" required>
            <input type="text" class="order_form_input_phone form-control" placeholder="Телефон" required>
            <input type="email" class="order_form_input_email form-control" placeholder="Email">
            <select class="order_cat_select form-select">
                <option>Категория услуг</option>
                <option></option>
				<?php foreach ( $cats as $catId => $oneCat ): ?>
                    <option class="cat-selection" value="<?= $catId ?>"><?= $oneCat ?></option>
				<?php endforeach; ?>
            </select>
            <select class="master_select form-select">

            </select>

            <div class="date_selection">
                <input class="date_picker form-control" type="date">

                <select class="time_select form-select">

                </select>
            </div>
            <button class="submit_order form-control btn btn-success">Создать заказ</button>
        </div>
    </div>
</div>