t<?php

    $hooks_dir = dirname(__FILE__);

     include("$hooks_dir/lib.php");

     include_once("$hooks_dir/header.php");

    /* grant access to all users who have access to the Bidders table */
    $bidders_from = get_sql_from('Bidders');
    if(!$bidders_from) exit(error_message('Access denied!', false));


    /* get invoice */
    $bidder_id = intval($_REQUEST['BidderID']);
    if(!$bidder_id) exit(error_message('Invalid bidder ID!', false));

    /* retrieve Bidder details */
    $bidder_fields = get_sql_fields('Bidders');
    $res = sql("select {$bidder_fields} from {$bidders_from} and Bidders.ID={$bidder_id}", $eo);
    if(!($bidder = db_fetch_array($res)))  exit(error_message('Bidder not found!', false));

    //var_dump($bidder);

    /* Retreive transactions */
    $items = array();
    $transaction_total = 0;
    $transaction_fields = get_sql_fields('Transactions');
    $transaction_from = get_sql_from('Transactions');
    $res = sql("Select {$transaction_fields} from {$transaction_from} and BidderID={$bidder_id}", $eo);
    while($row = db_fetch_assoc($res)){
        $items[] = $row;
        $order_total += $row['Total'];
    }
    //var_dump($items);

    $address1 = $bidder['Address1'];

    $address2 = $bidder['Address2'];

    $newAddress = $address1 . "\\n" . $address2;

    if($bidder['Business'] !=NULL){

        $address_name = $bidder['Business'];

    } else {$address_name = $bidder['MailingName'];



    };
?>

<!-- non-printable buttons for printing and closing invoice -->

<div class="btn-group hidden-print pull-right">

        <button type="button" class="btn btn-default btn-lg" onclick="history.back();">

			<i class="glyphicon glyphicon-chevron-left"></i> <?php echo html_attr($Translation['Back']); ?>

		<button type="button" class="btn btn-primary btn-lg" onclick="window.print();">

			<i class="glyphicon glyphicon-print"></i> <?php echo $Translation['Print']; ?>

		</button>

	</div>

	<div class="clearfix"></div>

<!-- end of buttons -->



<div class="container">

    <div class="page-header">

        <div class="row">

            <div class="col-xs-12">

                <div class="col-xs-2 text-center">

                    <img src="images/NSLogosmall.png">

                </div>

                <div class="col-xs-5 text-center">

                    <!-- company Info -->

                    <h4><b>Next Step Pregnancy Services</b></h4>

                    <h5>19526 - 64th Ave. West, <br>Lynnwood, WA 98036</h5>

                </div>
                <div class="col-xs-5 text-right">
                <h4><b>2023 Gala Invoice</b></h4>

                 </div>
            </div>
        </div>
        <div class="row">

            <div class="col-xs-12">
                <hr>

                <div class="col-xs-2 text-right">

                    <h4>Sold To:</h4>

                </div>

                <div class="col-xs-5 text-left">

                    <h4><b><?php echo $address_name; ?></b></h4>

                    <h5><?php if($address2 !=NULL){

                    $newAddress=$address1 ." ". $address2;

                    } else {$newAddress=$address1;}; echo $newAddress; ?>

                    <br><?php if($address1 ==NULL){

                    echo $address1;

                    } else {echo $bidder['City']; ?>, <?php echo $bidder['State']; ?> <?php echo $bidder['Zip'];} ?></h5>

                </div>
                <div class="col-xs-5 text-left">
                    <H4>Bidder: <?php echo $bidder['BidNo']; ?></H4>
                </div> 
            </div>
        </div>

</div>
</div>
<hr>
<!-- transaction lines -->
<table class="table table-striped table-bordered">
    <thead>
        <th class=text-center>#</th>
        <th class=text>Catalog Name</th>
        <th class=text>Price</th>
        <th class=text>Quantity</th>
        <th class=text>Value</th>
        <th class=text>Total</th>
    </thead>

    <tbody>
        <?php foreach($items as $i => $item){ ?>
            <tr>
                <td class="text-center"><?php echo ($i + 1); ?></td>
                <td class="text"><?php echo $item['CatalogID']; ?></td>
                <td class="text-right">$<?php echo $item['Price']; ?></td>
                <td class="text-right"><?php echo $item['Quantity']; ?></td>
                <td class="text-right">$<?php echo $item['CatValue']; ?></td>
                <td class="text-right">$<?php echo $item['Total']; ?></td>
            </tr>
        <?php } ?>
    </tbody>

    <tfoot>
        <tr>
            <th colspan="5" class="text-right">Total</th>
            <th class="text-right">$<?php echo number_format($order_total,2); ?></th>
        </tr>
    </tfoot>
</table>


<hr>
<div class="container">
    <div class="panel panel-body">
        <div class="row">
            <div class="text-center">
            <p>For tax purposes, the value(s) of the item(s) you purchased tonight are included on this receipt.  Dinner ticket prices are included in the invoice. The actual cost of the dinner was $43.00.</p>
            </div>        
        </div>
        <div class="row">
            <div class="text-center">
            <p>This is the official receipt for tax purposes. Please retain for your tax records.</p>
            </div>
        </div>
    </div>
</div>



<?php
    include_once("$hooks_dir/footer.php");

    ?>


