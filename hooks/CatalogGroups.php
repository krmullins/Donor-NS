<?php
	// For help on using hooks, please refer to https://bigprof.com/appgini/help/working-with-generated-web-database-application/hooks

	function CatalogGroups_init(&$options, $memberInfo, &$args) {
		/* Inserted by Inline-Detail-View Plugin on 2024-01-25 03:20:01 */
		// DO NOT DELETE THIS LINE
        require_once("plugins/inline-dv/InlineDV.php");
        $options->SeparateDV = 0;
		/* End of Inline-Detail-View Plugin code */


		return TRUE;
	}

	function CatalogGroups_header($contentType, $memberInfo, &$args) {
		$header='';

		switch($contentType) {
			case 'tableview':
				$header='';
				break;

			case 'detailview':
				$header='';
				break;

			case 'tableview+detailview':
				$header='';
				break;

			case 'print-tableview':
				$header='';
				break;

			case 'print-detailview':
				$header='';
				break;

			case 'filters':
				$header='';
				break;
		}

		return $header;
	}

	function CatalogGroups_footer($contentType, $memberInfo, &$args) {
		$footer='';

		switch($contentType) {
			case 'tableview':
				$footer='';
				break;

			case 'detailview':
				$footer='';
				break;

			case 'tableview+detailview':
				$footer='';
				break;

			case 'print-tableview':
				$footer='';
				break;

			case 'print-detailview':
				$footer='';
				break;

			case 'filters':
				$footer='';
				break;
		}

		return $footer;
	}

	function CatalogGroups_before_insert(&$data, $memberInfo, &$args) {

		return TRUE;
	}

	function CatalogGroups_after_insert($data, $memberInfo, &$args) {

		return TRUE;
	}

	function CatalogGroups_before_update(&$data, $memberInfo, &$args) {

		return TRUE;
	}

	function CatalogGroups_after_update($data, $memberInfo, &$args) {

		return TRUE;
	}

	function CatalogGroups_before_delete($selectedID, &$skipChecks, $memberInfo, &$args) {

		return TRUE;
	}

	function CatalogGroups_after_delete($selectedID, $memberInfo, &$args) {

	}

	function CatalogGroups_dv($selectedID, $memberInfo, &$html, &$args) {
		/* Inserted by Inline-Detail-View Plugin on 2024-01-25 03:20:01 */
		// DO NOT DELETE THIS LINE
        require_once("plugins/inline-dv/InlineDV.php");
        $plugin = new InlineDV("CatalogGroups");
        $plugin->render($selectedID, $memberInfo, $html, $args);
		/* End of Inline-Detail-View Plugin code */


	}

	function CatalogGroups_csv($query, $memberInfo, &$args) {

		return $query;
	}
	function CatalogGroups_batch_actions(&$args) {

		return [];
	}
