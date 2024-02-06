<?php
	$rdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function() {
		var tn = 'Payments';

		/* data for selected record, or defaults if none is selected */
		var data = {
			BidderID: <?php echo json_encode(['id' => $rdata['BidderID'], 'value' => $rdata['BidderID'], 'text' => $jdata['BidderID']]); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for BidderID */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'BidderID' && d.id == data.BidderID.id)
				return { results: [ data.BidderID ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>

