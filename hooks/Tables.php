<?php
	// For help on using hooks, please refer to https://bigprof.com/appgini/help/working-with-generated-web-database-application/hooks

	function Tables_init(&$options, $memberInfo, &$args) {
		/* Inserted by Inline-Detail-View Plugin on 2024-02-01 12:38:37 */
		// DO NOT DELETE THIS LINE
        require_once("plugins/inline-dv/InlineDV.php");
        $options->SeparateDV = 0;
		/* End of Inline-Detail-View Plugin code */


		return TRUE;
	}

	function Tables_header($contentType, $memberInfo, &$args) {
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

	function Tables_footer($contentType, $memberInfo, &$args) {
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

	function Tables_before_insert(&$data, $memberInfo, &$args) {

		return TRUE;
	}

	function Tables_after_insert($data, $memberInfo, &$args) {

		return TRUE;
	}

	function Tables_before_update(&$data, $memberInfo, &$args) {

		return TRUE;
	}

	function Tables_after_update($data, $memberInfo, &$args) {

		return TRUE;
	}

	function Tables_before_delete($selectedID, &$skipChecks, $memberInfo, &$args) {

		return TRUE;
	}

	function Tables_after_delete($selectedID, $memberInfo, &$args) {

	}

	function Tables_dv($selectedID, $memberInfo, &$html, &$args) {
		/* Inserted by Inline-Detail-View Plugin on 2024-02-01 12:38:37 */
		// DO NOT DELETE THIS LINE
        require_once("plugins/inline-dv/InlineDV.php");
        $plugin = new InlineDV("Tables");
        $plugin->render($selectedID, $memberInfo, $html, $args);
		/* End of Inline-Detail-View Plugin code */


	}

	function Tables_csv($query, $memberInfo, &$args) {

		return $query;
	}
	function Tables_batch_actions(&$args) {

		return [];
	}
