<?php
// This script and data application was generated by AppGini, https://bigprof.com/appgini
// Download AppGini for free from https://bigprof.com/appgini/download/

	include_once(__DIR__ . '/lib.php');
	@include_once(__DIR__ . '/hooks/Catalog.php');
	include_once(__DIR__ . '/Catalog_dml.php');

	// mm: can the current member access this page?
	$perm = getTablePermissions('Catalog');
	if(!$perm['access']) {
		echo error_message($Translation['tableAccessDenied']);
		exit;
	}

	$x = new DataList;
	$x->TableName = 'Catalog';

	// Fields that can be displayed in the table view
	$x->QueryFieldsTV = [
		"`Catalog`.`ID`" => "ID",
		"`Catalog`.`CatalogNo`" => "CatalogNo",
		"`Catalog`.`CatalogTitle`" => "CatalogTitle",
		"`Catalog`.`Description`" => "Description",
		"`Catalog`.`Restrictions`" => "Restrictions",
		"IF(    CHAR_LENGTH(`CatalogTypes1`.`TypeName`), CONCAT_WS('',   `CatalogTypes1`.`TypeName`), '') /* Catalog Type */" => "TypeID",
		"IF(    CHAR_LENGTH(`CatalogGroups1`.`GroupName`), CONCAT_WS('',   `CatalogGroups1`.`GroupName`), '') /* Grouping */" => "GroupID",
		"`Catalog`.`DonorText`" => "DonorText",
		"`Catalog`.`AdditionalInfo`" => "AdditionalInfo",
		"`Catalog`.`CatalogValueText`" => "CatalogValueText",
		"`Catalog`.`Quantity`" => "Quantity",
		"`Catalog`.`bid1`" => "bid1",
		"`Catalog`.`bid2`" => "bid2",
		"`Catalog`.`bid3`" => "bid3",
		"`Catalog`.`bid4`" => "bid4",
		"`Catalog`.`bid5`" => "bid5",
		"`Catalog`.`bid6`" => "bid6",
		"`Catalog`.`bid7`" => "bid7",
		"`Catalog`.`bid8`" => "bid8",
		"`Catalog`.`bid9`" => "bid9",
		"`Catalog`.`bid10`" => "bid10",
		"`Catalog`.`bid11`" => "bid11",
		"`Catalog`.`bid12`" => "bid12",
		"`Catalog`.`Values`" => "Values",
		"`Catalog`.`ValueTxt`" => "ValueTxt",
	];
	// mapping incoming sort by requests to actual query fields
	$x->SortFields = [
		1 => '`Catalog`.`ID`',
		2 => 2,
		3 => 3,
		4 => 4,
		5 => 5,
		6 => '`CatalogTypes1`.`TypeName`',
		7 => '`CatalogGroups1`.`GroupName`',
		8 => 8,
		9 => 9,
		10 => 10,
		11 => 11,
		12 => 12,
		13 => 13,
		14 => 14,
		15 => 15,
		16 => 16,
		17 => 17,
		18 => 18,
		19 => 19,
		20 => 20,
		21 => 21,
		22 => 22,
		23 => 23,
		24 => '`Catalog`.`Values`',
		25 => 25,
	];

	// Fields that can be displayed in the csv file
	$x->QueryFieldsCSV = [
		"`Catalog`.`ID`" => "ID",
		"`Catalog`.`CatalogNo`" => "CatalogNo",
		"`Catalog`.`CatalogTitle`" => "CatalogTitle",
		"`Catalog`.`Description`" => "Description",
		"`Catalog`.`Restrictions`" => "Restrictions",
		"IF(    CHAR_LENGTH(`CatalogTypes1`.`TypeName`), CONCAT_WS('',   `CatalogTypes1`.`TypeName`), '') /* Catalog Type */" => "TypeID",
		"IF(    CHAR_LENGTH(`CatalogGroups1`.`GroupName`), CONCAT_WS('',   `CatalogGroups1`.`GroupName`), '') /* Grouping */" => "GroupID",
		"`Catalog`.`DonorText`" => "DonorText",
		"`Catalog`.`AdditionalInfo`" => "AdditionalInfo",
		"`Catalog`.`CatalogValueText`" => "CatalogValueText",
		"`Catalog`.`Quantity`" => "Quantity",
		"`Catalog`.`bid1`" => "bid1",
		"`Catalog`.`bid2`" => "bid2",
		"`Catalog`.`bid3`" => "bid3",
		"`Catalog`.`bid4`" => "bid4",
		"`Catalog`.`bid5`" => "bid5",
		"`Catalog`.`bid6`" => "bid6",
		"`Catalog`.`bid7`" => "bid7",
		"`Catalog`.`bid8`" => "bid8",
		"`Catalog`.`bid9`" => "bid9",
		"`Catalog`.`bid10`" => "bid10",
		"`Catalog`.`bid11`" => "bid11",
		"`Catalog`.`bid12`" => "bid12",
		"`Catalog`.`Values`" => "Values",
		"`Catalog`.`ValueTxt`" => "ValueTxt",
	];
	// Fields that can be filtered
	$x->QueryFieldsFilters = [
		"`Catalog`.`ID`" => "ID",
		"`Catalog`.`CatalogNo`" => "Catalog No",
		"`Catalog`.`CatalogTitle`" => "Catalog Title",
		"`Catalog`.`Description`" => "Description",
		"`Catalog`.`Restrictions`" => "Restrictions",
		"IF(    CHAR_LENGTH(`CatalogTypes1`.`TypeName`), CONCAT_WS('',   `CatalogTypes1`.`TypeName`), '') /* Catalog Type */" => "Catalog Type",
		"IF(    CHAR_LENGTH(`CatalogGroups1`.`GroupName`), CONCAT_WS('',   `CatalogGroups1`.`GroupName`), '') /* Grouping */" => "Grouping",
		"`Catalog`.`DonorText`" => "Donor Text",
		"`Catalog`.`AdditionalInfo`" => "Additional Info",
		"`Catalog`.`CatalogValueText`" => "Catalog Value Text",
		"`Catalog`.`Quantity`" => "Quantity",
		"`Catalog`.`Values`" => "Total Value",
		"`Catalog`.`ValueTxt`" => "ValueTxt",
	];

	// Fields that can be quick searched
	$x->QueryFieldsQS = [
		"`Catalog`.`ID`" => "ID",
		"`Catalog`.`CatalogNo`" => "CatalogNo",
		"`Catalog`.`CatalogTitle`" => "CatalogTitle",
		"`Catalog`.`Description`" => "Description",
		"`Catalog`.`Restrictions`" => "Restrictions",
		"IF(    CHAR_LENGTH(`CatalogTypes1`.`TypeName`), CONCAT_WS('',   `CatalogTypes1`.`TypeName`), '') /* Catalog Type */" => "TypeID",
		"IF(    CHAR_LENGTH(`CatalogGroups1`.`GroupName`), CONCAT_WS('',   `CatalogGroups1`.`GroupName`), '') /* Grouping */" => "GroupID",
		"`Catalog`.`DonorText`" => "DonorText",
		"`Catalog`.`AdditionalInfo`" => "AdditionalInfo",
		"`Catalog`.`CatalogValueText`" => "CatalogValueText",
		"`Catalog`.`Quantity`" => "Quantity",
		"`Catalog`.`Values`" => "Values",
		"`Catalog`.`ValueTxt`" => "ValueTxt",
	];

	// Lookup fields that can be used as filterers
	$x->filterers = ['TypeID' => 'Catalog Type', 'GroupID' => 'Grouping', ];

	$x->QueryFrom = "`Catalog` LEFT JOIN `CatalogTypes` as CatalogTypes1 ON `CatalogTypes1`.`ID`=`Catalog`.`TypeID` LEFT JOIN `CatalogGroups` as CatalogGroups1 ON `CatalogGroups1`.`ID`=`Catalog`.`GroupID` ";
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
	$x->ScriptFileName = 'Catalog_view.php';
	$x->TableTitle = 'Catalog';
	$x->TableIcon = 'resources/table_icons/32Px - 317.png';
	$x->PrimaryKey = '`Catalog`.`ID`';
	$x->DefaultSortField = '2';
	$x->DefaultSortDirection = 'asc';

	$x->ColWidth = [150, 150, 150, 150, 150, 150, 150, 150, 150, 150, 150, 150, 100, 100, ];
	$x->ColCaption = ['Catalog No', 'Catalog Title', 'Description', 'Restrictions', 'Catalog Type', 'Grouping', 'Donor Text', 'Additional Info', 'Catalog Value Text', 'Quantity', 'Total Value', 'ValueTxt', 'Donations', 'Transactions', ];
	$x->ColFieldName = ['CatalogNo', 'CatalogTitle', 'Description', 'Restrictions', 'TypeID', 'GroupID', 'DonorText', 'AdditionalInfo', 'CatalogValueText', 'Quantity', 'Values', 'ValueTxt', '%Donations.CatalogID%', '%Transactions.CatalogID%', ];
	$x->ColNumber  = [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 24, 25, -1, -1, ];

	// template paths below are based on the app main directory
	$x->Template = 'templates/Catalog_templateTV.html';
	$x->SelectedTemplate = 'templates/Catalog_templateTVS.html';
	$x->TemplateDV = 'templates/Catalog_templateDV.html';
	$x->TemplateDVP = 'templates/Catalog_templateDVP.html';

	$x->ShowTableHeader = 1;
	$x->TVClasses = "";
	$x->DVClasses = "";
	$x->HasCalculatedFields = true;
	$x->AllowConsoleLog = false;
	$x->AllowDVNavigation = true;

	// hook: Catalog_init
	$render = true;
	if(function_exists('Catalog_init')) {
		$args = [];
		$render = Catalog_init($x, getMemberInfo(), $args);
	}

	if($render) $x->Render();

	// hook: Catalog_header
	$headerCode = '';
	if(function_exists('Catalog_header')) {
		$args = [];
		$headerCode = Catalog_header($x->ContentType, getMemberInfo(), $args);
	}

	if(!$headerCode) {
		include_once(__DIR__ . '/header.php'); 
	} else {
		ob_start();
		include_once(__DIR__ . '/header.php');
		echo str_replace('<%%HEADER%%>', ob_get_clean(), $headerCode);
	}

	echo $x->HTML;

	// hook: Catalog_footer
	$footerCode = '';
	if(function_exists('Catalog_footer')) {
		$args = [];
		$footerCode = Catalog_footer($x->ContentType, getMemberInfo(), $args);
	}

	if(!$footerCode) {
		include_once(__DIR__ . '/footer.php'); 
	} else {
		ob_start();
		include_once(__DIR__ . '/footer.php');
		echo str_replace('<%%FOOTER%%>', ob_get_clean(), $footerCode);
	}
