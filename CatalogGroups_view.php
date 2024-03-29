<?php
// This script and data application was generated by AppGini, https://bigprof.com/appgini
// Download AppGini for free from https://bigprof.com/appgini/download/

	include_once(__DIR__ . '/lib.php');
	@include_once(__DIR__ . '/hooks/CatalogGroups.php');
	include_once(__DIR__ . '/CatalogGroups_dml.php');

	// mm: can the current member access this page?
	$perm = getTablePermissions('CatalogGroups');
	if(!$perm['access']) {
		echo error_message($Translation['tableAccessDenied']);
		exit;
	}

	$x = new DataList;
	$x->TableName = 'CatalogGroups';

	// Fields that can be displayed in the table view
	$x->QueryFieldsTV = [
		"`CatalogGroups`.`ID`" => "ID",
		"`CatalogGroups`.`GroupName`" => "GroupName",
	];
	// mapping incoming sort by requests to actual query fields
	$x->SortFields = [
		1 => '`CatalogGroups`.`ID`',
		2 => 2,
	];

	// Fields that can be displayed in the csv file
	$x->QueryFieldsCSV = [
		"`CatalogGroups`.`ID`" => "ID",
		"`CatalogGroups`.`GroupName`" => "GroupName",
	];
	// Fields that can be filtered
	$x->QueryFieldsFilters = [
		"`CatalogGroups`.`ID`" => "ID",
		"`CatalogGroups`.`GroupName`" => "Group Name",
	];

	// Fields that can be quick searched
	$x->QueryFieldsQS = [
		"`CatalogGroups`.`ID`" => "ID",
		"`CatalogGroups`.`GroupName`" => "GroupName",
	];

	// Lookup fields that can be used as filterers
	$x->filterers = [];

	$x->QueryFrom = "`CatalogGroups` ";
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
	$x->AllowAdminShowSQL = 0;
	$x->RecordsPerPage = 30;
	$x->QuickSearch = 1;
	$x->QuickSearchText = $Translation['quick search'];
	$x->ScriptFileName = 'CatalogGroups_view.php';
	$x->TableTitle = 'Catalog Groups';
	$x->TableIcon = 'resources/table_icons/32Px - 352.png';
	$x->PrimaryKey = '`CatalogGroups`.`ID`';

	$x->ColWidth = [150, ];
	$x->ColCaption = ['Group Name', ];
	$x->ColFieldName = ['GroupName', ];
	$x->ColNumber  = [2, ];

	// template paths below are based on the app main directory
	$x->Template = 'templates/CatalogGroups_templateTV.html';
	$x->SelectedTemplate = 'templates/CatalogGroups_templateTVS.html';
	$x->TemplateDV = 'templates/CatalogGroups_templateDV.html';
	$x->TemplateDVP = 'templates/CatalogGroups_templateDVP.html';

	$x->ShowTableHeader = 1;
	$x->TVClasses = "";
	$x->DVClasses = "";
	$x->HasCalculatedFields = false;
	$x->AllowConsoleLog = false;
	$x->AllowDVNavigation = true;

	// hook: CatalogGroups_init
	$render = true;
	if(function_exists('CatalogGroups_init')) {
		$args = [];
		$render = CatalogGroups_init($x, getMemberInfo(), $args);
	}

	if($render) $x->Render();

	// hook: CatalogGroups_header
	$headerCode = '';
	if(function_exists('CatalogGroups_header')) {
		$args = [];
		$headerCode = CatalogGroups_header($x->ContentType, getMemberInfo(), $args);
	}

	if(!$headerCode) {
		include_once(__DIR__ . '/header.php'); 
	} else {
		ob_start();
		include_once(__DIR__ . '/header.php');
		echo str_replace('<%%HEADER%%>', ob_get_clean(), $headerCode);
	}

	echo $x->HTML;

	// hook: CatalogGroups_footer
	$footerCode = '';
	if(function_exists('CatalogGroups_footer')) {
		$args = [];
		$footerCode = CatalogGroups_footer($x->ContentType, getMemberInfo(), $args);
	}

	if(!$footerCode) {
		include_once(__DIR__ . '/footer.php'); 
	} else {
		ob_start();
		include_once(__DIR__ . '/footer.php');
		echo str_replace('<%%FOOTER%%>', ob_get_clean(), $footerCode);
	}
