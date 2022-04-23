<option>Выберите мастера</option>
<option></option>
<?php foreach ( $masters as $masterId => $masterData ): ?>
    <option class="master_option" value="<?= $masterId ?>"><?= $masterData[0] ?></option>
<?php endforeach; ?>