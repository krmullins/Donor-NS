<?php

// Data functions (insert, update, delete, form) for table Tickets

// This script and data application was generated by AppGini, https://bigprof.com/appgini
// Download AppGini for free from https://bigprof.com/appgini/download/

function Tickets_insert(&$error_message = '') {
	global $Translation;

	// mm: can member insert record?
	$arrPerm = getTablePermissions('Tickets');
	if(!$arrPerm['insert']) return false;

	$data = [
		'UsersName' => Request::val('UsersName', ''),
		'BidderID' => Request::lookup('BidderID', ''),
		'TablePreference' => Request::lookup('BidderID'),
		'TableID' => Request::lookup('TableID', ''),
		'TableName' => Request::lookup('TableID'),
		'SeatingPosition' => Request::val('SeatingPosition', ''),
	];


	// hook: Tickets_before_insert
	if(function_exists('Tickets_before_insert')) {
		$args = [];
		if(!Tickets_before_insert($data, getMemberInfo(), $args)) {
			if(isset($args['error_message'])) $error_message = $args['error_message'];
			return false;
		}
	}

	$error = '';
	// set empty fields to NULL
	$data = array_map(function($v) { return ($v === '' ? NULL : $v); }, $data);
	insert('Tickets', backtick_keys_once($data), $error);
	if($error) {
		$error_message = $error;
		return false;
	}

	$recID = db_insert_id(db_link());

	update_calc_fields('Tickets', $recID, calculated_fields()['Tickets']);

	// hook: Tickets_after_insert
	if(function_exists('Tickets_after_insert')) {
		$res = sql("SELECT * FROM `Tickets` WHERE `ID`='" . makeSafe($recID, false) . "' LIMIT 1", $eo);
		if($row = db_fetch_assoc($res)) {
			$data = array_map('makeSafe', $row);
		}
		$data['selectedID'] = makeSafe($recID, false);
		$args = [];
		if(!Tickets_after_insert($data, getMemberInfo(), $args)) { return $recID; }
	}

	// mm: save ownership data
	// record owner is current user
	$recordOwner = getLoggedMemberID();
	set_record_owner('Tickets', $recID, $recordOwner);

	// if this record is a copy of another record, copy children if applicable
	if(strlen(Request::val('SelectedID'))) Tickets_copy_children($recID, Request::val('SelectedID'));

	return $recID;
}

function Tickets_copy_children($destination_id, $source_id) {
	global $Translation;
	$requests = []; // array of curl handlers for launching insert requests
	$eo = ['silentErrors' => true];
	$safe_sid = makeSafe($source_id);

	// launch requests, asynchronously
	curl_batch($requests);
}

function Tickets_delete($selected_id, $AllowDeleteOfParents = false, $skipChecks = false) {
	// insure referential integrity ...
	global $Translation;
	$selected_id = makeSafe($selected_id);

	// mm: can member delete record?
	if(!check_record_permission('Tickets', $selected_id, 'delete')) {
		return $Translation['You don\'t have enough permissions to delete this record'];
	}

	// hook: Tickets_before_delete
	if(function_exists('Tickets_before_delete')) {
		$args = [];
		if(!Tickets_before_delete($selected_id, $skipChecks, getMemberInfo(), $args))
			return $Translation['Couldn\'t delete this record'] . (
				!empty($args['error_message']) ?
					'<div class="text-bold">' . strip_tags($args['error_message']) . '</div>'
					: '' 
			);
	}

	sql("DELETE FROM `Tickets` WHERE `ID`='{$selected_id}'", $eo);

	// hook: Tickets_after_delete
	if(function_exists('Tickets_after_delete')) {
		$args = [];
		Tickets_after_delete($selected_id, getMemberInfo(), $args);
	}

	// mm: delete ownership data
	sql("DELETE FROM `membership_userrecords` WHERE `tableName`='Tickets' AND `pkValue`='{$selected_id}'", $eo);
}

