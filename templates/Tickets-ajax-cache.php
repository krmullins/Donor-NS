<?php
	$rdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function() {
		var tn = 'Tickets';

		/* data for selected record, or defaults if none is selected */
		var data = {
			BidderID: <?php echo json_encode(['id' => $rdata['BidderID'], 'value' => $rdata['BidderID'], 'text' => $jdata['BidderID']]); ?>,
			TablePreference: <?php echo json_encode($jdata['TablePreference']); ?>,
			TableID: <?php echo json_encode(['id' => $rdata['TableID'], 'value' => $rdata['TableID'], 'text' => $jdata['TableID']]); ?>,
			TableName: <?php echo json_encode($jdata['TableName']); ?>
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

		/* saved value for BidderID autofills */
		cache.addCheck(function(u, d) {
			if(u != tn + '_autofill.php') return false;

			for(var rnd in d) if(rnd.match(/^rnd/)) break;

			if(d.mfk == 'BidderID' && d.id == data.BidderID.id) {
				$j('#TablePreference' + d[rnd]).html(data.TablePreference);
				return true;
			}

			return false;
		});

		/* saved value for TableID */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'TableID' && d.id == data.TableID.id)
				return { results: [ data.TableID ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for TableID autofills */
		cache.addCheck(function(u, d) {
			if(u != tn + '_autofill.php') return false;

			for(var rnd in d) if(rnd.match(/^rnd/)) break;

			if(d.mfk == 'TableID' && d.id == data.TableID.id) {
				$j('#TableName' + d[rnd]).html(data.TableName);
				return true;
			}

			return false;
		});

		cache.start();
	});
</script>

