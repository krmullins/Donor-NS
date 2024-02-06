<?php
// This script and data application was generated by AppGini, https://bigprof.com/appgini
// Download AppGini for free from https://bigprof.com/appgini/download/

	include_once(__DIR__ . '/lib.php');
	@include_once(__DIR__ . '/hooks/Donations.php');
	include_once(__DIR__ . '/Donations_dml.php');

	// mm: can the current member access this page?
	$perm = getTablePermissions('Donations');
	if(!$perm['access']) {
		echo error_message($Translation['tableAccessDenied']);
		exit;
	}

	$x = new DataList;
	$x->TableName = 'Donations';

	// Fields that can be displayed in the table view
	$x->QueryFieldsTV = [
		"`Donations`.`ID`" => "ID",
		"`Donations`.`DonationName`" => "DonationName",
		"`Donations`.`Description`" => "Description",
		"`Donations`.`Restrictions`" => "Restrictions",
		"`Donations`.`Value`" => "Value",
		"IF(    CHAR_LENGTH(`Catalog1`.`CatalogNo`) || CHAR_LENGTH(`Catalog1`.`CatalogTitle`), CONCAT_WS('',   `Catalog1`.`CatalogNo`, ' - ', `Catalog1`.`CatalogTitle`), '') /* Catalog Number */" => "CatalogID",
		"IF(    CHAR_LENGTH(`Contacts1`.`MailingNameFull`), CONCAT_WS('',   `Contacts1`.`MailingNameFull`), '') /* Donor Name Lookup */" => "ContactID",
		"`Donations`.`ContactPerson`" => "ContactPerson",
		"`Donations`.`ContactPhone`" => "ContactPhone",
		"`Donations`.`ItemStatus`" => "ItemStatus",
		"`Donations`.`ProcuredBy`" => "ProcuredBy",
		"if(`Donations`.`DateProcured`,date_format(`Donations`.`DateProcured`,'%m/%d/%Y'),'')" => "DateProcured",
		"`Donations`.`AdditionalInfo`" => "AdditionalInfo",
		"`Donations`.`Thanks`" => "Thanks",
		"`Donations`.`Notes`" => "Notes",
	];
	// mapping incoming sort by requests to actual query fields
	$x->SortFields = [
		1 => '`Donations`.`ID`',
		2 => 2,
		3 => 3,
		4 => 4,
		5 => '`Donations`.`Value`',
		6 => 6,
		7 => '`Contacts1`.`MailingNameFull`',
		8 => 8,
		9 => 9,
		10 => 10,
		11 => 11,
		12 => '`Donations`.`DateProcured`',
		13 => 13,
		14 => 14,
		15 => 15,
	];

	// Fields that can be displayed in the csv file
	$x->QueryFieldsCSV = [
		"`Donations`.`ID`" => "ID",
		"`Donations`.`DonationName`" => "DonationName",
		"`Donations`.`Description`" => "Description",
		"`Donations`.`Restrictions`" => "Restrictions",
		"`Donations`.`Value`" => "Value",
		"IF(    CHAR_LENGTH(`Catalog1`.`CatalogNo`) || CHAR_LENGTH(`Catalog1`.`CatalogTitle`), CONCAT_WS('',   `Catalog1`.`CatalogNo`, ' - ', `Catalog1`.`CatalogTitle`), '') /* Catalog Number */" => "CatalogID",
		"IF(    CHAR_LENGTH(`Contacts1`.`MailingNameFull`), CONCAT_WS('',   `Contacts1`.`MailingNameFull`), '') /* Donor Name Lookup */" => "ContactID",
		"`Donations`.`ContactPerson`" => "ContactPerson",
		"`Donations`.`ContactPhone`" => "ContactPhone",
		"`Donations`.`ItemStatus`" => "ItemStatus",
		"`Donations`.`ProcuredBy`" => "ProcuredBy",
		"if(`Donations`.`DateProcured`,date_format(`Donations`.`DateProcured`,'%m/%d/%Y'),'')" => "DateProcured",
		"`Donations`.`AdditionalInfo`" => "AdditionalInfo",
		"`Donations`.`Thanks`" => "Thanks",
		"`Donations`.`Notes`" => "Notes",
	];
	// Fields that can be filtered
	$x->QueryFieldsFilters = [
		"`Donations`.`ID`" => "ID",
		"`Donations`.`DonationName`" => "Donation Name",
		"`Donations`.`Description`" => "Description",
		"`Donations`.`Restrictions`" => "Restrictions",
		"`Donations`.`Value`" => "Value",
		"IF(    CHAR_LENGTH(`Catalog1`.`CatalogNo`) || CHAR_LENGTH(`Catalog1`.`CatalogTitle`), CONCAT_WS('',   `Catalog1`.`CatalogNo`, ' - ', `Catalog1`.`CatalogTitle`), '') /* Catalog Number */" => "Catalog Number",
		"IF(    CHAR_LENGTH(`Contacts1`.`MailingNameFull`), CONCAT_WS('',   `Contacts1`.`MailingNameFull`), '') /* Donor Name Lookup */" => "Donor Name Lookup",
		"`Donations`.`ContactPerson`" => "Contact Person",
		"`Donations`.`ContactPhone`" => "Contact Phone",
		"`Donations`.`ItemStatus`" => "Item Status",
		"`Donations`.`ProcuredBy`" => "Procured By",
		"`Donations`.`DateProcured`" => "Date Procured",
		"`Donations`.`AdditionalInfo`" => "Additional Info",
		"`Donations`.`Thanks`" => "Thanks",
		"`Donations`.`Notes`" => "Notes",
	];

	// Fields that can be quick searched
	$x->QueryFieldsQS = [
		"`Donations`.`ID`" => "ID",
		"`Donations`.`DonationName`" => "DonationName",
		"`Donations`.`Description`" => "Description",
		"`Donations`.`Restrictions`" => "Restrictions",
		"`Donations`.`Value`" => "Value",
		"IF(    CHAR_LENGTH(`Catalog1`.`CatalogNo`) || CHAR_LENGTH(`Catalog1`.`CatalogTitle`), CONCAT_WS('',   `Catalog1`.`CatalogNo`, ' - ', `Catalog1`.`CatalogTitle`), '') /* Catalog Number */" => "CatalogID",
		"IF(    CHAR_LENGTH(`Contacts1`.`MailingNameFull`), CONCAT_WS('',   `Contacts1`.`MailingNameFull`), '') /* Donor Name Lookup */" => "ContactID",
		"`Donations`.`ContactPerson`" => "ContactPerson",
		"`Donations`.`ContactPhone`" => "ContactPhone",
		"`Donations`.`ItemStatus`" => "ItemStatus",
		"`Donations`.`ProcuredBy`" => "ProcuredBy",
		"if(`Donations`.`DateProcured`,date_format(`Donations`.`DateProcured`,'%m/%d/%Y'),'')" => "DateProcured",
		"`Donations`.`AdditionalInfo`" => "AdditionalInfo",
		"`Donations`.`Thanks`" => "Thanks",
		"`Donations`.`Notes`" => "Notes",
	];

	// Lookup fields that can be used as filterers
	$x->filterers = ['CatalogID' => 'Catalog Number', 'ContactID' => 'Donor Name Lookup', ];

	$x->QueryFrom = "`Donations` LEFT JOIN `Catalog` as Catalog1 ON `Catalog1`.`ID`=`Donations`.`CatalogID` LEFT JOIN `Contacts` as Contacts1 ON `Contacts1`.`ID`=`Donations`.`ContactID` ";
	$x->QueryWhere = '';
	$x->QueryOrder = '';

	$x->AllowSelection = 1;
	$x->HideTableView = ($perm['view'] == 0 ? 1 : 0);
	$x->AllowDelete = $perm['delete'];
	$x->AllowMassDelete = (getLoggedAdmin() !== false);
	$x->AllowInsert = $perm['insert'];
	$x->AllowUpdate = $perm['edit'];
	$x->SeparateDV = 1;
	$x->AllowDeleteOfParents = 0;
	$x->AllowFilters = 1;
	$x->AllowSavingFilters = 1;
	$x->AllowSorting = 1;
	$x->AllowNavigation = 1;
	$x->AllowPrinting = 1;
	$x->AllowPrintingDV = 1;
	$x->AllowCSV = 1;
	$x->RecordsPerPage = 100;
	$x->QuickSearch = 1;
	$x->QuickSearchText = $Translation['quick search'];
	$x->ScriptFileName = 'Donations_view.php';
	$x->TableTitle = 'Donations';
	$x->TableIcon = 'resources/table_icons/32Px - 396.png';
	$x->PrimaryKey = '`Donations`.`ID`';

	$x->ColWidth = [150, 150, 150, 150, 150, 150, 150, 150, 150, 150, 150, 150, 150, 150, ];
	$x->ColCaption = ['Donation Name', 'Description', 'Restrictions', 'Value', 'Catalog Number', 'Donor Name Lookup', 'Contact Person', 'Contact Phone', 'Item Status', 'Procured By', 'Date Procured', 'Additional Info', 'Thanks', 'Notes', ];
	$x->ColFieldName = ['DonationName', 'Description', 'Restrictions', 'Value', 'CatalogID', 'ContactID', 'ContactPerson', 'ContactPhone', 'ItemStatus', 'ProcuredBy', 'DateProcured', 'AdditionalInfo', 'Thanks', 'Notes', ];
	$x->ColNumber  = [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, ];

	// template paths below are based on the app main directory
	$x->Template = 'templates/Donations_templateTV.html';
	$x->SelectedTemplate = 'templates/Donations_templateTVS.html';
	$x->TemplateDV = 'templates/Donations_templateDV.html';
	$x->TemplateDVP = 'templates/Donations_templateDVP.html';

	$x->ShowTableHeader = 1;
	$x->TVClasses = "";
	$x->DVClasses = "";
	$x->HasCalculatedFields = false;
	$x->AllowConsoleLog = false;
	$x->AllowDVNavigation = true;

	// hook: Donations_init
	$render = true;
	if(function_exists('Donations_init')) {
		$args = [];
		$render = Donations_init($x, getMemberInfo(), $args);
	}

	if($render) $x->Render();

	// hook: Donations_header
	$headerCode = '';
	if(function_exists('Donations_header')) {
		$args = [];
		$headerCode = Donations_header($x->ContentType, getMemberInfo(), $args);
	}

	if(!$headerCode) {
		include_once(__DIR__ . '/header.php'); 
	} else {
		ob_start();
		include_once(__DIR__ . '/header.php');
		echo str_replace('<%%HEADER%%>', ob_get_clean(), $headerCode);
	}

	echo $x->HTML;

	// hook: Donations_footer
	$footerCode = '';
	if(function_exists('Donations_footer')) {
		$args = [];
		$footerCode = Donations_footer($x->ContentType, getMemberInfo(), $args);
	}

	if(!$footerCode) {
		include_once(__DIR__ . '/footer.php'); 
	} else {
		ob_start();
		include_once(__DIR__ . '/footer.php');
		echo str_replace('<%%FOOTER%%>', ob_get_clean(), $footerCode);
	}