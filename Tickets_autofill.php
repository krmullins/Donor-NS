<?php
// This script and data application was generated by AppGini, https://bigprof.com/appgini
// Download AppGini for free from https://bigprof.com/appgini/download/

	include_once(__DIR__ . '/lib.php');

	handle_maintenance();

	header('Content-type: text/javascript; charset=' . datalist_db_encoding);

	$table_perms = getTablePermissions('Tickets');
	if(!$table_perms['access']) die('// Access denied!');

	$mfk = Request::val('mfk');
	$id = makeSafe(Request::val('id'));
	$rnd1 = intval(Request::val('rnd1')); if(!$rnd1) $rnd1 = '';

	if(!$mfk) {
		die('// No js code available!');
	}

	switch($mfk) {

		case 'BidderID':
			if(!$id) {
				?>
				$j('#TablePreference<?php echo $rnd1; ?>').html('&nbsp;');
				<?php
				break;
			}
			$res = sql("SELECT `Bidders`.`ID` as 'ID', IF(    CHAR_LENGTH(`Contacts1`.`MailingNameFull`), CONCAT_WS('',   `Contacts1`.`MailingNameFull`), '') as 'ContactID', `Bidders`.`BidNo` as 'BidNo', `Bidders`.`BidderType` as 'BidderType', `Bidders`.`CheckedIn` as 'CheckedIn', `Bidders`.`QuickPay` as 'QuickPay', `Bidders`.`TotalBids` as 'TotalBids', `Bidders`.`TotalOwed` as 'TotalOwed', IF(    CHAR_LENGTH(`Contacts1`.`MailingNameFull`), CONCAT_WS('',   `Contacts1`.`MailingNameFull`), '') as 'MailingName', `Bidders`.`TablePreference` as 'TablePreference', `Bidders`.`Card` as 'Card', `Bidders`.`TotalPaid` as 'TotalPaid', IF(    CHAR_LENGTH(`Contacts1`.`Business`), CONCAT_WS('',   `Contacts1`.`Business`), '') as 'Business', IF(    CHAR_LENGTH(`Contacts1`.`Address1`), CONCAT_WS('',   `Contacts1`.`Address1`), '') as 'Address1', IF(    CHAR_LENGTH(`Contacts1`.`Address2`), CONCAT_WS('',   `Contacts1`.`Address2`), '') as 'Address2', IF(    CHAR_LENGTH(`Contacts1`.`City`), CONCAT_WS('',   `Contacts1`.`City`), '') as 'City', IF(    CHAR_LENGTH(`Contacts1`.`State`), CONCAT_WS('',   `Contacts1`.`State`), '') as 'State', IF(    CHAR_LENGTH(`Contacts1`.`Zip`), CONCAT_WS('',   `Contacts1`.`Zip`), '') as 'Zip' FROM `Bidders` LEFT JOIN `Contacts` as Contacts1 ON `Contacts1`.`ID`=`Bidders`.`ContactID`  WHERE `Bidders`.`ID`='{$id}' limit 1", $eo);
			$row = db_fetch_assoc($res);
			?>
			$j('#TablePreference<?php echo $rnd1; ?>').html('<?php echo addslashes(str_replace(["\r", "\n"], '', safe_html($row['TablePreference']))); ?>&nbsp;');
			<?php
			break;

		case 'TableID':
			if(!$id) {
				?>
				$j('#TableName<?php echo $rnd1; ?>').html('&nbsp;');
				<?php
				break;
			}
			$res = sql("SELECT `Tables`.`ID` as 'ID', `Tables`.`TableNo` as 'TableNo', `Tables`.`TableName` as 'TableName' FROM `Tables`  WHERE `Tables`.`ID`='{$id}' limit 1", $eo);
			$row = db_fetch_assoc($res);
			?>
			$j('#TableName<?php echo $rnd1; ?>').html('<?php echo addslashes(str_replace(["\r", "\n"], '', safe_html($row['TableName']))); ?>&nbsp;');
			<?php
			break;


	}

?>