<?php
	define('DONOTCACHEPAGE', true);
	$cart = Cart66Session::get('Cart66Cart');
?>
<div id="cart-widget">
	<a href="/store/cart/"><span class="item-count"><?php echo $cart->countItems() . " " ; echo $cart->countItems() == 1 ? "Item" : "Items"; ?></span></a> - <span class="amount"><?php echo "$" . number_format($cart->getSubtotal(), 2); ?></span>
</div>