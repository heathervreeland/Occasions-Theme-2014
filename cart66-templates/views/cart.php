<?php 

$items = Cart66Session::get('Cart66Cart')->getItems();
$shippingMethods = Cart66Session::get('Cart66Cart')->getShippingMethods();
$shipping = Cart66Session::get('Cart66Cart')->getShippingCost();
$promotion = Cart66Session::get('Cart66Promotion');
$product = new Cart66Product();
$subtotal = Cart66Session::get('Cart66Cart')->getSubTotal();
$discountAmount = Cart66Session::get('Cart66Cart')->getDiscountAmount();
$cartPage = get_page_by_path('store/cart');
$checkoutPage = get_page_by_path('store/checkout');
$setting = new Cart66Setting();

// Try to return buyers to the last page they were on when the click to continue shopping
if(Cart66Setting::getValue('continue_shopping') == 1){
  // force the last page to be store home
  $lastPage = Cart66Setting::getValue('store_url') ? Cart66Setting::getValue('store_url') : get_bloginfo('url');
  Cart66Session::set('Cart66LastPage', $lastPage);
}
else{
  if(isset($_SERVER['HTTP_REFERER']) && isset($_POST['task']) && $_POST['task'] == "addToCart"){
    $lastPage = $_SERVER['HTTP_REFERER'];
    Cart66Session::set('Cart66LastPage', $lastPage);
  }
  if(!Cart66Session::get('Cart66LastPage')) {
    // If the last page is not set, use the store url
    $lastPage = Cart66Setting::getValue('store_url') ? Cart66Setting::getValue('store_url') : get_bloginfo('url');
    Cart66Session::set('Cart66LastPage', $lastPage);
  }
}

$fullMode = true;
if(isset($data['mode']) && $data['mode'] == 'read') {
  $fullMode = false;
}

$tax = 0;
$taxData = false;
if(isset($data['tax'])){
  $taxData = $data['tax'];
}
if(Cart66Session::get('Cart66Tax')){
  $taxData = Cart66Session::get('Cart66Tax');
}
if($taxData > 0) {
  $tax = $taxData;
}
else {
  // Check to see if all sales are taxed
  $tax = Cart66Session::get('Cart66Cart')->getTax('All Sales');
}

$cartImgPath = Cart66Setting::getValue('cart_images_url');
if($cartImgPath && stripos(strrev($cartImgPath), '/') !== 0) {
  $cartImgPath .= '/';
}
if($cartImgPath) {
  $continueShoppingImg = $cartImgPath . 'continue-shopping.png';
  $updateTotalImg = $cartImgPath . 'update-total.png';
  $calculateShippingImg = $cartImgPath . 'calculate-shipping.png';
  $applyCouponImg = $cartImgPath . 'apply-coupon.png';
}

if(count($items)): ?>

<?php if(Cart66Session::get('Cart66InventoryWarning') && $fullMode): ?>
  <?php 
    echo Cart66Session::get('Cart66InventoryWarning');
    Cart66Session::drop('Cart66InventoryWarning');
  ?>
<?php endif; ?>

<?php if(number_format(Cart66Setting::getValue('minimum_amount'), 2, '.', '') > number_format(Cart66Session::get('Cart66Cart')->getSubTotal(), 2, '.', '') && Cart66Setting::getValue('minimum_cart_amount') == 1): ?>
  <div id="minAmountMessage" class="alert-message alert-error Cart66Unavailable">
    <?php echo (Cart66Setting::getValue('minimum_amount_label')) ? Cart66Setting::getValue('minimum_amount_label') : 'You have not yet reached the required minimum amount in order to checkout.' ?>
  </div>
<?php endif;?>

