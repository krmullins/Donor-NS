<?php
	// check this file's MD5 to make sure it wasn't called before
	$tenantId = Authentication::tenantIdPadded();
	$setupHash = __DIR__ . "/setup{$tenantId}.md5";

	$prevMD5 = @file_get_contents($setupHash);
	$thisMD5 = md5_file(__FILE__);

	// check if this setup file already run
	if($thisMD5 != $prevMD5) {
		// set up tables
		setupTable(
			'Contacts', " 
			CREATE TABLE IF NOT EXISTS `Contacts` ( 
				`ID` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
				PRIMARY KEY (`ID`),
				`FirstName` VARCHAR(40) NULL,
				`LastName` VARCHAR(50) NULL,
				`SpouseName` VARCHAR(40) NULL,
				`Business` VARCHAR(50) NULL,
				`Address1` VARCHAR(255) NULL,
				`Address2` VARCHAR(255) NULL,
				`City` VARCHAR(85) NULL,
				`State` CHAR(2) NULL,
				`Zip` VARCHAR(10) NULL,
				`Cell` VARCHAR(20) NULL,
				`Phone` VARCHAR(20) NULL,
				`Email` VARCHAR(80) NULL,
				`Status` VARCHAR(10) NULL DEFAULT 'Active',
				`ContactMethod` TINYTEXT NULL,
				`MailingName` VARCHAR(40) NULL,
				`MailingNameFull` VARCHAR(90) NULL
			) CHARSET utf8mb4"
		);

		setupTable(
			'Settings', " 
			CREATE TABLE IF NOT EXISTS `Settings` ( 
				`ID` INT UNSIGNED NOT NULL AUTO_INCREMENT,
				PRIMARY KEY (`ID`),
				`EventName` VARCHAR(40) NULL,
				`EventDate` VARCHAR(40) NULL,
				`AnonymousName` VARCHAR(40) NULL,
				`Address` MEDIUMTEXT NULL,
				`RegTicketPrice` VARCHAR(40) NULL,
				`DiscTicketPrice` VARCHAR(40) NULL,
				`DinnerCost` VARCHAR(40) NULL,
				`Logo` VARCHAR(40) NULL
			) CHARSET utf8mb4"
		);

		setupTable(
			'Donations', " 
			CREATE TABLE IF NOT EXISTS `Donations` ( 
				`ID` INT UNSIGNED NOT NULL AUTO_INCREMENT,
				PRIMARY KEY (`ID`),
				`DonationName` VARCHAR(120) NULL,
				`Description` MEDIUMTEXT NULL,
				`Restrictions` MEDIUMTEXT NULL,
				`Value` DECIMAL(10,2) NULL,
				`CatalogID` INT UNSIGNED NULL,
				`ContactID` INT(11) UNSIGNED NULL,
				`ContactPerson` VARCHAR(50) NULL,
				`ContactPhone` VARCHAR(50) NULL,
				`ItemStatus` TINYTEXT NULL,
				`ProcuredBy` VARCHAR(50) NULL,
				`DateProcured` DATE NULL,
				`AdditionalInfo` TINYTEXT NULL,
				`Thanks` VARCHAR(10) NULL,
				`Notes` MEDIUMTEXT NULL
			) CHARSET utf8mb4"
		);
		setupIndexes('Donations', ['CatalogID','ContactID',]);

		setupTable(
			'Catalog', " 
			CREATE TABLE IF NOT EXISTS `Catalog` ( 
				`ID` INT UNSIGNED NOT NULL AUTO_INCREMENT,
				PRIMARY KEY (`ID`),
				`CatalogNo` VARCHAR(6) NULL,
				`CatalogTitle` VARCHAR(50) NULL,
				`Description` MEDIUMTEXT NULL,
				`Restrictions` MEDIUMTEXT NULL,
				`TypeID` INT UNSIGNED NULL,
				`GroupID` INT UNSIGNED NULL,
				`DonorText` TINYTEXT NULL,
				`AdditionalInfo` TINYTEXT NULL,
				`CatalogValueText` VARCHAR(50) NULL,
				`Quantity` VARCHAR(50) NULL DEFAULT '1',
				`bid1` VARCHAR(10) NULL,
				`bid2` VARCHAR(10) NULL,
				`bid3` VARCHAR(10) NULL,
				`bid4` VARCHAR(10) NULL,
				`bid5` VARCHAR(10) NULL,
				`bid6` VARCHAR(10) NULL,
				`bid7` VARCHAR(10) NULL,
				`bid8` VARCHAR(10) NULL,
				`bid9` VARCHAR(10) NULL,
				`bid10` VARCHAR(10) NULL,
				`bid11` VARCHAR(10) NULL,
				`bid12` VARCHAR(10) NULL
			) CHARSET utf8mb4"
		);
		setupIndexes('Catalog', ['TypeID','GroupID',]);

		setupTable(
			'Bidders', " 
			CREATE TABLE IF NOT EXISTS `Bidders` ( 
				`ID` INT UNSIGNED NOT NULL AUTO_INCREMENT,
				PRIMARY KEY (`ID`),
				`ContactID` INT(11) UNSIGNED NULL,
				`BidNo` VARCHAR(5) NULL,
				UNIQUE `BidNo_unique` (`BidNo`),
				`BidderType` VARCHAR(10) NULL DEFAULT 'Bidder',
				`CheckedIn` VARCHAR(10) NULL,
				`QuickPay` VARCHAR(10) NULL,
				`TotalBids` DECIMAL(11,2) NULL,
				`TotalOwed` DECIMAL(10,2) NULL,
				`MailingName` INT(11) UNSIGNED NULL,
				`TablePreference` VARCHAR(50) NULL,
				`Card` VARCHAR(40) NULL,
				`TotalPaid` DECIMAL(10,2) NULL,
				`Business` INT(11) UNSIGNED NULL,
				`Address1` INT(11) UNSIGNED NULL,
				`Address2` INT(11) UNSIGNED NULL,
				`City` INT(11) UNSIGNED NULL,
				`State` INT(11) UNSIGNED NULL,
				`Zip` INT(11) UNSIGNED NULL
			) CHARSET utf8mb4"
		);
		setupIndexes('Bidders', ['ContactID',]);

		setupTable(
			'Transactions', " 
			CREATE TABLE IF NOT EXISTS `Transactions` ( 
				`ID` INT UNSIGNED NOT NULL AUTO_INCREMENT,
				PRIMARY KEY (`ID`),
				`CatalogID` INT UNSIGNED NULL,
				`BidderID` INT UNSIGNED NULL,
				`Price` DECIMAL(10,2) NULL DEFAULT '0.00',
				`Quantity` TINYINT NULL DEFAULT '1',
				`Total` INT NULL
			) CHARSET utf8mb4"
		);
		setupIndexes('Transactions', ['CatalogID','BidderID',]);

		setupTable(
			'Payments', " 
			CREATE TABLE IF NOT EXISTS `Payments` ( 
				`ID` INT UNSIGNED NOT NULL AUTO_INCREMENT,
				PRIMARY KEY (`ID`),
				`Date` DATE NULL,
				`BidderID` INT UNSIGNED NULL,
				`PaymentAmount` DECIMAL(11,2) NULL,
				`PaymentType` VARCHAR(40) NULL
			) CHARSET utf8mb4"
		);
		setupIndexes('Payments', ['BidderID',]);

		setupTable(
			'CatalogTypes', " 
			CREATE TABLE IF NOT EXISTS `CatalogTypes` ( 
				`ID` INT UNSIGNED NOT NULL AUTO_INCREMENT,
				PRIMARY KEY (`ID`),
				`TypeName` VARCHAR(50) NULL
			) CHARSET utf8mb4"
		);

		setupTable(
			'CatalogGroups', " 
			CREATE TABLE IF NOT EXISTS `CatalogGroups` ( 
				`ID` INT UNSIGNED NOT NULL AUTO_INCREMENT,
				PRIMARY KEY (`ID`),
				`GroupName` VARCHAR(50) NULL
			) CHARSET utf8mb4"
		);

		setupTable(
			'Tickets', " 
			CREATE TABLE IF NOT EXISTS `Tickets` ( 
				`ID` INT UNSIGNED NOT NULL AUTO_INCREMENT,
				PRIMARY KEY (`ID`),
				`UsersName` VARCHAR(50) NULL,
				`BidderID` INT UNSIGNED NULL,
				`TablePreference` INT UNSIGNED NULL,
				`TableID` INT UNSIGNED NULL,
				`TableName` INT UNSIGNED NULL,
				`SeatingPosition` VARCHAR(40) NULL
			) CHARSET utf8mb4"
		);
		setupIndexes('Tickets', ['BidderID','TableID',]);

		setupTable(
			'Tables', " 
			CREATE TABLE IF NOT EXISTS `Tables` ( 
				`ID` INT UNSIGNED NOT NULL AUTO_INCREMENT,
				PRIMARY KEY (`ID`),
				`TableNo` VARCHAR(50) NULL,
				`TableName` VARCHAR(50) NULL
			) CHARSET utf8mb4"
		);



		// save MD5
		@file_put_contents($setupHash, $thisMD5);
	}


	function setupIndexes($tableName, $arrFields) {
		if(!is_array($arrFields) || !count($arrFields)) return false;

		foreach($arrFields as $fieldName) {
			if(!$res = @db_query("SHOW COLUMNS FROM `$tableName` like '$fieldName'")) continue;
			if(!$row = @db_fetch_assoc($res)) continue;
			if($row['Key']) continue;

			@db_query("ALTER TABLE `$tableName` ADD INDEX `$fieldName` (`$fieldName`)");
		}
	}


	function setupTable($tableName, $createSQL = '', $arrAlter = '') {
		global $Translation;
		$oldTableName = '';
		ob_start();

		echo '<div style="padding: 5px; border-bottom:solid 1px silver; font-family: verdana, arial; font-size: 10px;">';

		// is there a table rename query?
		if(is_array($arrAlter)) {
			$matches = [];
			if(preg_match("/ALTER TABLE `(.*)` RENAME `$tableName`/i", $arrAlter[0], $matches)) {
				$oldTableName = $matches[1];
			}
		}

		if($res = @db_query("SELECT COUNT(1) FROM `$tableName`")) { // table already exists
			if($row = @db_fetch_array($res)) {
				echo str_replace(['<TableName>', '<NumRecords>'], [$tableName, $row[0]], $Translation['table exists']);
				if(is_array($arrAlter)) {
					echo '<br>';
					foreach($arrAlter as $alter) {
						if($alter != '') {
							echo "$alter ... ";
							if(!@db_query($alter)) {
								echo '<span class="label label-danger">' . $Translation['failed'] . '</span>';
								echo '<div class="text-danger">' . $Translation['mysql said'] . ' ' . db_error(db_link()) . '</div>';
							} else {
								echo '<span class="label label-success">' . $Translation['ok'] . '</span>';
							}
						}
					}
				} else {
					echo $Translation['table uptodate'];
				}
			} else {
				echo str_replace('<TableName>', $tableName, $Translation['couldnt count']);
			}
		} else { // given tableName doesn't exist

			if($oldTableName != '') { // if we have a table rename query
				if($ro = @db_query("SELECT COUNT(1) FROM `$oldTableName`")) { // if old table exists, rename it.
					$renameQuery = array_shift($arrAlter); // get and remove rename query

					echo "$renameQuery ... ";
					if(!@db_query($renameQuery)) {
						echo '<span class="label label-danger">' . $Translation['failed'] . '</span>';
						echo '<div class="text-danger">' . $Translation['mysql said'] . ' ' . db_error(db_link()) . '</div>';
					} else {
						echo '<span class="label label-success">' . $Translation['ok'] . '</span>';
					}

					if(is_array($arrAlter)) setupTable($tableName, $createSQL, false, $arrAlter); // execute Alter queries on renamed table ...
				} else { // if old tableName doesn't exist (nor the new one since we're here), then just create the table.
					setupTable($tableName, $createSQL, false); // no Alter queries passed ...
				}
			} else { // tableName doesn't exist and no rename, so just create the table
				echo str_replace("<TableName>", $tableName, $Translation["creating table"]);
				if(!@db_query($createSQL)) {
					echo '<span class="label label-danger">' . $Translation['failed'] . '</span>';
					echo '<div class="text-danger">' . $Translation['mysql said'] . db_error(db_link()) . '</div>';

					// create table with a dummy field
					@db_query("CREATE TABLE IF NOT EXISTS `$tableName` (`_dummy_deletable_field` TINYINT)");
				} else {
					echo '<span class="label label-success">' . $Translation['ok'] . '</span>';
				}
			}

			// set Admin group permissions for newly created table if membership_grouppermissions exists
			if($ro = @db_query("SELECT COUNT(1) FROM `membership_grouppermissions`")) {
				// get Admins group id
				$ro = @db_query("SELECT `groupID` FROM `membership_groups` WHERE `name`='Admins'");
				if($ro) {
					$adminGroupID = intval(db_fetch_row($ro)[0]);
					if($adminGroupID) @db_query("INSERT IGNORE INTO `membership_grouppermissions` SET
						`groupID`='$adminGroupID',
						`tableName`='$tableName',
						`allowInsert`=1, `allowView`=1, `allowEdit`=1, `allowDelete`=1
					");
				}
			}
		}

		echo '</div>';

		$out = ob_get_clean();
		if(defined('APPGINI_SETUP') && APPGINI_SETUP) echo $out;
	}
