<?php if (oo_get_option('google_ad') && oo_get_option('sidebar_ad_count')): ?>
	<div class="zone">	
		<?php for ($i = 1; $i <= oo_get_option('sidebar_ad_count'); $i++): ?>
			<div class="spot"><script type='text/javascript'>GA_googleFillSlot("300x125_spot_<?php echo $i ?>");</script></div>
		<?php endfor;?>
	</div>
<?php endif ?>