<?php
	$rdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function() {
		var tn = 'Donations';

		/* data for selected record, or defaults if none is selected */
		var data = {
			CatalogID: <?php echo json_encode(['id' => $rdata['CatalogID'], 'value' => $rdata['CatalogID'], 'text' => $jdata['CatalogID']]); ?>,
			ContactID: <?php echo json_encode(['id' => $rdata['ContactID'], 'value' => $rdata['ContactID'], 'text' => $jdata['ContactID']]); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for CatalogID */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'CatalogID' && d.id == data.CatalogID.id)
				return { results: [ data.CatalogID ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for ContactID */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'ContactID' && d.id == data.ContactID.id)
				return { results: [ data.ContactID ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>

