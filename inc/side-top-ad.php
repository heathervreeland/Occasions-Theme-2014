<?php if (oo_get_option('glam_ad')): ?>
	<?php if( wpmd_is_notphone() ) : ?>
	<div class="zone">
		<div class="spot">
			<script type="text/javascript" src="http://www2.glam.com/app/site/affiliate/viewChannelModule.act?mName=viewAdJs&amp;affiliateId=<?php oo_option('glam_ad') ?>&amp;adSize=300x250"></script>
		</div>
	</div>
	<?php endif; ?>
<?php endif ?>