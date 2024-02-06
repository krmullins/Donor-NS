<?php
// This script and data application was generated by AppGini, https://bigprof.com/appgini
// Download AppGini for free from https://bigprof.com/appgini/download/

	include_once(__DIR__ . '/lib.php');
	@include_once(__DIR__ . '/hooks/CatalogTypes.php');
	include_once(__DIR__ . '/CatalogTypes_dml.php');

	// mm: can the current member access this page?
	$perm = getTablePermissions('CatalogTypes');
	if(!$perm['access']) {
		echo error_message($Translation['tableAccessDenied']);
		exit;
	}

	$x = new DataList;
	$x->TableName = 'CatalogTypes';

	// Fields that can be displayed in the table view
	$x->QueryFieldsTV = [
		"`CatalogTypes`.`ID`" => "ID",
		"`CatalogTypes`.`TypeName`" => "TypeName",
	];
	// mapping incoming sort by requests to actual query fields
	$x->SortFields = [
		1 => '`CatalogTypes`.`ID`',
		2 => 2,
	];

	// Fields that can be displayed in the csv file
	$x->QueryFieldsCSV = [
		"`CatalogTypes`.`ID`" => "ID",
		"`CatalogTypes`.`TypeName`" => "TypeName",
	];
	// Fields that can be filtered
	$x->QueryFieldsFilters = [
		"`CatalogTypes`.`ID`" => "ID",
		"`CatalogTypes`.`TypeName`" => "Type Name",
	];

	// Fields that can be quick searched
	$x->QueryFieldsQS = [
		"`CatalogTypes`.`ID`" => "ID",
		"`CatalogTypes`.`TypeName`" => "TypeName",
	];

	// Lookup fields that can be used as filterers
	$x->filterers = [];

	$x->QueryFrom = "`CatalogTypes` ";
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
	$x->RecordsPerPage = 30;
	$x->QuickSearch = 1;
	$x->QuickSearchText = $Translation['quick search'];
	$x->ScriptFileName = 'CatalogTypes_view.php';
	$x->TableTitle = 'Catalog Types';
	$x->TableIcon = 'resources/table_icons/32Px - 352.png';
	$x->PrimaryKey = '`CatalogTypes`.`ID`';

	$x->ColWidth = [150, ];
	$x->ColCaption = ['Type Name', ];
	$x->ColFieldName = ['TypeName', ];
	$x->ColNumber  = [2, ];

	// template paths below are based on the app main directory
	$x->Template = 'templates/CatalogTypes_templateTV.html';
	$x->SelectedTemplate = 'templates/CatalogTypes_templateTVS.html';
	$x->TemplateDV = 'templates/CatalogTypes_templateDV.html';
	$x->TemplateDVP = 'templates/CatalogTypes_templateDVP.html';

	$x->ShowTableHeader = 1;
	$x->TVClasses = "";
	$x->DVClasses = "";
	$x->HasCalculatedFields = false;
	$x->AllowConsoleLog = false;
	$x->AllowDVNavigation = true;

	// hook: CatalogTypes_init
	$render = true;
	if(function_exists('CatalogTypes_init')) {
		$args = [];
		$render = CatalogTypes_init($x, getMemberInfo(), $args);
	}

	if($render) $x->Render();

	// hook: CatalogTypes_header
	$headerCode = '';
	if(function_exists('CatalogTypes_header')) {
		$args = [];
		$headerCode = CatalogTypes_header($x->ContentType, getMemberInfo(), $args);
	}

	if(!$headerCode) {
		include_once(__DIR__ . '/header.php'); 
	} else {
		ob_start();
		include_once(__DIR__ . '/header.php');
		echo str_replace('<%%HEADER%%>', ob_get_clean(), $headerCode);
	}

	echo $x->HTML;

	// hook: CatalogTypes_footer
	$footerCode = '';
	if(function_exists('CatalogTypes_footer')) {
		$args = [];
		$footerCode = CatalogTypes_footer($x->ContentType, getMemberInfo(), $args);
	}

	if(!$footerCode) {
		include_once(__DIR__ . '/footer.php'); 
	} else {
		ob_start();
		include_once(__DIR__ . '/footer.php');
		echo str_replace('<%%FOOTER%%>', ob_get_clean(), $footerCode);
	}
