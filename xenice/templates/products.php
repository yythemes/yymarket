<?php

if(!defined('ABSPATH')) exit;


add_filter( 'document_title_parts', function($title){
    $title['tagline'] = $title['title'];
    $title['title'] = __('Products', 'xenice-commerce');
    return $title;
});


add_action('xenice_commerce_breadcrumb', function(){
?>
<div class="breadcrumb">
	<div class="container">
	    <a class="breadcrumb-item" href="<?php echo home_url()?>"><?php echo __('Home', 'xenice-commerce') ?></a>
	    <span class="breadcrumb-item active"><?php echo __('Products', 'xenice-commerce') ?></span>
	</div>
</div>
<?php
});

include __DIR__ . '/archive.php';