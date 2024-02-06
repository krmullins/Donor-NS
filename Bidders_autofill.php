<?php
// This script and data application was generated by AppGini, https://bigprof.com/appgini
// Download AppGini for free from https://bigprof.com/appgini/download/

	include_once(__DIR__ . '/lib.php');

	handle_maintenance();

	header('Content-type: text/javascript; charset=' . datalist_db_encoding);

	$table_perms = getTablePermissions('Bidders');
	if(!$table_perms['access']) die('// Access denied!');

	$mfk = Request::val('mfk');
	$id = makeSafe(Request::val('id'));
	$rnd1 = intval(Request::val('rnd1')); if(!$rnd1) $rnd1 = '';

	if(!$mfk) {
		die('// No js code available!');
	}

	switch($mfk) {

		case 'ContactID':
			if(!$id) {
				?>
				$j('#MailingName<?php echo $rnd1; ?>').html('&nbsp;');
				$j('#Business<?php echo $rnd1; ?>').html('&nbsp;');
				$j('#Address1<?php echo $rnd1; ?>').html('&nbsp;');
				$j('#Address2<?php echo $rnd1; ?>').html('&nbsp;');
				$j('#City<?php echo $rnd1; ?>').html('&nbsp;');
				$j('#State<?php echo $rnd1; ?>').html('&nbsp;');
				$j('#Zip<?php echo $rnd1; ?>').html('&nbsp;');
				<?php
				break;
			}
			$res = sql("SELECT `Contacts`.`ID` as 'ID', `Contacts`.`FirstName` as 'FirstName', `Contacts`.`LastName` as 'LastName', `Contacts`.`SpouseName` as 'SpouseName', `Contacts`.`Business` as 'Business', `Contacts`.`Address1` as 'Address1', `Contacts`.`Address2` as 'Address2', `Contacts`.`City` as 'City', `Contacts`.`State` as 'State', `Contacts`.`Zip` as 'Zip', CONCAT_WS('-', LEFT(`Contacts`.`Cell`,3), MID(`Contacts`.`Cell`,4,3), RIGHT(`Contacts`.`Cell`,4)) as 'Cell', CONCAT_WS('-', LEFT(`Contacts`.`Phone`,3), MID(`Contacts`.`Phone`,4,3), RIGHT(`Contacts`.`Phone`,4)) as 'Phone', `Contacts`.`Email` as 'Email', `Contacts`.`Status` as 'Status', `Contacts`.`ContactMethod` as 'ContactMethod', `Contacts`.`MailingName` as 'MailingName', `Contacts`.`MailingNameFull` as 'MailingNameFull' FROM `Contacts`  WHERE `Contacts`.`ID`='{$id}' limit 1", $eo);
			$row = db_fetch_assoc($res);
			?>
			$j('#MailingName<?php echo $rnd1; ?>').html('<?php echo addslashes(str_replace(["\r", "\n"], '', safe_html($row['MailingNameFull']))); ?>&nbsp;');
			$j('#Business<?php echo $rnd1; ?>').html('<?php echo addslashes(str_replace(["\r", "\n"], '', safe_html($row['Business']))); ?>&nbsp;');
			$j('#Address1<?php echo $rnd1; ?>').html('<?php echo addslashes(str_replace(["\r", "\n"], '', safe_html($row['Address1']))); ?>&nbsp;');
			$j('#Address2<?php echo $rnd1; ?>').html('<?php echo addslashes(str_replace(["\r", "\n"], '', safe_html($row['Address2']))); ?>&nbsp;');
			$j('#City<?php echo $rnd1; ?>').html('<?php echo addslashes(str_replace(["\r", "\n"], '', safe_html($row['City']))); ?>&nbsp;');
			$j('#State<?php echo $rnd1; ?>').html('<?php echo addslashes(str_replace(["\r", "\n"], '', safe_html($row['State']))); ?>&nbsp;');
			$j('#Zip<?php echo $rnd1; ?>').html('<?php echo addslashes(str_replace(["\r", "\n"], '', safe_html($row['Zip']))); ?>&nbsp;');
			<?php
			break;


	}

?>