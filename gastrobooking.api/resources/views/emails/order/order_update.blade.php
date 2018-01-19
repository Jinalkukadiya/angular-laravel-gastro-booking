<!DOCTYPE html>
<html>
<head>
    <meta http-equiv=Content-Type content="text/html; charset=windows-1250">
    <title>Your Gastro-Booking</title>
</head>
<body bgcolor="#FFFFFF" lang=CSlink=#000080 vlink=#800080 text="#000000">
<div>
    <TABLE width=600 BORDER=3 CELLPADDING=4 CELLSPACING=0>
        <COL width= 150px>
        <TR><TD>
                <IMG SRC="http://www.gastro-booking.com/assets/images/logomini.png">
            </TD><TD>
                <?php echo ($order->pick_up === 'Y') ? "PICK UP" : (($order->delivery_address && $order->delivery_phone) ? "DELIVERY" : "BOOKING FOR"); ?>
                BOOKING FOR&nbsp;&nbsp;&nbsp;<?= $order->cancellation  ?> &nbsp;&nbsp;&nbsp;NUMBER: <?= $order->order_number ?><BR>
                <?php echo ($order->delivery_address && $order->delivery_phone) ? $order->delivery_address . ", GPS: latitude - " . $order->delivery_latitude . ", longitude - " . $order->delivery_longitude
                        : $restaurant->name; ?><BR>
            </TD></TR>
        <TR><TD>
                @lang('main.MAIL.CUSTOMER')
            </TD><TD>
                <?= $user->name ?> (booking from <?= $order->created_at->format('d.m.Y H:i') ?>)
                <?php echo ($order->delivery_address && $order->delivery_phone) ? ", tel.: ". $order->delivery_phone :
                           ($user->client->phone ? ", tel.: ". $user->client->phone : "" ); ?>
            </TD></TR>
        <TR><TD>
                Numbers and price
            </TD><TD>
                <?= $order->persons?> persons - <?= $orders_detail_count ?> items - total <?= $orders_detail_total_price ?> <?= $order->currency ?>
            </TD></TR>
        <TR><TD colspan=2>
                Note: <?= $order->comment ?>
            </TD></TR>
    </TABLE><BR>


    <TABLE width=600 BORDER=3 CELLPADDING=2 CELLSPACING=0>
        <COL width= 40px>
        <COL width= 0px>
        <COL width= 60px>
        <COL width= 0px>
        <COL width= 100px>
        <COL width= 100px style = "text-align: right">

        <?php foreach ($order->orders_detail as $orders_detail) {
        if ($orders_detail->status != 3 && !$orders_detail->side_dish) { ?>

        <TR><TD>
                <?= \DateTime::createFromFormat('Y-m-d H:i:s', $orders_detail->serve_at)->format('H:i') ?>
            </TD><TD style="text-align: center">
                <?= $orders_detail->x_number ?>x
            </TD><TD>
                <?= $orders_detail->menu_list->prefix ?>
            </TD><TD>
                <?php echo $orders_detail->is_child ? 'Child portion: ' . $orders_detail->menu_list->name : $orders_detail->menu_list->name; ?>
            </TD><TD>
                <?= $orders_detail->client->user->name ?>
            </TD><TD>
                <?= $orders_detail->price ?>
                <?= $orders_detail->menu_list->currency ?> x <?= $orders_detail->x_number ?>
            </TD></TR>
        <?php if ($orders_detail->comment) { ?>
        <TR><TD colspan=6 >
                <?= $orders_detail->comment ?>
            </TD></TR>
        <?php } ?>

        <?php  if (count($orders_detail->sideDish)) {
        foreach ($orders_detail->sideDish as $sideDish) {
        if ($sideDish->status != 3) {
        ?>
        <TR><TD colspan="2" style="text-align: right">
                <?= $sideDish->x_number ?>x
            </TD><TD>
                <?= $sideDish->menu_list->prefix ?>
            </TD><TD>
                <?php echo $sideDish->is_child ? 'Child portion: ' . $sideDish->menu_list->name : $sideDish->menu_list->name; ?>
            </TD><TD>
                <?= $sideDish->client->user->name ?>
            </TD><TD>
                <?= $sideDish->price ?>
                <?= $sideDish->menu_list->currency?> x <?= $sideDish->x_number ?>
            </TD></TR>
        <?php } } ?>
        <?php
        }
        } } ?>
        <TR><TD colspan=5 style = "text-align: right">
                Total
            </TD><TD>
                <?= $orders_detail_total_price ?> <?= $order->currency ?>
            </TD></TR>
    </TABLE>

    <FONT SIZE="+0"><B>Cancelled:</B><BR></FONT>

    <TABLE style = "text-decoration: line-through" width=600 BORDER=3 CELLPADDING=2 CELLSPACING=0>
        <COL width= 40px>
        <COL width= 0px>
        <COL width= 60px>
        <COL width= 0px>
        <COL width= 100px>
        <COL width= 100px style = "text-align: right">
        <?php foreach ($order->orders_detail as $orders_detail) {
        if ( $orders_detail->status == 3  && (($orders_detail->side_dish && $orders_detail->mainDish->status != 3) || (!$orders_detail->side_dish))){
        ?>
        <TR><TD>
                <?= \DateTime::createFromFormat('Y-m-d H:i:s', $orders_detail->serve_at)->format('H:i') ?>
            </TD><TD style="text-align: center">
                <?=  $orders_detail->x_number ?>x
            </TD><TD>
                <?= $orders_detail->menu_list->prefix ?>
            </TD><TD>
                <?php echo $orders_detail->is_child ? 'Child portion: ' . $orders_detail->menu_list->name : $orders_detail->menu_list->name; ?>
            </TD><TD>
                <?= $orders_detail->client->user->name ?>
            </TD><TD>
                <?= $orders_detail->price ?>
                <?= $orders_detail->menu_list->currency ?> x <?= $orders_detail->x_number ?>
            </TD></TR>
        <?php if ($orders_detail->comment) { ?>
        <TR><TD colspan=6 >
                <?= $orders_detail->comment ?>
            </TD></TR>
        <?php } ?>

        <?php  if (count($orders_detail->sideDish)) {
        foreach ($orders_detail->sideDish as $sideDish) {

        ?>
        <TR><TD colspan="2" style="text-align: right">
                <?= $sideDish->x_number ?>x
            </TD><TD>
                <?= $sideDish->menu_list->prefix ?>
            </TD><TD>
                <?php echo $sideDish->is_child ? 'Child portion: ' . $sideDish->menu_list->name : $sideDish->menu_list->name; ?>
            </TD><TD>
                <?= $sideDish->client->user->name ?>
            </TD><TD>
                <?= $sideDish->price ?>
                <?= $sideDish->menu_list->currency?> x <?= $sideDish->x_number ?>
            </TD></TR>
        <?php } } ?>
        <?php
        }
        }?>
        <TR>
    </TABLE>
    <BR>
    Enjoy your meal!<BR>

    <A HREF="http://www.gastro-booking.com/">www.gastro-booking.com</A>
</div>
</body></html>
