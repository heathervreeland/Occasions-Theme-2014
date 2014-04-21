<div class="vendor-list-block event">
	
	<div class="vendor-list-block-actions">
		<figure>
			<a href="<?php the_permalink() ?>"><?php the_post_thumbnail('event-preview')?></a>
		</figure>
			
		<a href="<?php the_permalink() ?>" class="nice-button">View Event</a>

	</div>

	<div class="detail">
		<h2><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h2>
		<div class="descr">
			<?php echo apply_filters('the_content', oo_get_meta('description', true, get_the_ID())); ?>
		</div>

		<dt>Date(s)</dt>
		<dd>
			<?php echo oo_get_event_date('start', 'F d, Y', get_the_ID()) ?> 
			<?php if (oo_get_meta('date_end',get_the_ID())): ?>
				/ <?php echo oo_get_event_date('end', 'F d, Y', get_the_ID()) ?> 
			<?php endif ?>		
		</dd>			
		<dt>Hours:</dt>
		<dd>
			<?php oo_meta('hours', true, get_the_ID()) ?>
		</dd>			
		<dt>Address</dt>
		<dd>
			<?php oo_meta('event_address', true, get_the_ID()) ?>
			<?php if (oo_get_meta('event_address_city', true, get_the_ID())): ?>
				, <?php oo_meta('event_address_city', true, get_the_ID()) ?>
			<?php endif ?>
			<?php if (oo_get_meta('event_address_state', true, get_the_ID())): ?>
				, <?php oo_meta('event_address_state', true, get_the_ID()) ?>
			<?php endif ?>
			<?php if (oo_get_meta('event_address_zip', true, get_the_ID())): ?>
				, <?php oo_meta('event_address_zip', true, get_the_ID()) ?>
			<?php endif ?>
		</dd>						
		<?php if (oo_get_meta('location', true, get_the_ID())): ?>
			<dt>Location</dt>
			<dd><?php oo_meta('location', true, get_the_ID()) ?></dd>									
		<?php endif ?>
		
		<?php if (oo_get_meta('cost', true, get_the_ID())): ?>
			<dt>Cost</dt>
			<dd><?php oo_meta('cost', true, get_the_ID()) ?></dd>									
		<?php endif ?>

		<?php if (oo_get_meta('more_url', true, get_the_ID())): ?>
			<dt>More Info</dt>
			<dd><a href="<?php oo_meta('more_url', true, get_the_ID()) ?>" rel="external"><?php oo_meta('more_url', true, get_the_ID()) ?></a></dd>
		<?php endif ?>

	</div>


</div>

