<nav>
	<?php if(sizeof( WC()->cart->get_cart() ) > 0): ?>
		<a href="<?php echo get_permalink(wc_get_page_id('cart')); ?>">
			Open My Bag of Shit & Pay!
		</a>
	<?php endif; ?>
	<a href="#dismiss" class="dismiss">Close This</a>
</nav>