<?php if(Cart66Session::get('Cart66ZipWarning')): ?>
  <div id="Cart66ZipWarning" class="alert-message alert-error Cart66Unavailable">
    <h2 class="header"><?php _e( 'Please Provide Your Zip Code' , 'cart66' ); ?></h2>
    <p><?php _e( 'Before you can checkout, please provide the zip code for where we will be shipping your order and click' , 'cart66' ); ?> "<?php _e( 'Calculate Shipping' , 'cart66' ); ?>".</p>
    <?php 
      Cart66Session::drop('Cart66ZipWarning');
    ?>
    <input type="button" name="close" value="Ok" id="close" class="Cart66ButtonSecondary modalClose" />
  </div>
<?php elseif(Cart66Session::get('Cart66ShippingWarning')): ?>
  <div id="Cart66ShippingWarning" class="alert-message alert-error Cart66Unavailable">
    <h2 class="header"><?php _e( 'No Shipping Service Selected' , 'cart66' ); ?></h2>
    <p><?php _e( 'We cannot process your order because you have not selected a shipping method. If there are no shipping services available, we may not be able to ship to your location.' , 'cart66' ); ?></p>
    <?php Cart66Session::drop('Cart66ShippingWarning'); ?>
    <input type="button" name="close" value="Ok" id="close" class="Cart66ButtonSecondary modalClose" />
  </div>
<?php elseif(Cart66Session::get('Cart66CustomFieldWarning')): ?>
  <div id="Cart66CustomFieldWarning" class="alert-message alert-error Cart66Unavailable">
    <h2 class="header"><?php _e( 'Custom Field Error' , 'cart66' ); ?></h2>
    <p><?php _e( 'We cannot process your order because you have not filled out the custom field required for these products:' , 'cart66' ); ?></p>
      <ul>
        <?php foreach(Cart66Session::get('Cart66CustomFieldWarning') as $customField): ?>
          <li><?php echo $customField; ?></li>
        <?php endforeach;?>
      </ul>
    <input type="button" name="close" value="Ok" id="close" class="Cart66ButtonSecondary modalClose" />
  </div>
<?php endif; ?>

<?php if(Cart66Session::get('Cart66SubscriptionWarning')): ?>
  <div id="Cart66SubscriptionWarning" class="alert-message alert-error Cart66Unavailable">
    <h2 class="header"><?php _e( 'Too Many Subscriptions' , 'cart66' ); ?></h2>
    <p><?php _e( 'Only one subscription may be purchased at a time.' , 'cart66' ); ?></p>
    <?php 
      Cart66Session::drop('Cart66SubscriptionWarning');
    ?>
    <input type="button" name="close" value="Ok" id="close" class="Cart66ButtonSecondary modalClose" />
  </div>
<?php endif; ?>

<?php 
  if($accountId = Cart66Common::isLoggedIn()) {
    $account = new Cart66Account($accountId);
    if($sub = $account->getCurrentAccountSubscription()) {
      if($sub->isPayPalSubscription() && Cart66Session::get('Cart66Cart')->hasPayPalSubscriptions()) {
        ?>
        <p id="Cart66SubscriptionChangeNote"><?php _e( 'Your current subscription will be canceled when you purchase your new subscription.' , 'cart66' ); ?></p>
        <?php
      }
    }
  } 
?>

