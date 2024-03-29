<?php
	$rdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function() {
		var tn = 'Transactions';

		/* data for selected record, or defaults if none is selected */
		var data = {
			CatalogID: <?php echo json_encode(['id' => $rdata['CatalogID'], 'value' => $rdata['CatalogID'], 'text' => $jdata['CatalogID']]); ?>,
			BidderID: <?php echo json_encode(['id' => $rdata['BidderID'], 'value' => $rdata['BidderID'], 'text' => $jdata['BidderID']]); ?>,
			CatValue: <?php echo json_encode($jdata['CatValue']); ?>
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

		/* saved value for CatalogID autofills */
		cache.addCheck(function(u, d) {
			if(u != tn + '_autofill.php') return false;

			for(var rnd in d) if(rnd.match(/^rnd/)) break;

			if(d.mfk == 'CatalogID' && d.id == data.CatalogID.id) {
				$j('#CatValue' + d[rnd]).html(data.CatValue);
				return true;
			}

			return false;
		});

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

