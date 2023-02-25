<?php

use PrimaryCategory\Shortcode;
?>
<p <?php echo get_block_wrapper_attributes(); ?>>
	<?php 
	$primary_category = Shortcode\primary_category_shortcode();
	echo $primary_category;
	?>
</p>