<form id='Cart66CartForm' action="" method="post">
  <input type='hidden' name='task' value='updateCart' />
  <div id="cart-table">
    <table id='viewCartTable'>
      <colgroup>
        <col class="col1" />
        <col class="col2" />
        <col class="col3" />
        <col class="col4" />
        <col class="col5" />
      </colgroup>
    <thead>
      <tr>
        <th class="product-title"><?php _e('Product','cart66') ?></th>
        <th class="quantity cart66-align-center"><?php _e( 'Quantity' , 'cart66' ); ?></th>
        <th class="price cart66-align-right"><?php _e( 'Item Price' , 'cart66' ); ?></th>
        <th class="total cart66-align-right"><?php _e( 'Item Total' , 'cart66' ); ?></th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td colspan="5">
        <?php foreach($items as $itemIndex => $item): ?>
          <?php
            // Get cover images
            global $wpdb; 
            $sql="SELECT item_number FROM occasionsmag_cart66_products WHERE id = " . $item->getProductId();
            $res = $wpdb->get_results($sql);
            $sql="SELECT post_ID FROM occasionsmag_postmeta WHERE (meta_key = 'flo_single' AND meta_value = '" . $res[0]->item_number . "') OR (meta_key = 'flo_box' AND meta_value = '" . $res[0]->item_number . "')";
            $res = $wpdb->get_results($sql);
            $issue_id = $res[0]->post_ID;
            $preview_image = get_the_post_thumbnail($issue_id, 'issue-preview');

            Cart66Common::log('[' . basename(__FILE__) . ' - line ' . __LINE__ . "] Item option info: " . $item->getOptionInfo());
            $product->load($item->getProductId());
            $price = $item->getProductPrice() * $item->getQuantity();
          ?>

          <div class="item-row">
              <div class="product-title <?php if($item->hasAttachedForms()) { echo " noBottomBorder"; } ?>" >
                <?php echo $preview_image; ?>
                <?php if(Cart66Setting::getValue('display_item_number_cart')): ?>
                  <span class="cart66-cart-item-number"><?php echo $item->getItemNumber(); ?></span>
                <?php endif; ?>
                <?php #echo $item->getItemNumber(); ?>
                <?php if($item->getProductUrl() != '' && Cart66Setting::getValue('product_links_in_cart') == 1 && $fullMode): ?>
                  <a class="product_url" href="<?php echo $item->getProductUrl(); ?>"><?php echo $item->getFullDisplayName(); ?></a>
                <?php else: ?>
                  <?php echo $item->getFullDisplayName(); ?>
                <?php endif; ?>
                <?php echo $item->getCustomField($itemIndex, $fullMode); ?>
                <?php Cart66Session::drop('Cart66CustomFieldWarning'); ?>
              </div>
              <?php if($fullMode): ?>
              <div class="quantity cart66-align-center<?php if($item->hasAttachedForms()) { echo " noBottomBorder"; } ?>">
                
                <?php if($item->isSubscription() || $item->isMembershipProduct() || $product->is_user_price==1): ?>
                  <span class="subscriptionOrMembership"><?php echo $item->getQuantity() ?></span>
                <?php else: ?>
                  <input type='text' name='quantity[<?php echo $itemIndex ?>]' value='<?php echo $item->getQuantity() ?>' class="itemQuantity"/>
                <?php endif; ?>            
              </div>
              <?php else: ?>
                <div class="cart66-align-center <?php if($item->hasAttachedForms()) { echo "noBottomBorder"; } ?>"><?php echo $item->getQuantity() ?></div>
              <?php endif; ?>
              <div class="cart66-align-right prices <?php if($item->hasAttachedForms()) { echo "noBottomBorder"; } ?>"><?php echo Cart66Common::currency($item->getProductPrice()); ?></div>
              <div class="cart66-align-right prices total<?php if($item->hasAttachedForms()) { echo "noBottomBorder"; } ?>"><?php echo Cart66Common::currency($price);?></div>
              <div class="cart66-align-right deletebtn">
                <?php $removeLink = get_permalink($cartPage->ID); ?>
                <?php $taskText = (strpos($removeLink, '?')) ? '&task=removeItem&' : '?task=removeItem&'; ?>
                <a href='<?php echo $removeLink . $taskText ?>itemIndex=<?php echo $itemIndex ?>' title='Remove item from cart'><img src='<?php bloginfo('template_directory'); ?>/images/icn_delete.png' alt="Remove Item" /></a>
              </div>
          </div>

          <?php if($item->hasAttachedForms()): ?>
                <a href='#' class="showEntriesLink" rel="<?php echo 'entriesFor_' . $itemIndex ?>"><?php _e( 'Show Details' , 'cart66' ); ?> <?php #echo count($item->getFormEntryIds()); ?></a>
                <div id="<?php echo 'entriesFor_' . $itemIndex ?>" class="showGfFormData" style="display: none;">
                  <?php echo $item->showAttachedForms($fullMode); ?>
                </div>
          <?php endif;?>      
        <?php endforeach; ?>
        </td>
      </tr>
      <?php if(Cart66Session::get('Cart66Cart')->requireShipping()): ?>
        
        
        <?php if(CART66_PRO && Cart66Setting::getValue('use_live_rates')): ?>
          <?php $zipStyle = "style=''"; ?>
          
          <?php if($fullMode): ?>
            <?php if(Cart66Session::get('cart66_shipping_zip')): ?>
              <?php $zipStyle = "style='display: none;'"; ?>
              <tr id="shipping_to_row">
                <th colspan="4" class="alignRight">
                  <?php _e( 'Shipping to' , 'cart66' ); ?> <?php echo Cart66Session::get('cart66_shipping_zip'); ?> 
                  <?php
                    if(Cart66Setting::getValue('international_sales')) {
                      echo Cart66Session::get('cart66_shipping_country_code');
                    }
                  ?>
                  (<a href="#" id="change_shipping_zip_link">change</a>)
                  &nbsp;
                  <?php
                    $liveRates = Cart66Session::get('Cart66Cart')->getLiveRates();
                    $rates = $liveRates->getRates();
                    Cart66Common::log('[' . basename(__FILE__) . ' - line ' . __LINE__ . "] LIVE RATES: " . print_r($rates, true));
                    $selectedRate = $liveRates->getSelected();
                    $shipping = Cart66Session::get('Cart66Cart')->getShippingCost();
                  ?>
                  <select name="live_rates" id="live_rates">
                    <?php foreach($rates as $rate): ?>
                      <option value='<?php echo $rate->service ?>' <?php if($selectedRate->service == $rate->service) { echo 'selected="selected"'; } ?>>
                        <?php 
                          if($rate->rate !== false) {
                            echo "$rate->service: \$$rate->rate";
                          }
                          else {
                            echo "$rate->service";
                          }
                        ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </th>
              </tr>
            <?php endif; ?>
          
            <tr id="set_shipping_zip_row" <?php echo $zipStyle; ?>>
              <th colspan="4" class="alignRight"><?php _e( 'Enter Your Zip Code' , 'cart66' ); ?>:
                <input type="text" name="shipping_zip" value="" id="shipping_zip" size="5" />
                
                <?php if(Cart66Setting::getValue('international_sales')): ?>
                  <select name="shipping_country_code">
                    <?php
                      $customCountries = Cart66Common::getCustomCountries();
                      foreach($customCountries as $code => $name) {
                        echo "<option value='$code'>$name</option>\n";
                      }
                    ?>
                  </select>
                <?php else: ?>
                  <input type="hidden" name="shipping_country_code" value="<?php echo Cart66Common::getHomeCountryCode(); ?>" id="shipping_country_code">
                <?php endif; ?>
                
                <?php if($cartImgPath && Cart66Common::urlIsLIve($calculateShippingImg)): ?>
                  <input class="Cart66CalculateShippingButton" type="image" src='<?php echo $calculateShippingImg ?>' value="<?php _e( 'Calculate Shipping' , 'cart66' ); ?>" name="calculateShipping" />
                <?php else: ?>
                  <input type="submit" name="calculateShipping" value="<?php _e('Calculate Shipping', 'cart66'); ?>" id="shipping_submit" class="Cart66CalculateShippingButton Cart66ButtonSecondary" />
                <?php endif; ?>
              </th>
            </tr>
          <?php else:  // Cart in read mode ?>
            <tr>
              <th colspan="4" class='alignRight'>
                <?php
                  $liveRates = Cart66Session::get('Cart66Cart')->getLiveRates();
                  if($liveRates && Cart66Session::get('cart66_shipping_zip') && Cart66Session::get('cart66_shipping_country_code')) {
                    $selectedRate = $liveRates->getSelected();
                    echo __("Shipping to", "cart66") . " " . Cart66Session::get('cart66_shipping_zip') . " " . __("via","cart66") . " " . $selectedRate->service;
                  }
                ?>
              </th>
            </tr>
          <?php endif; // End cart in read mode ?>
          
        <?php  else: ?>
          <?php if(count($shippingMethods) > 1 && $fullMode): ?>
          <tr>
            <th colspan='4' class="alignRight"><?php _e( 'Shipping Method' , 'cart66' ); ?>: &nbsp;
              <?php if(Cart66Setting::getValue('international_sales')): ?>
                <select name="shipping_country_code" id="shipping_country_code">
                  <?php
                    $customCountries = Cart66Common::getCustomCountries();
                    foreach($customCountries as $code => $name) {
                      $selected_country = '';
                      if($code == Cart66Session::get('Cart66ShippingCountryCode')) {
                        $selected_country = ' selected="selected"';
                      }
                      echo "<option value='$code'$selected_country>$name</option>\n";
                    }
                  ?>
                </select>
              <?php else: ?>
                <input type="hidden" name="shipping_country_code" value="<?php echo Cart66Common::getHomeCountryCode(); ?>" id="shipping_country_code">
              <?php endif; ?>
              <select name='shipping_method_id' id='shipping_method_id'>
                <?php foreach($shippingMethods as $name => $id): ?>
                  <?php
                  $method_class = 'methods-country ';
                  $method = new Cart66ShippingMethod($id);
                  $methods = unserialize($method->countries);
                  if(is_array($methods)) {
                    foreach($methods as $code => $country) {
                      $method_class .= $code . ' ';
                    }
                  }
                  if($id == 'select') {
                    $method_class = "select";
                  }
                  elseif($method_class == 'methods-country ') {
                    $method_class = 'all-countries';
                  }
                  ?>
                <option class="<?php echo trim($method_class); ?>" value='<?php echo $id ?>' <?php echo ($id == Cart66Session::get('Cart66Cart')->getShippingMethodId())? 'selected' : ''; ?>><?php echo $name ?></option>
                <?php endforeach; ?>
              </select>
            </th>
          </tr>
          <?php elseif(!$fullMode): ?>
          <tr>
            <th colspan='4' class="alignRight"><?php _e( 'Shipping Method' , 'cart66' ); ?>: 
              <?php 
                $method = new Cart66ShippingMethod(Cart66Session::get('Cart66Cart')->getShippingMethodId());
                echo $method->name;
              ?>
            </th>
          </tr>
          <?php endif; ?>
        <?php endif; ?>
      <?php endif; ?>


      <?php if($promotion): ?>
        <tr class="coupon">
          <td colspan="3" class="alignRight strong"><?php _e( 'Coupon' , 'cart66' ); ?> 
          <?php 
            if($promotion->name){ 
              echo "(" .$promotion->name .")"; 
            }
            else{
              echo "(" . Cart66Session::get('Cart66PromotionCode') . ")";
            }
          ?>:</td>
          <td class="strong cart66-align-right">-&nbsp;<?php $promotionDiscountAmount = Cart66Session::get('Cart66Cart')->getDiscountAmount();
           echo Cart66Common::currency($promotionDiscountAmount); ?></td>
        </tr>
      <?php endif; ?>
      
      <tr class="tax-row <?php echo $tax > 0 ? 'show-tax-row' : 'hide-tax-row'; ?>">
        <td colspan='2'>&nbsp;</td>
        <?php $taxRate = isset($data['rate']) ? Cart66Common::tax($data['rate']) : Cart66Session::get('Cart66TaxRate'); ?>
        <td class="alignRight strong"><span class="ajax-spin"><img src="<?php echo CART66_URL; ?>/images/ajax-spin.gif" /></span> <?php _e( 'Tax' , 'cart66' ); ?> (<span class="tax-rate"><?php echo $taxRate; ?></span>):</td>
        <td class="strong tax-amount cart66-align-right"><?php echo Cart66Common::currency($tax); ?></td>
      </tr>

        </tbody>
    </table>
  </div>

    
  <div class="subtotals">
    <div class="subtotal-line">
      <?php _e( 'Subtotal' , 'cart66' ); ?>:
      <span class="price"><?php echo Cart66Common::currency($subtotal); ?></span>
    </div>

    <?php if(Cart66Session::get('Cart66Cart')->requireShipping()): ?>
      <div class="subtotal-line shipping">
        <?php _e( 'Shipping' , 'cart66' ); ?>:
        <span class="price"><?php echo Cart66Common::currency($shipping) ?></span>
      </div>
    <?php endif; ?>

  </div>

  <div class="apply-coupon">
    <?php if($fullMode && Cart66Common::activePromotions()): ?>
        <p class="haveCoupon"><?php _e( 'Do you have a coupon?' , 'cart66' ); ?></p>
      <?php if(Cart66Session::get('Cart66PromotionErrors')):
            $promoErrors = Cart66Session::get('Cart66PromotionErrors');
                foreach($promoErrors as $type=>$error): ?>
                <p class="promoMessage warning"><?php echo $error; ?></p>
          <?php endforeach;?>
          <?php Cart66Session::get('Cart66Cart')->clearPromotion();
              endif; ?>
        <div id="couponCode"><input type='text' name='couponCode' value='' /></div>
        <div id="updateCart">
          <?php if($cartImgPath && Cart66Common::urlIsLIve($applyCouponImg)): ?>
            <input class="nice-button apply" type="image" src='<?php echo $applyCouponImg ?>' value="<?php _e( 'Apply' , 'cart66' ); ?>" name="updateCart"/>
          <?php else: ?>
            <input type='submit' name='updateCart' value='<?php _e( 'Apply' , 'cart66' ); ?>' class="nice-button apply" />
          <?php endif; ?>
        </div>
    <?php endif; ?>
  </div>


  <div class="grand-total">
      <span class="ajax-spin"><img src="<?php echo CART66_URL; ?>/images/ajax-spin.gif" /></span> <?php _e( 'Total' , 'cart66' ); ?>:
        <span class="price"><?php 
          echo Cart66Common::currency(Cart66Session::get('Cart66Cart')->getGrandTotal() + $tax);
        ?></span>

  </div>


  <?php if($fullMode): ?>
    
  <div id="viewCartNav">
	<div id="continueShopping">
        <?php if($cartImgPath): ?>
          <a href='<?php echo Cart66Session::get('Cart66LastPage'); ?>' class="nice-button" >Continue Shopping</a>
        <?php else: ?>
          <a href='<?php echo Cart66Session::get('Cart66LastPage'); ?>' class="nice-button" title="Continue Shopping"><?php _e( 'Continue Shopping' , 'cart66' ); ?></a>
        <?php endif; ?>
	</div>

  <?php
    $checkoutImg = false;
    if($cartImgPath) {
      $checkoutImg = $cartImgPath . 'checkout.png';
    }
  ?>
  <?php
    if(number_format(Cart66Setting::getValue('minimum_amount'), 2, '.', '') > number_format(Cart66Session::get('Cart66Cart')->getSubTotal(), 2, '.', '') && Cart66Setting::getValue('minimum_cart_amount') == 1): ?>
  <?php else: ?>
    <div id="checkoutShopping">
      <?php
        $checkoutUrl = Cart66Setting::getValue('auth_force_ssl') ? str_replace('http://', 'https://', get_permalink($checkoutPage->ID)) : get_permalink($checkoutPage->ID);
      ?>
      <?php if($checkoutImg): ?>
        <a id="Cart66CheckoutButton" class="nice-button checkout" href='<?php echo $checkoutUrl; ?>'>Checkout</a>
      <?php else: ?>
        <a id="Cart66CheckoutButton" href='<?php echo $checkoutUrl; ?>' class="nice-button checkout" title="Continue to Checkout"><?php _e( 'Checkout' , 'cart66' ); ?></a>
      <?php endif; ?>
    </div>
  <?php endif; ?>
  <?php else: ?>
    <div id="Cart66CheckoutReplacementText">
        <?php echo Cart66Setting::getValue('cart_terms_replacement_text');  ?>
    </div>
  <?php endif; ?>

  <div class="update-checkout">
    <?php if($fullMode): ?>
      <?php if($cartImgPath && Cart66Common::urlIsLIve($updateTotalImg)): ?>
        <input class="nice-button" type="image" src='<?php echo $updateTotalImg ?>' value="<?php _e( 'Update Cart' , 'cart66' ); ?>" name="updateCart"/>
      <?php else: ?>
        <input type='submit' name='updateCart' value='<?php _e( 'Update Cart' , 'cart66' ); ?>' class="nice-button" />
      <?php endif; ?>
    <?php endif; ?>
  </div>

	
	  <?php	  
  	  // dont show checkout until terms are accepted (if necessary)
  	 if((Cart66Setting::getValue('require_terms') != 1) ||  
  	    (Cart66Setting::getValue('require_terms') == 1 && (isset($_POST['terms_acceptance']) || Cart66Session::get("terms_acceptance")=="accepted")) ) :  
  	    
  	    if(Cart66Setting::getValue('require_terms') == 1){
  	      Cart66Session::set("terms_acceptance","accepted",true);        
  	    }
  	    
  	?>

	
	
	   <?php  

    	if(CART66_PRO && Cart66Setting::getValue('require_terms') == 1 && (!isset($_POST['terms_acceptance']) && Cart66Session::get("terms_acceptance")!="accepted") ){
    	    echo Cart66Common::getView("pro/views/terms.php",array("location"=>"Cart66CartTOS"));
    	} 

    	 ?>
	</form>

	</div>
	
	
  <?php endif; ?>
