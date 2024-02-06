<?php
	define('PREPEND_PATH', '');
	include_once(__DIR__ . '/lib.php');

	// accept a record as an assoc array, return transformed row ready to insert to table
	$transformFunctions = [
		'Contacts' => function($data, $options = []) {
			if(isset($data['Cell'])) $data['Cell'] = str_replace('-', '', $data['Cell']);
			if(isset($data['Phone'])) $data['Phone'] = str_replace('-', '', $data['Phone']);

			return $data;
		},
		'Settings' => function($data, $options = []) {

			return $data;
		},
		'Donations' => function($data, $options = []) {
			if(isset($data['CatalogID'])) $data['CatalogID'] = pkGivenLookupText($data['CatalogID'], 'Donations', 'CatalogID');
			if(isset($data['ContactID'])) $data['ContactID'] = pkGivenLookupText($data['ContactID'], 'Donations', 'ContactID');
			if(isset($data['DateProcured'])) $data['DateProcured'] = guessMySQLDateTime($data['DateProcured']);

			return $data;
		},
		'Catalog' => function($data, $options = []) {
			if(isset($data['TypeID'])) $data['TypeID'] = pkGivenLookupText($data['TypeID'], 'Catalog', 'TypeID');
			if(isset($data['GroupID'])) $data['GroupID'] = pkGivenLookupText($data['GroupID'], 'Catalog', 'GroupID');

			return $data;
		},
		'Bidders' => function($data, $options = []) {
			if(isset($data['ContactID'])) $data['ContactID'] = pkGivenLookupText($data['ContactID'], 'Bidders', 'ContactID');
			if(isset($data['MailingName'])) $data['MailingName'] = thisOr($data['ContactID'], pkGivenLookupText($data['MailingName'], 'Bidders', 'MailingName'));
			if(isset($data['Business'])) $data['Business'] = thisOr($data['ContactID'], pkGivenLookupText($data['Business'], 'Bidders', 'Business'));
			if(isset($data['Address1'])) $data['Address1'] = thisOr($data['ContactID'], pkGivenLookupText($data['Address1'], 'Bidders', 'Address1'));
			if(isset($data['Address2'])) $data['Address2'] = thisOr($data['ContactID'], pkGivenLookupText($data['Address2'], 'Bidders', 'Address2'));
			if(isset($data['City'])) $data['City'] = thisOr($data['ContactID'], pkGivenLookupText($data['City'], 'Bidders', 'City'));
			if(isset($data['State'])) $data['State'] = thisOr($data['ContactID'], pkGivenLookupText($data['State'], 'Bidders', 'State'));
			if(isset($data['Zip'])) $data['Zip'] = thisOr($data['ContactID'], pkGivenLookupText($data['Zip'], 'Bidders', 'Zip'));

			return $data;
		},
		'Transactions' => function($data, $options = []) {
			if(isset($data['CatalogID'])) $data['CatalogID'] = pkGivenLookupText($data['CatalogID'], 'Transactions', 'CatalogID');
			if(isset($data['BidderID'])) $data['BidderID'] = pkGivenLookupText($data['BidderID'], 'Transactions', 'BidderID');

			return $data;
		},
		'Payments' => function($data, $options = []) {
			if(isset($data['Date'])) $data['Date'] = guessMySQLDateTime($data['Date']);
			if(isset($data['BidderID'])) $data['BidderID'] = pkGivenLookupText($data['BidderID'], 'Payments', 'BidderID');
			if(isset($data['PaymentAmount'])) $data['PaymentAmount'] = preg_replace('/[^\d\.]/', '', $data['PaymentAmount']);

			return $data;
		},
		'CatalogTypes' => function($data, $options = []) {

			return $data;
		},
		'CatalogGroups' => function($data, $options = []) {

			return $data;
		},
		'Tickets' => function($data, $options = []) {
			if(isset($data['BidderID'])) $data['BidderID'] = pkGivenLookupText($data['BidderID'], 'Tickets', 'BidderID');
			if(isset($data['TableID'])) $data['TableID'] = pkGivenLookupText($data['TableID'], 'Tickets', 'TableID');
			if(isset($data['TablePreference'])) $data['TablePreference'] = thisOr($data['BidderID'], pkGivenLookupText($data['TablePreference'], 'Tickets', 'TablePreference'));
			if(isset($data['TableName'])) $data['TableName'] = thisOr($data['TableID'], pkGivenLookupText($data['TableName'], 'Tickets', 'TableName'));

			return $data;
		},
		'Tables' => function($data, $options = []) {

			return $data;
		},
	];

	// accept a record as an assoc array, return a boolean indicating whether to import or skip record
	$filterFunctions = [
		'Contacts' => function($data, $options = []) { return true; },
		'Settings' => function($data, $options = []) { return true; },
		'Donations' => function($data, $options = []) { return true; },
		'Catalog' => function($data, $options = []) { return true; },
		'Bidders' => function($data, $options = []) { return true; },
		'Transactions' => function($data, $options = []) { return true; },
		'Payments' => function($data, $options = []) { return true; },
		'CatalogTypes' => function($data, $options = []) { return true; },
		'CatalogGroups' => function($data, $options = []) { return true; },
		'Tickets' => function($data, $options = []) { return true; },
		'Tables' => function($data, $options = []) { return true; },
	];

	/*
	Hook file for overwriting/amending $transformFunctions and $filterFunctions:
	hooks/import-csv.php
	If found, it's included below

	The way this works is by either completely overwriting any of the above 2 arrays,
	or, more commonly, overwriting a single function, for example:
		$transformFunctions['tablename'] = function($data, $options = []) {
			// new definition here
			// then you must return transformed data
			return $data;
		};

	Another scenario is transforming a specific field and leaving other fields to the default
	transformation. One possible way of doing this is to store the original transformation function
	in GLOBALS array, calling it inside the custom transformation function, then modifying the
	specific field:
		$GLOBALS['originalTransformationFunction'] = $transformFunctions['tablename'];
		$transformFunctions['tablename'] = function($data, $options = []) {
			$data = call_user_func_array($GLOBALS['originalTransformationFunction'], [$data, $options]);
			$data['fieldname'] = 'transformed value';
			return $data;
		};
	*/

	@include(__DIR__ . '/hooks/import-csv.php');

	$ui = new CSVImportUI($transformFunctions, $filterFunctions);
