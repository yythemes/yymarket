<?php

if(!defined('ABSPATH')) exit;


$id = get_queried_object_id();

$term = get_term($id, 'product_tag');


add_action('xenice_commerce_breadcrumb', function()use($term){
?>
<div class="breadcrumb">
	<div class="container">
	    <a class="breadcrumb-item" href="<?php echo home_url()?>"><?php echo __('Home', 'xenice-commerce') ?></a>
	    <span class="breadcrumb-item active"><?php echo $term->name ?></span>
	</div>
</div>
<?php
});


include __DIR__ . '/archive.php';