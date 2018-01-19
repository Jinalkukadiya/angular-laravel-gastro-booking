<!DOCTYPE html>
<html>
<head>
    <meta http-equiv=Content-Type content="text/html; charset=windows-1250">
    <title>Your Gastro-Booking</title>
</head>
<body bgcolor="#FFFFFF" lang=CSlink=#000080 vlink=#800080 text="#000000">
<div>
    <TABLE width=900 BORDER=3 CELLPADDING=4 CELLSPACING=0>
        <COL width= 180px>
        <TR><TD>
                <IMG SRC="http://www.gastro-booking.com/assets/images/logomini.png">
            </TD>
            <TD>
                Žádost o 
                <?php echo (isset($order->request_order_detail[0]) && isset($order->request_order_detail[0]->serve_at)) ? date("d.m.Y h:m", strtotime($order->request_order_detail[0]->serve_at)) : ''  ?>
                &nbsp;&nbsp;&nbsp;Číslo: <?php echo $order->ID; ?>
                <BR>
                <?php if($restaurant){ ?>
                    <?php echo $restaurant->name; ?>, 
                    <?php echo $restaurant->street; ?>, 
                    <?php echo $restaurant->city; ?>, 
                    <?php echo $restaurant->www; ?>, 
                    telefon: <?php echo $restaurant->phone; ?>, 
                    mobilní.: <?php echo $restaurant->SMS_phone; ?>
                <?php } else { ?>
                    <?php echo $new_restaurant['name']; ?>, 
                    <?php echo $new_restaurant['address']; ?>, 
                <?php } ?>
                <BR>
            </TD>
            </TR>
        <TR><TD>
                Objednatel
            </TD>
            <TD>
                <?= $user->name ?> (objednávka ze dne <?= $order->created_at->format('d.m.Y H:i') ?>)
                <?php echo ($order->delivery_address && $order->delivery_phone) ? ", telefon.: ". $order->delivery_phone :
                           ($user->client->phone ? ", telefon.: ". $user->client->phone : "" ); ?>
            </TD>
            </TR>
        <TR><TD>
                Počty a cena
            </TD><TD>
                <?= $order->persons?> osob - <?= $orders_detail_count ?> položek - celkem 
                <?php
                if ($orders_detail_total_price && $orders_detail_total_price != '0.00' && $orders_detail_total_price > 0) {
                   echo $orders_detail_total_price .''.$order->currency;
                }
                ?>
            </TD></TR>
        <TR><TD colspan=2>
                Poznámka: <?= $order->comment ?>
            </TD></TR>
    </TABLE><BR>

    <?php if($checkConfirm == 1){ ?>
    <TABLE width=900 BORDER=3 CELLPADDING=2 CELLSPACING=0>
        <COL width= 40px>
        <COL width= 0px>
        <COL width= 200px>
        <COL width= 0px>
        <COL width= 100px>
        <COL width= 100px style = "text-align: right">

        <?php foreach ($orders_detail_filtered as $key => $orders_detail) {
        if ($orders_detail->status != 3 ) { ?>

        <TR>
            <TD>
                <?php
                if (!$orders_detail->side_dish) {
                    echo \DateTime::createFromFormat('Y-m-d H:i:s', $orders_detail->serve_at)->format('H:i');
                }
                ?>
            </TD>
            <TD style="text-align: center">
                <?= $orders_detail->x_number ?>x
            </TD>
            <TD>
                <?php echo $orders_detail['requestMenu']->confirmed_name; ?>
            </TD>
            <TD>
                <?php echo $user->name; ?>
            </TD>
            <TD>
                <?php
                    if ($orders_detail->price && $orders_detail->price != '0.00' && $orders_detail->price > 0) {
                       echo $orders_detail->price .''.$order->currency.' x '.$orders_detail->x_number;
                    }
                    ?>
            </TD>
        </TR>
        <?php if ($orders_detail->comment) { ?>
        <TR><TD colspan=5 >
                <?= $orders_detail->comment ?>
            </TD></TR>
        <?php } 

        } } ?>
        <TR><TD colspan=4 style = "text-align: right">
                Celkem
            </TD><TD>
                <?php
                if ($orders_detail_total_price && $orders_detail_total_price != '0.00' && $orders_detail_total_price > 0) {
                   echo $orders_detail_total_price .''.$order->currency;
                }
                ?>
            </TD></TR>
    </TABLE><BR>

    <?php } ?>

    <?php if($checkcancel == 1){ ?>
    <FONT SIZE="+0"><B>Zrušeno:</B><BR></FONT>

    <TABLE style = "text-decoration: line-through" width=900 BORDER=3 CELLPADDING=2 CELLSPACING=0>
        <COL width= 40px>
        <COL width= 0px>
        <COL width= 200px>
        <COL width= 400px>
        <COL width= 100px>
        <COL width= 100px style = "text-align: right">
        <?php foreach ($orders_detail_filtered as $key => $orders_detail) {
        if ( $orders_detail->status == 3  ){
        ?>
        <TR>
            <TD>
                <?php
                if (!$orders_detail->side_dish) {
                    echo \DateTime::createFromFormat('Y-m-d H:i:s', $orders_detail->serve_at)->format('H:i');
                }
                ?>
            </TD>
            <TD style="text-align: center">
                <?=  $orders_detail->x_number ?>x
            </TD>
            <TD>
                <?php echo $orders_detail['requestMenu']->confirmed_name; ?>
            </TD>
            <TD>
                <?php echo $user->name; ?>
            </TD>
            <TD>
                 <?php
                    if ($orders_detail->price && $orders_detail->price != '0.00' && $orders_detail->price > 0) {
                       echo $orders_detail->price .''.$order->currency.' x '.$orders_detail->x_number;
                    }
                    ?>
            </TD>
        </TR>
        <?php if ($orders_detail->comment) { ?>
        <TR><TD colspan=5 >
                <?= $orders_detail->comment ?>
            </TD></TR>
        <?php } 

        }
        }?>
        <TR>
    </TABLE>
    <BR>
    <?php } ?>
    <A HREF="http://www.gastro-booking.com/">www.gastro-booking.com</A>
</div>
</body></html>
