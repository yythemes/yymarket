<?php

if(!defined('ABSPATH')) exit;


use xenice\commerce\models\Orders;
use function xenice\commerce\get_field as get_field;
use function xenice\commerce\get_price as get_price;
use function xenice\commerce\get_order_price as get_order_price;
use function xenice\commerce\get_page_url as get_page_url;

add_filter( 'body_class', function( $classes ) {
	return array_merge( $classes, array( 'archive-product' ) );
});
add_filter( 'the_excerpt', 'vessel\ext\products_excerpt_lenght',99);

get_header();



add_action('wp_footer', function(){
    ?>
    <script>
        
    </script>
    <?php
})
?>
<style>

</style>
<div class="yy-main">
    <div class="yy-group main-show">
        <div class="show-brand">
            <?php do_action('xcommerce_archive_brand') ?>
        </div>
    </div><!-- yy-group -->
    <div class="yy-group">
        <div class="container">
            <div class="flex product-list">
                <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                <div class="card">
                  <div class="card-body">
                    <a class="thumbnail" href="<?php the_permalink()?>" title="<?php the_title() ?>">
                        <img class="lazyload" src="<?php echo yy_get('site_loading_image')?>" data-src="<?php echo get_the_post_thumbnail_url()?:yy_get('site_thumbnail')?>" alt="<?php the_title() ?>" />
                    </a>
                    <div class="data">
                    	<h4 class="card-title">
                    	    <a href="<?php the_permalink()?>" title="<?php the_title() ?>"><?php the_title() ?></a>
                    	</h4>
                    	<div class="bottom-data">
                    	    <div class="time"><?php echo get_the_date('Y-m-d', get_the_ID()); ?></div>
                    	    <div class="price"><?php echo get_price( get_the_ID())?:'';?></div>
                    	</div>
                        
                	</div>
                  </div>
                </div>
                <?php endwhile;?>
                
                <?php else: ?>
                <div class="card">
                    <div class="card-body">
                        <p class="card-text"><?php echo __('No products.', 'xenice-commerce')?></p>
                    </div>
                </div>
                <?php endif; ?>
                    
                
            </div> <!-- flex -->
            <ul class="pagination">
                <?php echo paginate_links(); ?>
            </ul>
        </div>
    </div><!-- yy-group -->
</div><!-- yy-main -->

<?php


get_footer();