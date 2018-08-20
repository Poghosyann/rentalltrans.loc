<?php
/** @var Order $order */

use app\models\Order;
use common\models\Marka;
?>

<div style="width: 900px; margin:30px auto">
	<img style="opacity: .4;" src="https://www.rentalltrans.com/images/logo-light.png" alt="logo" width="200px">
	<p>Уважаемый <?= $order->itemUser->first_name ?>,<br>
		Благодарим Вас за выбор сайта rentalltrans.com, Спасибо что подтвердили бронирования, Ваш клиент будет ждать в Место и время указанны в блоки детали бронирования ТС, где Вы точно договорились с ним (ней) до подтверждение бронирование на сайте rentalltrans.com, в разделе (chat.<br>
		Для того, чтобы получить ТС , Клиенту надо предъявить следующие документы:<br>
		Паспорт, водительские права со стажем 3 (трех) лет, ваучер (печатанный A4) подтверждающий бронирование, Кредитная карта, оформленная на имя арендатора и с лимитом AMD 600000 или эквивалент в другой валюте (если клиент не приобрел Casco insurance).<br>
		<strong>Обратите внимание: </strong>Клиент должен распечатать свой ваучер и предъявить его Вам и агенту  сайта rentalltrans.com Мы не можем принять на себя ответственность за возможные дополнительные расходы, если при оформлении документов на аренду не предъявлен ваучер. Пожалуйста, обратите внимание: мы не несем ответственности в тех случаях, когда клиент вынужден переплатить за аренду из-за того, что при получении автомобиля он не сумел предъявить свой ваучер.
	</p>
	<h2 style="text-align: center">Детали бронирования ТС</h2>
	<div style="border: 1px solid; padding: 15px;">
		<p>Номер бронирования: № <?= $order->id ?></p><hr>
        <p>Статус бронирования: <?= $order->item->status ?> </p><hr>
        <p>Имя и адрес арендатора: <?= $order->user->first_name ?> <?= $order->user->last_name ?>, <?= $order->user->address_line_1 ?> <?= $order->user->address_line_2 ?></p><hr>

        <p>Тип транспорта: <?= $order->item->category->title ?> </p><hr>

        <div style="display: inline-block"><p>Информация о ТС: </p></div>
        <div style="display: inline-block; margin-left: 25px; text-align: center"><p>Model <br> <?= $order->getMark($order->item->model->mark_id) ?> - <?= $order->item->model->model ?></p></div>
        <div style="display: inline-block; margin-left: 25px; text-align: center"><p>Type of body <br> <?= $order->item->typeBody->title ?> </p></div>
        <div style="display: inline-block; margin-left: 25px; text-align: center"><p>Class <br> <?= $order->item->class->title ?> </p></div>
        <div style="display: inline-block; margin-left: 25px; text-align: center"><p>Doors <br> <?= $order->item->quantity_doors ?> </p></div>
        <div style="display: inline-block; margin-left: 25px; text-align: center"><p>Transmission <br> <?= $order->item->transmissionVehicles->title ?> </p></div>
        <div style="display: inline-block; margin-left: 25px; text-align: center"><p>Steering wheel <br> <?= $order->item->steering_wheel ?> </p></div><hr>

        <p>Место и время получение транспорта: Ереван / офис Рент Транс;  10:00  <?= $order->from ?></p><hr>

        <p>Место и время возврата транспорта: Ереван / офис Рент Транс; 10:00  <?= $order->to ?></p><hr>

        <p>Поставщик транспорта: <?= $order->itemUser->first_name ?></p><hr>

		<?php
		$datetime1 = new DateTime($order->from);
		$datetime2 = new DateTime($order->to);
		$days = $datetime1->diff($datetime2)->d;

		if($days > 4){
			$casco =  ($order->item->car_price * 0.05)/100;
		}else{
			$casco =  ($order->item->car_price * 0.08)/100;
		}

		foreach ($results_product_item as $result_product){
			if($result_product['id'] == 10){
				$price = $casco * $days;
			}
			else{
				$price = $result_product['price'] * $days;
			}
			echo '<p> '.$result_product['name'].' <span style="float: right">включая налоги AMD '.$price.'</span></p><hr>';
		}

		$order_service_price = ($order->service_price * $days);
		$order_rental_price = $order->rental_price;
		$order_total_price = ($order_service_price + $order_rental_price);
		?>

        <p>Платеж:                                 <span style="float: right">включая налоги AMD <?= $order_total_price ?></span></p><hr>
        <p>Сумма депозита:                         <span style="float: right">включая налоги AMD <?php echo ($casco_insurance_price) ? $order->item->deposit : 600000 ?></span></p>
	</div>
	<div>
		<p>С Уважениям,</p>
		<p>Ответственный за бронирования: Артур Алексанян</p>
		<p>ООО «Рент Транс»</p>
		<p>Тел: +374 91 228840</p>
		<p>E-mail: <a href="info@rentalltrans.com">info@rentalltrans.com</a></p>
	</div>
</div>