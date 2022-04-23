<div class="dm-container">

	<div class="cats-list">
		<h3 class="cats-list-header">Список заказов</h3>
        <input id="ajax-url" type="hidden" value="<?=$ajaxUrl?>">
		<table class="orders_table">
			<th class="th_data">Дата создания</th>
			<th class="th_data">Время записи</th>
			<th class="th_data">ФИО заказчика</th>
			<th class="th_data">Телефон заказчика</th>
			<th class="th_data">Email заказчика</th>
			<th class="th_data">Категория услуги</th>
			<th class="th_data">ФИО мастера</th>
			<th class="th_data"></th>
			<?php foreach ($orders as $oneOrder): ?>
				<tr class="tr_data" data-tr-orderid="<?=$oneOrder->order_id?>">
                    <td class="td_data"><?=str_ireplace(" ", "<br>", date("d.m.Y H:i:s", $oneOrder->order_create))?></td>
                    <td class="td_data td_when_time"><?=date("d.m.Y", strtotime($oneOrder->date_when))?><br><?=$oneOrder->time_when?></td>
                    <td class="td_data"><?=str_ireplace(" ", "<br>", $oneOrder->c_fullname)?></td>
                    <td class="td_data"><?=$oneOrder->c_phone?></td>
                    <td class="td_data"><?=$oneOrder->c_email?></td>
                    <td class="td_data"><?=$oneOrder->category?></td>
                    <td class="td_data"><?=str_ireplace(" ", "<br>", $oneOrder->m_fullname)?></td>
                    <td class="td_data"><span data-orderid="<?=$oneOrder->order_id?>" class="dashicons dashicons-trash delete-order"></span></td>
                </tr>
			<?php endforeach; ?>
		</table>

		</ul>
	</div>
</div>