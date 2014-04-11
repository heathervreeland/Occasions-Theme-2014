<?php
	// Do not delete these lines for security reasons
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME'])) {
		die ('Please do not load this page directly. Thanks!');
	}
?>
<a name="comments"></a>
<section class="comments">
	<?php if (post_password_required()) : ?>
		<p class="comments-protected"><?php _e('This post is password protected. Enter the password to view comments.', 'oo_theme'); ?></p>
	<?php
	return; endif; ?>
	<header class="comments-head cf">
		<h2><?php printf(_n('One Comment', '%1$s Comments', get_comments_number(), 'oo_theme'), number_format_i18n(get_comments_number())); ?></h2>	
	</header>
	<?php if (have_comments()) : ?>
		<ol class="commentlist">
			<?php wp_list_comments(array('callback' => 'oo_comment', 'max_depth' => 2)); ?>
		</ol>
		<?php if (!comments_open() && !is_page() && post_type_supports(get_post_type(), 'comments')) : ?>
			<p class="comments-closed"><?php _e('Comments are closed.', 'oo_theme'); ?></p>
		<?php endif; ?>
	<?php endif; ?>
	<?php if (!have_comments() && !comments_open() && !is_page() && post_type_supports(get_post_type(), 'comments')) : ?>
		<p class="comments-closed"><?php _e('Comments are closed.', 'oo_theme'); ?></p>
	<?php endif; ?>
</section>
<?php if (comments_open()) : ?>
	<section class="respond cf">
		<a name="respond"></a>
		<?/*
		<h3><?php comment_form_title(__('Leave a Reply', 'oo_theme'), __('Leave a Reply to %s', 'oo_theme')); ?></h3>
		 */?>
		<p class="cancel-comment-reply"><?php cancel_comment_reply_link(); ?></p>
		<?php if (get_option('comment_registration') && !is_user_logged_in()) : ?>
			<p><?php printf(__('You must be <a href="%s">logged in</a> to post a comment.', 'oo_theme'), wp_login_url(get_permalink())); ?></p>
		<?php else : ?>
			<div class="section-divider">
				<div class="line"></div>
				<span class="before">&#8226;</span>
				<span class="heading">Leave a Comment</span>
				<span class="after">&#8226;</span>
			</div>	
			<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" class="comment-form">
				<p class="error"></p>
				<div class="area1 cf">
					<?php if (is_user_logged_in()) : ?>
						<p class="admin">
							<?php printf(__('Logged in as <a href="%s/wp-admin/profile.php">%s</a>.', 'oo_theme'), get_option('siteurl'), $user_identity); ?> | 
							<a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php __('Log out of this account', 'oo_theme'); ?>"><?php _e('Log out &raquo;', 'oo_theme'); ?></a>
						</p>
					<?php else : ?>
						<div class="new-comment-meta">
							<p class="col-md-4">
								<label for="author"><?php _e('Name', 'oo_theme'); ?><span>(required)</span></label>
								<input type="text" class="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" size="22" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> required="required">
							</p>
							<p class="col-md-4">
								<label for="email"><?php _e('Mail', 'oo_theme'); ?><span>(required)</span></label>
								<input type="email" class="text" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" size="22" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> required="required" email="true">
							</p>
							<p class="col-md-4">
								<label for="url"><?php _e('Website', 'oo_theme'); ?></label>
								<input type="url" class="text" name="url" id="url" value="<?php echo esc_attr($comment_author_url); ?>" size="22" tabindex="3">
							</p>
						</div>
					<?php endif; ?>
				</div>
				<div class="area2">
					<textarea name="comment" id="comment" class="input-xlarge" tabindex="4" rows="5" cols="40" required="required"></textarea>
				</div>
				<div class="cf"></div>
				
				<?php do_action('comment_form', $post->ID); ?>

				<?php comment_id_fields(); ?>

				<input name="submit" class="submit nice-button" type="submit" tabindex="5" value="<?php _e('Submit Comment', 'oo_theme'); ?>" />

			</form>
		<?php endif; // if registration required and not logged in ?>
	</section>
<?php endif; ?>