function Tickets_update(&$selected_id, &$error_message = '') {
	global $Translation;

	// mm: can member edit record?
	if(!check_record_permission('Tickets', $selected_id, 'edit')) return false;

	$data = [
		'UsersName' => Request::val('UsersName', ''),
		'BidderID' => Request::lookup('BidderID', ''),
		'TablePreference' => Request::lookup('BidderID'),
		'TableID' => Request::lookup('TableID', ''),
		'TableName' => Request::lookup('TableID'),
		'SeatingPosition' => Request::val('SeatingPosition', ''),
	];

	// get existing values
	$old_data = getRecord('Tickets', $selected_id);
	if(is_array($old_data)) {
		$old_data = array_map('makeSafe', $old_data);
		$old_data['selectedID'] = makeSafe($selected_id);
	}

	$data['selectedID'] = makeSafe($selected_id);

	// hook: Tickets_before_update
	if(function_exists('Tickets_before_update')) {
		$args = ['old_data' => $old_data];
		if(!Tickets_before_update($data, getMemberInfo(), $args)) {
			if(isset($args['error_message'])) $error_message = $args['error_message'];
			return false;
		}
	}

	$set = $data; unset($set['selectedID']);
	foreach ($set as $field => $value) {
		$set[$field] = ($value !== '' && $value !== NULL) ? $value : NULL;
	}

	if(!update(
		'Tickets', 
		backtick_keys_once($set), 
		['`ID`' => $selected_id], 
		$error_message
	)) {
		echo $error_message;
		echo '<a href="Tickets_view.php?SelectedID=' . urlencode($selected_id) . "\">{$Translation['< back']}</a>";
		exit;
	}


	$eo = ['silentErrors' => true];

	update_calc_fields('Tickets', $data['selectedID'], calculated_fields()['Tickets']);

	// hook: Tickets_after_update
	if(function_exists('Tickets_after_update')) {
		$res = sql("SELECT * FROM `Tickets` WHERE `ID`='{$data['selectedID']}' LIMIT 1", $eo);
		if($row = db_fetch_assoc($res)) $data = array_map('makeSafe', $row);

		$data['selectedID'] = $data['ID'];
		$args = ['old_data' => $old_data];
		if(!Tickets_after_update($data, getMemberInfo(), $args)) return;
	}

	// mm: update record update timestamp
	set_record_owner('Tickets', $selected_id);
}

