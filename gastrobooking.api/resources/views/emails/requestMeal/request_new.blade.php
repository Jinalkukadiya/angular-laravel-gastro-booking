<!DOCTYPE html>
<html>
<head>
    <meta http-equiv=Content-Type content="text/html; charset=windows-1250">
    <title>Your Gastro-Booking</title>
</head>
<body bgcolor="#FFFFFF" lang=CSlink=#000080 vlink=#800080 text="#000000">
<div>
<!-- {{$order->serve_at}} -->
    <TABLE width=900 BORDER=3 CELLPADDING=4 CELLSPACING=0>
        <COL width= 150px>
        <TR><TD>
                <IMG SRC="http://www.gastro-booking.com/assets/images/logomini.png">
            </TD><TD>
                @lang('main.MAIL.REQUEST_FOR')
                <?php echo (isset($order->request_order_detail[0]) && isset($order->request_order_detail[0]->serve_at)) ? date("d.m.Y h:m", strtotime($order->request_order_detail[0]->serve_at)) : ''  ?>
                &nbsp;&nbsp;&nbsp;NUMBER: <?php echo $order->ID; ?>
                <BR>
                <?php if($restaurant){ ?>
	                <?php echo $restaurant->name; ?>, 
	                <?php echo $restaurant->street; ?>, 
	                <?php echo $restaurant->city; ?>, 
	                <?php echo $restaurant->www; ?>, 
	                tel.: <?php echo $restaurant->phone; ?>, 
	                mob.: <?php echo $restaurant->SMS_phone; ?>
	            <?php } else { ?>
	            	<?php echo $new_restaurant['name']; ?>, 
	                <?php echo $new_restaurant['address']; ?>, 
	            <?php } ?>
                <BR>
            </TD></TR>
        <TR><TD>
                Customer
            </TD><TD>
                <?= $user->name ?> (booking from <?= $order->created_at->format('d.m.Y H:i') ?>)
                <?php echo ($order->delivery_address && $order->delivery_phone) ? ", tel.: ". $order->delivery_phone :
                           ($user->client->phone ? ", tel.: ". $user->client->phone : "" ); ?>
            </TD></TR>
        <TR><TD>
                Numbers and price
            </TD><TD>
                <?= $order->persons?> persons - <?= $orders_detail_count ?> items - total 
                <?php
                if ($orders_detail_total_price && $orders_detail_total_price != '0.00' && $orders_detail_total_price > 0) {
                   echo $orders_detail_total_price .''.$currency;
                }
                ?>
            </TD></TR>
        <?php $order_comment = trim (str_replace('<br>','',$order->comment)); if ( !empty($order_comment) ) { ?>
        <TR><TD colspan=2>
                Note: <?php preg_replace('%(?:\A<br\s*/?\s*>)+|(?:<br\s*/?\s*>)+$%i', '', $order->comment); ?>
            </TD></TR>
        <?php } ?>
    </TABLE><BR>

    <TABLE width=900 BORDER=3 CELLPADDING=2 CELLSPACING=0>
        <COL width= 40px>
        <COL width= 0px>
        <COL width= 200px>
        <COL width= 400px>
        <COL width= 100px>
        <COL width= 100px style = "text-align: right">

        <?php foreach ($orders_detail_filtered as $key => $orders_detail) { ?>
	        <TR>
	        	<TD>
	                <?php
                    if (!$orders_detail->side_dish) {
                        echo \DateTime::createFromFormat('Y-m-d H:i:s', $orders_detail->serve_at)->format('H:i');
                    }
                    ?>
	            </TD>
	            <TD style="text-align: center">
	                <?php echo  $orders_detail->x_number ?>x
	            </TD>
	            <TD>
	                <?php echo $meal[$key]->name; ?>
	            </TD>
	            <TD>
	                <?php echo $user->name; ?>
	            </TD>
	            <TD>
	                <?php
                    if ($orders_detail->price && $orders_detail->price != '0.00' && $orders_detail->price > 0) {
                       echo $orders_detail->price .''.$currency.' x '.$orders_detail->x_number;
                    }
                    ?>
	            </TD>
	        </TR>
	        <?php $orders_detail_comment = trim (str_replace('<br>','',$orders_detail->comment)); if ( !empty($orders_detail_comment) ) { ?>
		        <TR><TD colspan=5 >
		                <?php preg_replace('%(?:\A<br\s*/?\s*>)+|(?:<br\s*/?\s*>)+$%i', '', $orders_detail->comment); ?>
		            </TD>
		        </TR>
	        <?php }
        } ?>
        <TR><TD colspan=4 style = "text-align: right">
                Total
            </TD><TD>
                <?php
                if ($orders_detail_total_price && $orders_detail_total_price != '0.00' && $orders_detail_total_price > 0) {
                   echo $orders_detail_total_price .''.$currency;
                }
                ?>
            </TD></TR>
    </TABLE>
    
    <BR>
    <A HREF="http://www.gastro-booking.com/">www.gastro-booking.com</A>

</div>
</body></html>


