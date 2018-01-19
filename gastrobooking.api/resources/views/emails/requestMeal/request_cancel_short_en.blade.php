<!DOCTYPE html>
<html>
<head>
    <meta http-equiv=Content-Type content="text/html; charset=windows-1250">
    <title>Your Gastro-Booking</title>
</head>
<body bgcolor="#FFFFFF" lang=CSlink=#000080 vlink=#800080 text="#000000">

	<p>
		REQUEST CANCELLATION <?= $order->cancellation  ?>  <?= $user->name ?><br/>
		<?= $order->persons?> persons - <?= $orders_detail_count ?> items - total <?= $orders_detail_total_price ?> <?= $currency ?> <br/>
		
		<?php foreach ($orders_detail_filtered as $orders_detail) {  
			if ($orders_detail->status == 3) { ?> <div style = "text-decoration: line-through"> <?php } ?>
			<?=  $orders_detail->x_number ?> x 
			<?php 
            if ($orders_detail['requestMenu']->confirmed_name) {
                echo $orders_detail['requestMenu']->confirmed_name;
            }
            else{ echo $orders_detail['requestMenu']->name; }  ?>
		  	<?php if ( $orders_detail->price != '0.00' && $orders_detail->price != '') { ?> <?= $orders_detail->price ?><?= $currency ?> x <?= $orders_detail->x_number ?> <?php } 
		  	if ($orders_detail->status == 3) { ?> </div> <?php } else{ echo "<br/> "; } ?>
		  	
		  	<?php
        } ?>
		
		
		gastro-booking.com
	</p>

</body></html>