function Tickets_form($selected_id = '', $AllowUpdate = 1, $AllowInsert = 1, $AllowDelete = 1, $separateDV = 0, $TemplateDV = '', $TemplateDVP = '') {
	// function to return an editable form for a table records
	// and fill it with data of record whose ID is $selected_id. If $selected_id
	// is empty, an empty form is shown, with only an 'Add New'
	// button displayed.

	global $Translation;
	$eo = ['silentErrors' => true];
	$noUploads = null;
	$row = $urow = $jsReadOnly = $jsEditable = $lookups = null;

	$noSaveAsCopy = false;

	// mm: get table permissions
	$arrPerm = getTablePermissions('Tickets');
	if(!$arrPerm['insert'] && $selected_id == '')
		// no insert permission and no record selected
		// so show access denied error unless TVDV
		return $separateDV ? $Translation['tableAccessDenied'] : '';
	$AllowInsert = ($arrPerm['insert'] ? true : false);
	// print preview?
	$dvprint = false;
	if(strlen($selected_id) && Request::val('dvprint_x') != '') {
		$dvprint = true;
	}

	$filterer_BidderID = Request::val('filterer_BidderID');
	$filterer_TableID = Request::val('filterer_TableID');

	// populate filterers, starting from children to grand-parents

	// unique random identifier
	$rnd1 = ($dvprint ? rand(1000000, 9999999) : '');
	// combobox: BidderID
	$combo_BidderID = new DataCombo;
	// combobox: TableID
	$combo_TableID = new DataCombo;
	// combobox: SeatingPosition
	$combo_SeatingPosition = new Combo;
	$combo_SeatingPosition->ListType = 0;
	$combo_SeatingPosition->MultipleSeparator = ', ';
	$combo_SeatingPosition->ListBoxHeight = 10;
	$combo_SeatingPosition->RadiosPerLine = 1;
	if(is_file(__DIR__ . '/hooks/Tickets.SeatingPosition.csv')) {
		$SeatingPosition_data = addslashes(implode('', @file(__DIR__ . '/hooks/Tickets.SeatingPosition.csv')));
		$combo_SeatingPosition->ListItem = array_trim(explode('||', entitiesToUTF8(convertLegacyOptions($SeatingPosition_data))));
		$combo_SeatingPosition->ListData = $combo_SeatingPosition->ListItem;
	} else {
		$combo_SeatingPosition->ListItem = array_trim(explode('||', entitiesToUTF8(convertLegacyOptions("1;;2;;3;;4;;5;;6;;7;;8;;9;;10"))));
		$combo_SeatingPosition->ListData = $combo_SeatingPosition->ListItem;
	}
	$combo_SeatingPosition->SelectName = 'SeatingPosition';

	if($selected_id) {
		if(!check_record_permission('Tickets', $selected_id, 'view'))
			return $Translation['tableAccessDenied'];

		// can edit?
		$AllowUpdate = check_record_permission('Tickets', $selected_id, 'edit');

		// can delete?
		$AllowDelete = check_record_permission('Tickets', $selected_id, 'delete');

		$res = sql("SELECT * FROM `Tickets` WHERE `ID`='" . makeSafe($selected_id) . "'", $eo);
		if(!($row = db_fetch_array($res))) {
			return error_message($Translation['No records found'], 'Tickets_view.php', false);
		}
		$combo_BidderID->SelectedData = $row['BidderID'];
		$combo_TableID->SelectedData = $row['TableID'];
		$combo_SeatingPosition->SelectedData = $row['SeatingPosition'];
		$urow = $row; /* unsanitized data */
		$row = array_map('safe_html', $row);
	} else {
		$filterField = Request::val('FilterField');
		$filterOperator = Request::val('FilterOperator');
		$filterValue = Request::val('FilterValue');
		$combo_BidderID->SelectedData = $filterer_BidderID;
		$combo_TableID->SelectedData = $filterer_TableID;
		$combo_SeatingPosition->SelectedText = (isset($filterField[1]) && $filterField[1] == '7' && $filterOperator[1] == '<=>' ? $filterValue[1] : '');
	}
	$combo_BidderID->HTML = '<span id="BidderID-container' . $rnd1 . '"></span><input type="hidden" name="BidderID" id="BidderID' . $rnd1 . '" value="' . html_attr($combo_BidderID->SelectedData) . '">';
	$combo_BidderID->MatchText = '<span id="BidderID-container-readonly' . $rnd1 . '"></span><input type="hidden" name="BidderID" id="BidderID' . $rnd1 . '" value="' . html_attr($combo_BidderID->SelectedData) . '">';
	$combo_TableID->HTML = '<span id="TableID-container' . $rnd1 . '"></span><input type="hidden" name="TableID" id="TableID' . $rnd1 . '" value="' . html_attr($combo_TableID->SelectedData) . '">';
	$combo_TableID->MatchText = '<span id="TableID-container-readonly' . $rnd1 . '"></span><input type="hidden" name="TableID" id="TableID' . $rnd1 . '" value="' . html_attr($combo_TableID->SelectedData) . '">';
	$combo_SeatingPosition->Render();

	ob_start();
	?>

	<script>
		// initial lookup values
		AppGini.current_BidderID__RAND__ = { text: "", value: "<?php echo addslashes($selected_id ? $urow['BidderID'] : htmlspecialchars($filterer_BidderID, ENT_QUOTES)); ?>"};
		AppGini.current_TableID__RAND__ = { text: "", value: "<?php echo addslashes($selected_id ? $urow['TableID'] : htmlspecialchars($filterer_TableID, ENT_QUOTES)); ?>"};

		jQuery(function() {
			setTimeout(function() {
				if(typeof(BidderID_reload__RAND__) == 'function') BidderID_reload__RAND__();
				if(typeof(TableID_reload__RAND__) == 'function') TableID_reload__RAND__();
			}, 50); /* we need to slightly delay client-side execution of the above code to allow AppGini.ajaxCache to work */
		});
		function BidderID_reload__RAND__() {
		<?php if(($AllowUpdate || $AllowInsert) && !$dvprint) { ?>

			$j("#BidderID-container__RAND__").select2({
				/* initial default value */
				initSelection: function(e, c) {
					$j.ajax({
						url: 'ajax_combo.php',
						dataType: 'json',
						data: { id: AppGini.current_BidderID__RAND__.value, t: 'Tickets', f: 'BidderID' },
						success: function(resp) {
							c({
								id: resp.results[0].id,
								text: resp.results[0].text
							});
							$j('[name="BidderID"]').val(resp.results[0].id);
							$j('[id=BidderID-container-readonly__RAND__]').html('<span class="match-text" id="BidderID-match-text">' + resp.results[0].text + '</span>');
							if(resp.results[0].id == '<?php echo empty_lookup_value; ?>') { $j('.btn[id=Bidders_view_parent]').hide(); } else { $j('.btn[id=Bidders_view_parent]').show(); }


							if(typeof(BidderID_update_autofills__RAND__) == 'function') BidderID_update_autofills__RAND__();
						}
					});
				},
				width: '100%',
				formatNoMatches: function(term) { return '<?php echo addslashes($Translation['No matches found!']); ?>'; },
				minimumResultsForSearch: 5,
				loadMorePadding: 200,
				ajax: {
					url: 'ajax_combo.php',
					dataType: 'json',
					cache: true,
					data: function(term, page) { return { s: term, p: page, t: 'Tickets', f: 'BidderID' }; },
					results: function(resp, page) { return resp; }
				},
				escapeMarkup: function(str) { return str; }
			}).on('change', function(e) {
				AppGini.current_BidderID__RAND__.value = e.added.id;
				AppGini.current_BidderID__RAND__.text = e.added.text;
				$j('[name="BidderID"]').val(e.added.id);
				if(e.added.id == '<?php echo empty_lookup_value; ?>') { $j('.btn[id=Bidders_view_parent]').hide(); } else { $j('.btn[id=Bidders_view_parent]').show(); }


				if(typeof(BidderID_update_autofills__RAND__) == 'function') BidderID_update_autofills__RAND__();
			});

			if(!$j("#BidderID-container__RAND__").length) {
				$j.ajax({
					url: 'ajax_combo.php',
					dataType: 'json',
					data: { id: AppGini.current_BidderID__RAND__.value, t: 'Tickets', f: 'BidderID' },
					success: function(resp) {
						$j('[name="BidderID"]').val(resp.results[0].id);
						$j('[id=BidderID-container-readonly__RAND__]').html('<span class="match-text" id="BidderID-match-text">' + resp.results[0].text + '</span>');
						if(resp.results[0].id == '<?php echo empty_lookup_value; ?>') { $j('.btn[id=Bidders_view_parent]').hide(); } else { $j('.btn[id=Bidders_view_parent]').show(); }

						if(typeof(BidderID_update_autofills__RAND__) == 'function') BidderID_update_autofills__RAND__();
					}
				});
			}

		<?php } else { ?>

			$j.ajax({
				url: 'ajax_combo.php',
				dataType: 'json',
				data: { id: AppGini.current_BidderID__RAND__.value, t: 'Tickets', f: 'BidderID' },
				success: function(resp) {
					$j('[id=BidderID-container__RAND__], [id=BidderID-container-readonly__RAND__]').html('<span class="match-text" id="BidderID-match-text">' + resp.results[0].text + '</span>');
					if(resp.results[0].id == '<?php echo empty_lookup_value; ?>') { $j('.btn[id=Bidders_view_parent]').hide(); } else { $j('.btn[id=Bidders_view_parent]').show(); }

					if(typeof(BidderID_update_autofills__RAND__) == 'function') BidderID_update_autofills__RAND__();
				}
			});
		<?php } ?>

		}
		function TableID_reload__RAND__() {
		<?php if(($AllowUpdate || $AllowInsert) && !$dvprint) { ?>

			$j("#TableID-container__RAND__").select2({
				/* initial default value */
				initSelection: function(e, c) {
					$j.ajax({
						url: 'ajax_combo.php',
						dataType: 'json',
						data: { id: AppGini.current_TableID__RAND__.value, t: 'Tickets', f: 'TableID' },
						success: function(resp) {
							c({
								id: resp.results[0].id,
								text: resp.results[0].text
							});
							$j('[name="TableID"]').val(resp.results[0].id);
							$j('[id=TableID-container-readonly__RAND__]').html('<span class="match-text" id="TableID-match-text">' + resp.results[0].text + '</span>');
							if(resp.results[0].id == '<?php echo empty_lookup_value; ?>') { $j('.btn[id=Tables_view_parent]').hide(); } else { $j('.btn[id=Tables_view_parent]').show(); }


							if(typeof(TableID_update_autofills__RAND__) == 'function') TableID_update_autofills__RAND__();
						}
					});
				},
				width: '100%',
				formatNoMatches: function(term) { return '<?php echo addslashes($Translation['No matches found!']); ?>'; },
				minimumResultsForSearch: 5,
				loadMorePadding: 200,
				ajax: {
					url: 'ajax_combo.php',
					dataType: 'json',
					cache: true,
					data: function(term, page) { return { s: term, p: page, t: 'Tickets', f: 'TableID' }; },
					results: function(resp, page) { return resp; }
				},
				escapeMarkup: function(str) { return str; }
			}).on('change', function(e) {
				AppGini.current_TableID__RAND__.value = e.added.id;
				AppGini.current_TableID__RAND__.text = e.added.text;
				$j('[name="TableID"]').val(e.added.id);
				if(e.added.id == '<?php echo empty_lookup_value; ?>') { $j('.btn[id=Tables_view_parent]').hide(); } else { $j('.btn[id=Tables_view_parent]').show(); }


				if(typeof(TableID_update_autofills__RAND__) == 'function') TableID_update_autofills__RAND__();
			});

			if(!$j("#TableID-container__RAND__").length) {
				$j.ajax({
					url: 'ajax_combo.php',
					dataType: 'json',
					data: { id: AppGini.current_TableID__RAND__.value, t: 'Tickets', f: 'TableID' },
					success: function(resp) {
						$j('[name="TableID"]').val(resp.results[0].id);
						$j('[id=TableID-container-readonly__RAND__]').html('<span class="match-text" id="TableID-match-text">' + resp.results[0].text + '</span>');
						if(resp.results[0].id == '<?php echo empty_lookup_value; ?>') { $j('.btn[id=Tables_view_parent]').hide(); } else { $j('.btn[id=Tables_view_parent]').show(); }

						if(typeof(TableID_update_autofills__RAND__) == 'function') TableID_update_autofills__RAND__();
					}
				});
			}

		<?php } else { ?>

			$j.ajax({
				url: 'ajax_combo.php',
				dataType: 'json',
				data: { id: AppGini.current_TableID__RAND__.value, t: 'Tickets', f: 'TableID' },
				success: function(resp) {
					$j('[id=TableID-container__RAND__], [id=TableID-container-readonly__RAND__]').html('<span class="match-text" id="TableID-match-text">' + resp.results[0].text + '</span>');
					if(resp.results[0].id == '<?php echo empty_lookup_value; ?>') { $j('.btn[id=Tables_view_parent]').hide(); } else { $j('.btn[id=Tables_view_parent]').show(); }

					if(typeof(TableID_update_autofills__RAND__) == 'function') TableID_update_autofills__RAND__();
				}
			});
		<?php } ?>

		}
	</script>
	<?php

	$lookups = str_replace('__RAND__', $rnd1, ob_get_clean());


	// code for template based detail view forms

	// open the detail view template
	if($dvprint) {
		$template_file = is_file("./{$TemplateDVP}") ? "./{$TemplateDVP}" : './templates/Tickets_templateDVP.html';
		$templateCode = @file_get_contents($template_file);
	} else {
		$template_file = is_file("./{$TemplateDV}") ? "./{$TemplateDV}" : './templates/Tickets_templateDV.html';
		$templateCode = @file_get_contents($template_file);
	}

	// process form title
	$templateCode = str_replace('<%%DETAIL_VIEW_TITLE%%>', 'Ticket details', $templateCode);
	$templateCode = str_replace('<%%RND1%%>', $rnd1, $templateCode);
	$templateCode = str_replace('<%%EMBEDDED%%>', (Request::val('Embedded') ? 'Embedded=1' : ''), $templateCode);
	// process buttons
	if($AllowInsert) {
		if(!$selected_id) $templateCode = str_replace('<%%INSERT_BUTTON%%>', '<button type="submit" class="btn btn-success" id="insert" name="insert_x" value="1" onclick="return Tickets_validateData();"><i class="glyphicon glyphicon-plus-sign"></i> ' . $Translation['Save New'] . '</button>', $templateCode);
		$templateCode = str_replace('<%%INSERT_BUTTON%%>', '<button type="submit" class="btn btn-default" id="insert" name="insert_x" value="1" onclick="return Tickets_validateData();"><i class="glyphicon glyphicon-plus-sign"></i> ' . $Translation['Save As Copy'] . '</button>', $templateCode);
	} else {
		$templateCode = str_replace('<%%INSERT_BUTTON%%>', '', $templateCode);
	}

	// 'Back' button action
	if(Request::val('Embedded')) {
		$backAction = 'AppGini.closeParentModal(); return false;';
	} else {
		$backAction = '$j(\'form\').eq(0).attr(\'novalidate\', \'novalidate\'); document.myform.reset(); return true;';
	}

	if($selected_id) {
		if(!Request::val('Embedded')) $templateCode = str_replace('<%%DVPRINT_BUTTON%%>', '<button type="submit" class="btn btn-default" id="dvprint" name="dvprint_x" value="1" onclick="$j(\'form\').eq(0).prop(\'novalidate\', true); document.myform.reset(); return true;" title="' . html_attr($Translation['Print Preview']) . '"><i class="glyphicon glyphicon-print"></i> ' . $Translation['Print Preview'] . '</button>', $templateCode);
		if($AllowUpdate)
			$templateCode = str_replace('<%%UPDATE_BUTTON%%>', '<button type="submit" class="btn btn-success btn-lg" id="update" name="update_x" value="1" onclick="return Tickets_validateData();" title="' . html_attr($Translation['Save Changes']) . '"><i class="glyphicon glyphicon-ok"></i> ' . $Translation['Save Changes'] . '</button>', $templateCode);
		else
			$templateCode = str_replace('<%%UPDATE_BUTTON%%>', '', $templateCode);

		if($AllowDelete)
			$templateCode = str_replace('<%%DELETE_BUTTON%%>', '<button type="submit" class="btn btn-danger" id="delete" name="delete_x" value="1" title="' . html_attr($Translation['Delete']) . '"><i class="glyphicon glyphicon-trash"></i> ' . $Translation['Delete'] . '</button>', $templateCode);
		else
			$templateCode = str_replace('<%%DELETE_BUTTON%%>', '', $templateCode);

		$templateCode = str_replace('<%%DESELECT_BUTTON%%>', '<button type="submit" class="btn btn-default" id="deselect" name="deselect_x" value="1" onclick="' . $backAction . '" title="' . html_attr($Translation['Back']) . '"><i class="glyphicon glyphicon-chevron-left"></i> ' . $Translation['Back'] . '</button>', $templateCode);
	} else {
		$templateCode = str_replace('<%%UPDATE_BUTTON%%>', '', $templateCode);
		$templateCode = str_replace('<%%DELETE_BUTTON%%>', '', $templateCode);

		// if not in embedded mode and user has insert only but no view/update/delete,
		// remove 'back' button
		if(
			$arrPerm['insert']
			&& !$arrPerm['update'] && !$arrPerm['delete'] && !$arrPerm['view']
			&& !Request::val('Embedded')
		)
			$templateCode = str_replace('<%%DESELECT_BUTTON%%>', '', $templateCode);
		elseif($separateDV)
			$templateCode = str_replace(
				'<%%DESELECT_BUTTON%%>', 
				'<button
					type="submit" 
					class="btn btn-default" 
					id="deselect" 
					name="deselect_x" 
					value="1" 
					onclick="' . $backAction . '" 
					title="' . html_attr($Translation['Back']) . '">
						<i class="glyphicon glyphicon-chevron-left"></i> ' .
						$Translation['Back'] .
				'</button>',
				$templateCode
			);
		else
			$templateCode = str_replace('<%%DESELECT_BUTTON%%>', '', $templateCode);
	}

	// set records to read only if user can't insert new records and can't edit current record
	if(($selected_id && !$AllowUpdate && !$AllowInsert) || (!$selected_id && !$AllowInsert)) {
		$jsReadOnly = '';
		$jsReadOnly .= "\tjQuery('#UsersName').replaceWith('<div class=\"form-control-static\" id=\"UsersName\">' + (jQuery('#UsersName').val() || '') + '</div>');\n";
		$jsReadOnly .= "\tjQuery('#BidderID').prop('disabled', true).css({ color: '#555', backgroundColor: '#fff' });\n";
		$jsReadOnly .= "\tjQuery('#BidderID_caption').prop('disabled', true).css({ color: '#555', backgroundColor: 'white' });\n";
		$jsReadOnly .= "\tjQuery('#TableID').prop('disabled', true).css({ color: '#555', backgroundColor: '#fff' });\n";
		$jsReadOnly .= "\tjQuery('#TableID_caption').prop('disabled', true).css({ color: '#555', backgroundColor: 'white' });\n";
		$jsReadOnly .= "\tjQuery('#SeatingPosition').replaceWith('<div class=\"form-control-static\" id=\"SeatingPosition\">' + (jQuery('#SeatingPosition').val() || '') + '</div>'); jQuery('#SeatingPosition-multi-selection-help').hide();\n";
		$jsReadOnly .= "\tjQuery('.select2-container').hide();\n";

		$noUploads = true;
	} elseif($AllowInsert) {
		$jsEditable = "\tjQuery('form').eq(0).data('already_changed', true);"; // temporarily disable form change handler
		$jsEditable .= "\tjQuery('form').eq(0).data('already_changed', false);"; // re-enable form change handler
	}

	// process combos
	$templateCode = str_replace('<%%COMBO(BidderID)%%>', $combo_BidderID->HTML, $templateCode);
	$templateCode = str_replace('<%%COMBOTEXT(BidderID)%%>', $combo_BidderID->MatchText, $templateCode);
	$templateCode = str_replace('<%%URLCOMBOTEXT(BidderID)%%>', urlencode($combo_BidderID->MatchText), $templateCode);
	$templateCode = str_replace('<%%COMBO(TableID)%%>', $combo_TableID->HTML, $templateCode);
	$templateCode = str_replace('<%%COMBOTEXT(TableID)%%>', $combo_TableID->MatchText, $templateCode);
	$templateCode = str_replace('<%%URLCOMBOTEXT(TableID)%%>', urlencode($combo_TableID->MatchText), $templateCode);
	$templateCode = str_replace('<%%COMBO(SeatingPosition)%%>', $combo_SeatingPosition->HTML, $templateCode);
	$templateCode = str_replace('<%%COMBOTEXT(SeatingPosition)%%>', $combo_SeatingPosition->SelectedData, $templateCode);

	/* lookup fields array: 'lookup field name' => ['parent table name', 'lookup field caption'] */
	$lookup_fields = ['BidderID' => ['Bidders', 'Bidder Number'], 'TableID' => ['Tables', 'Table'], ];
	foreach($lookup_fields as $luf => $ptfc) {
		$pt_perm = getTablePermissions($ptfc[0]);

		// process foreign key links
		if($pt_perm['view'] || $pt_perm['edit']) {
			$templateCode = str_replace("<%%PLINK({$luf})%%>", '<button type="button" class="btn btn-default view_parent" id="' . $ptfc[0] . '_view_parent" title="' . html_attr($Translation['View'] . ' ' . $ptfc[1]) . '"><i class="glyphicon glyphicon-eye-open"></i></button>', $templateCode);
		}

		// if user has insert permission to parent table of a lookup field, put an add new button
		if($pt_perm['insert'] /* && !Request::val('Embedded')*/) {
			$templateCode = str_replace("<%%ADDNEW({$ptfc[0]})%%>", '<button type="button" class="btn btn-default add_new_parent" id="' . $ptfc[0] . '_add_new" title="' . html_attr($Translation['Add New'] . ' ' . $ptfc[1]) . '"><i class="glyphicon glyphicon-plus text-success"></i></button>', $templateCode);
		}
	}

	// process images
	$templateCode = str_replace('<%%UPLOADFILE(ID)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(UsersName)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(BidderID)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(TableID)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(SeatingPosition)%%>', '', $templateCode);

	// process values
	if($selected_id) {
		if( $dvprint) $templateCode = str_replace('<%%VALUE(ID)%%>', safe_html($urow['ID']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(ID)%%>', html_attr($row['ID']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(ID)%%>', urlencode($urow['ID']), $templateCode);
		if( $dvprint) $templateCode = str_replace('<%%VALUE(UsersName)%%>', safe_html($urow['UsersName']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(UsersName)%%>', html_attr($row['UsersName']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(UsersName)%%>', urlencode($urow['UsersName']), $templateCode);
		if( $dvprint) $templateCode = str_replace('<%%VALUE(BidderID)%%>', safe_html($urow['BidderID']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(BidderID)%%>', html_attr($row['BidderID']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(BidderID)%%>', urlencode($urow['BidderID']), $templateCode);
		if( $dvprint) $templateCode = str_replace('<%%VALUE(TableID)%%>', safe_html($urow['TableID']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(TableID)%%>', html_attr($row['TableID']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(TableID)%%>', urlencode($urow['TableID']), $templateCode);
		if( $dvprint) $templateCode = str_replace('<%%VALUE(SeatingPosition)%%>', safe_html($urow['SeatingPosition']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(SeatingPosition)%%>', html_attr($row['SeatingPosition']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(SeatingPosition)%%>', urlencode($urow['SeatingPosition']), $templateCode);
	} else {
		$templateCode = str_replace('<%%VALUE(ID)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(ID)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%VALUE(UsersName)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(UsersName)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%VALUE(BidderID)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(BidderID)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%VALUE(TableID)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(TableID)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%VALUE(SeatingPosition)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(SeatingPosition)%%>', urlencode(''), $templateCode);
	}

	// process translations
	$templateCode = parseTemplate($templateCode);

	// clear scrap
	$templateCode = str_replace('<%%', '<!-- ', $templateCode);
	$templateCode = str_replace('%%>', ' -->', $templateCode);

	// hide links to inaccessible tables
	if(Request::val('dvprint_x') == '') {
		$templateCode .= "\n\n<script>\$j(function() {\n";
		$arrTables = getTableList();
		foreach($arrTables as $name => $caption) {
			$templateCode .= "\t\$j('#{$name}_link').removeClass('hidden');\n";
			$templateCode .= "\t\$j('#xs_{$name}_link').removeClass('hidden');\n";
		}

		$templateCode .= $jsReadOnly;
		$templateCode .= $jsEditable;

		if(!$selected_id) {
		}

		$templateCode.="\n});</script>\n";
	}

	// ajaxed auto-fill fields
	$templateCode .= '<script>';
	$templateCode .= '$j(function() {';

	$templateCode .= "\tBidderID_update_autofills$rnd1 = function() {\n";
	$templateCode .= "\t\t\$j.ajax({\n";
	if($dvprint) {
		$templateCode .= "\t\t\turl: 'Tickets_autofill.php?rnd1=$rnd1&mfk=BidderID&id=' + encodeURIComponent('".addslashes($row['BidderID'])."'),\n";
		$templateCode .= "\t\t\tcontentType: 'application/x-www-form-urlencoded; charset=" . datalist_db_encoding . "',\n";
		$templateCode .= "\t\t\ttype: 'GET'\n";
	} else {
		$templateCode .= "\t\t\turl: 'Tickets_autofill.php?rnd1=$rnd1&mfk=BidderID&id=' + encodeURIComponent(AppGini.current_BidderID{$rnd1}.value),\n";
		$templateCode .= "\t\t\tcontentType: 'application/x-www-form-urlencoded; charset=" . datalist_db_encoding . "',\n";
		$templateCode .= "\t\t\ttype: 'GET',\n";
		$templateCode .= "\t\t\tbeforeSend: function() { \$j('#BidderID$rnd1').prop('disabled', true); },\n";
		$templateCode .= "\t\t\tcomplete: function() { " . (($arrPerm['insert'] || (($arrPerm['edit'] == 1 && $ownerMemberID == getLoggedMemberID()) || ($arrPerm['edit'] == 2 && $ownerGroupID == getLoggedGroupID()) || $arrPerm['edit'] == 3)) ? "\$j('#BidderID$rnd1').prop('disabled', false); " : "\$j('#BidderID$rnd1').prop('disabled', true); ")." \$j(window).resize(); }\n";
	}
	$templateCode .= "\t\t});\n";
	$templateCode .= "\t};\n";
	if(!$dvprint) $templateCode .= "\tif(\$j('#BidderID_caption').length) \$j('#BidderID_caption').click(function() { BidderID_update_autofills$rnd1(); });\n";

	$templateCode .= "\tTableID_update_autofills$rnd1 = function() {\n";
	$templateCode .= "\t\t\$j.ajax({\n";
	if($dvprint) {
		$templateCode .= "\t\t\turl: 'Tickets_autofill.php?rnd1=$rnd1&mfk=TableID&id=' + encodeURIComponent('".addslashes($row['TableID'])."'),\n";
		$templateCode .= "\t\t\tcontentType: 'application/x-www-form-urlencoded; charset=" . datalist_db_encoding . "',\n";
		$templateCode .= "\t\t\ttype: 'GET'\n";
	} else {
		$templateCode .= "\t\t\turl: 'Tickets_autofill.php?rnd1=$rnd1&mfk=TableID&id=' + encodeURIComponent(AppGini.current_TableID{$rnd1}.value),\n";
		$templateCode .= "\t\t\tcontentType: 'application/x-www-form-urlencoded; charset=" . datalist_db_encoding . "',\n";
		$templateCode .= "\t\t\ttype: 'GET',\n";
		$templateCode .= "\t\t\tbeforeSend: function() { \$j('#TableID$rnd1').prop('disabled', true); },\n";
		$templateCode .= "\t\t\tcomplete: function() { " . (($arrPerm['insert'] || (($arrPerm['edit'] == 1 && $ownerMemberID == getLoggedMemberID()) || ($arrPerm['edit'] == 2 && $ownerGroupID == getLoggedGroupID()) || $arrPerm['edit'] == 3)) ? "\$j('#TableID$rnd1').prop('disabled', false); " : "\$j('#TableID$rnd1').prop('disabled', true); ")." \$j(window).resize(); }\n";
	}
	$templateCode .= "\t\t});\n";
	$templateCode .= "\t};\n";
	if(!$dvprint) $templateCode .= "\tif(\$j('#TableID_caption').length) \$j('#TableID_caption').click(function() { TableID_update_autofills$rnd1(); });\n";


	$templateCode.="});";
	$templateCode.="</script>";
	$templateCode .= $lookups;

	// handle enforced parent values for read-only lookup fields
	$filterField = Request::val('FilterField');
	$filterOperator = Request::val('FilterOperator');
	$filterValue = Request::val('FilterValue');

	// don't include blank images in lightbox gallery
	$templateCode = preg_replace('/blank.gif" data-lightbox=".*?"/', 'blank.gif"', $templateCode);

	// don't display empty email links
	$templateCode=preg_replace('/<a .*?href="mailto:".*?<\/a>/', '', $templateCode);

	/* default field values */
	$rdata = $jdata = get_defaults('Tickets');
	if($selected_id) {
		$jdata = get_joined_record('Tickets', $selected_id);
		if($jdata === false) $jdata = get_defaults('Tickets');
		$rdata = $row;
	}
	$templateCode .= loadView('Tickets-ajax-cache', ['rdata' => $rdata, 'jdata' => $jdata]);

	// hook: Tickets_dv
	if(function_exists('Tickets_dv')) {
		$args = [];
		Tickets_dv(($selected_id ? $selected_id : FALSE), getMemberInfo(), $templateCode, $args);
	}

	return $templateCode;
}