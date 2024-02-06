<?php

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

            <div class="col-sm-12">

                <div class="col-sm-3 text-center">

                    <img src="images/NSLogosmall.png">

                </div>

                <div class="col-sm-3 text-center">

                    <!-- company Info -->

                    <h4><b>Next Step Pregnancy Services</b></h4>

                    <h5>19526 - 64th Ave. West, <br>Lynnwood, WA 98036</h5>
                
                </div>
                <div class="col-sm-3 text-center">
                    <h4><b><?php echo $address_name; ?></b></h4>

                    <h5><?php if($address2 !=NULL){

                    $newAddress=$address1 ." ". $address2;

                    } else {$newAddress=$address1;}; echo $newAddress; ?>

                    <br><?php if($address1 ==NULL){

                    echo $address1;

                    } else {echo $bidder['City']; ?>, <?php echo $bidder['State']; ?> <?php echo $bidder['Zip'];} ?></h5>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-sm-12 text-center">
                <hr>

                <h5><b>2023 Gala Invoice</b></h5>

            </div>

        </div>

  


    </div>
</div>



<?php
    include_once("$hooks_dir/footer.php");

    ?>


