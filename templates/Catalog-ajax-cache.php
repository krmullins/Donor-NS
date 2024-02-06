<?php
	$rdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function() {
		var tn = 'Catalog';

		/* data for selected record, or defaults if none is selected */
		var data = {
			TypeID: <?php echo json_encode(['id' => $rdata['TypeID'], 'value' => $rdata['TypeID'], 'text' => $jdata['TypeID']]); ?>,
			GroupID: <?php echo json_encode(['id' => $rdata['GroupID'], 'value' => $rdata['GroupID'], 'text' => $jdata['GroupID']]); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for TypeID */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'TypeID' && d.id == data.TypeID.id)
				return { results: [ data.TypeID ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for GroupID */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'GroupID' && d.id == data.GroupID.id)
				return { results: [ data.GroupID ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>

