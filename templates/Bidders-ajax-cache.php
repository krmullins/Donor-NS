<?php
	$rdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function() {
		var tn = 'Bidders';

		/* data for selected record, or defaults if none is selected */
		var data = {
			ContactID: <?php echo json_encode(['id' => $rdata['ContactID'], 'value' => $rdata['ContactID'], 'text' => $jdata['ContactID']]); ?>,
			MailingName: <?php echo json_encode($jdata['MailingName']); ?>,
			Business: <?php echo json_encode($jdata['Business']); ?>,
			Address1: <?php echo json_encode($jdata['Address1']); ?>,
			Address2: <?php echo json_encode($jdata['Address2']); ?>,
			City: <?php echo json_encode($jdata['City']); ?>,
			State: <?php echo json_encode($jdata['State']); ?>,
			Zip: <?php echo json_encode($jdata['Zip']); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for ContactID */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'ContactID' && d.id == data.ContactID.id)
				return { results: [ data.ContactID ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for ContactID autofills */
		cache.addCheck(function(u, d) {
			if(u != tn + '_autofill.php') return false;

			for(var rnd in d) if(rnd.match(/^rnd/)) break;

			if(d.mfk == 'ContactID' && d.id == data.ContactID.id) {
				$j('#MailingName' + d[rnd]).html(data.MailingName);
				$j('#Business' + d[rnd]).html(data.Business);
				$j('#Address1' + d[rnd]).html(data.Address1);
				$j('#Address2' + d[rnd]).html(data.Address2);
				$j('#City' + d[rnd]).html(data.City);
				$j('#State' + d[rnd]).html(data.State);
				$j('#Zip' + d[rnd]).html(data.Zip);
				return true;
			}

			return false;
		});

		cache.start();
	});
</script>