<?php else: ?>
  <div id="emptyCartMsg">
  <h3><?php _e('Your Cart Is Empty','cart66'); ?></h3>
  <?php if($cartImgPath): ?>
    <p><a href='/subscribe' title="Continue Shopping" class="Cart66CartContinueShopping nice-button">Continue Shopping</a>
  <?php else: ?>
    <p><a href='/subscribe' class="Cart66ButtonSecondary nice-button" title="Continue Shopping"><?php _e( 'Continue Shopping' , 'cart66' ); ?></a>
  <?php endif; ?>
  </div>
  <?php
    if($promotion){
      Cart66Session::get('Cart66Cart')->clearPromotion();
    }
    Cart66Session::drop("terms_acceptance");
  ?>
<?php endif; ?>
<script type="text/javascript">
/* <![CDATA[ */
  (function($){
    $(document).ready(function(){
      var original_methods = $('#shipping_method_id').html();
      var selected_country = $('#shipping_country_code').val();
      $('.methods-country').each(function() {
        if(!$(this).hasClass(selected_country) && !$(this).hasClass('all-countries') && !$(this).hasClass('select')) {
          $(this).remove();
        }
      });
      $('#shipping_country_code').change(function() {
        var selected_country = $(this).val();
        $('#shipping_method_id').html(original_methods);
        console.log(selected_country)
        $('.methods-country').each(function() {
          if(!$(this).hasClass(selected_country) && !$(this).hasClass('all-countries') && !$(this).hasClass('select')) {
            $(this).remove();
          }
        });
      });
      
      $('#shipping_method_id').change(function() {
        $('#Cart66CartForm').submit();
      });

      $('#live_rates').change(function() {
        $('#Cart66CartForm').submit();
      });

      $('.showEntriesLink').click(function() {
        var panel = $(this).attr('rel');
        $('#' + panel).toggle();
        return false;
      });

      $('#change_shipping_zip_link').click(function() {
        $('#set_shipping_zip_row').toggle();
        return false;
      });
    })
  })(jQuery);
/* ]]> */
</script>
