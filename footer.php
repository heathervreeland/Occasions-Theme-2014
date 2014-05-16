	</div>

	<footer>

		<div id="back-to-top">
			<a href="#" title="Back to the Top"></a>
		</div>

		<div id="footer-top-bar">

			<div id="footer-news-bg">
			</div>

			<div class="container">

				<div id="footer-social">
					<span>Follow Us</span>
					<?php oo_part("social-share-list"); ?>
				</div>

				<div id="footer-news">
					<?php $subscription = 'OccasionsMagazine'; ?>
					<form method="post" action="https://app.icontact.com/icp/signup.php" name="icpsignup" id="icpsignup3939" accept-charset="UTF-8" onsubmit="return verifyRequired3939();" >
						<span class="start">Newsletter</span>
						<input type="hidden" name="redirect" value="http://www.occasionsonline.com/newsletter/thank-you/">
		                <input type="hidden" name="errorredirect" value="http://www.icontact.com/www/signup/error.html">
		                <input type="hidden" name="listid" value="79427">
		                <input type="hidden" name="specialid:79427" value="SSDD">
		                <input type="hidden" name="clientid" value="1194751">
		                <input type="hidden" name="formid" value="3939">
		                <input type="hidden" name="reallistid" value="1">
		                <input type="hidden" name="doubleopt" value="0">
						<input type="text" class="subscription_email" name="fields_email" id="newsletter_email" placeholder="YOUR EMAIL"/>
	            		<span><a href="#" id="newsletter_signup">Sign Me Up!</a></span>
            		</form>
				</div>

			</div>

		</div>


		<div class="container">
			<ul id="footer-nav">

				<li class="col-md-3">
					<h2 class="brand">Occasions</h2>

					<ul>
						<li><a href="/">Home</a></li>
						<li><a href="/about/">About</a></li>
						<li><a href="/about/careers/">Careers</a></li>
						<li><a href="/advertise/">Print Advertising</a></li>
						<li><a href="/editorial/">Editorial</a></li>
						<li><a href="/about/badges/">Link to Us</a></li>
						<li><a href="/subscribe/">Purchase Copies</a></li>
						<li><a href="/support/">Support</a></li>
						<li><a href="/privacy-policy/">Privacy Policy</a></li>
						<li><a href="/terms-of-use/">Terms of Use</a></li>
						<li><a href="/editorial/overview/">Get Featured</a></li>
						<li><a href="/support/">Update Address</a></li>
					</ul>

				</li>

				<li class="col-md-3">
					<h2>Weddings</h2>

					<ul>
						<?php 
							$cats = get_subcategories('weddings');
							foreach($cats as $cat) {
						?>
						<li><a href="<?php echo get_category_link($cat->cat_ID); ?>"><?php echo $cat->name; ?></a></li>
						<?php } ?>
					</ul>

				</li>

				<li class="col-md-3">
					<h2>Parties &amp; Celebrations</h2>

					<ul>
						<?php 
							$cats = get_subcategories('parties-and-celebrations');
							foreach($cats as $cat) {
						?>
						<li><a href="<?php echo get_category_link($cat->cat_ID); ?>"><?php echo $cat->name; ?></a></li>
						<?php } ?>
					</ul>

				</li>

				<li class="col-md-3">
					<h2>Entertaining &amp; Holidays</h2>

					<ul>
						<?php 
							$cats = get_subcategories('entertaining-and-holidays');
							foreach($cats as $cat) {
						?>
						<li><a href="<?php echo get_category_link($cat->cat_ID); ?>"><?php echo $cat->name; ?></a></li>
						<?php } ?>
					</ul>

					<h2>Local Editions</h2>

					<ul>
						<li><a href="/florida/">Florida</a></li>
						<li><a href="/georgia/">Georgia</a></li>
					</ul>

				</li>

			</ul>
		</div>

	</footer>

  </body>
    	
</html>