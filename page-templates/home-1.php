<?php
/*
Template Name: Home-1
*/

if(!defined('ABSPATH')) exit;



add_filter( 'body_class', function( $classes ) {
	return array_merge( $classes, array( 'home' ) );
});

get_header();

?>

<div class="yy-main">
    <div class="yy-group">
        <?php yy_get( 'enable_slides' ) && get_template_part( 'template-parts/home', 'slides' ); ?>
    </div><!-- yy-group -->
    <div class="yy-group">
        <div class="container">
            <div class="flex-title">
                <h3><?php echo yy_get('last_published_alias')?></h3>
                <div class="desc"><?php echo yy_get('last_published_description')?></div>
            </div>
            <div class="flex product-list" >
                <?php
                $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1; 
                $args = array(
                    'post_type' => 'product',
                    'orderby' => 'modified',
                    'posts_per_page' => yy_get('resource_quantity'),
                    'paged' => $paged
                );
                $query = new WP_Query( $args );
                ?>
                <?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); ?>
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
                    	    <div class="price"><?php echo xc_get_price( get_the_ID())?:'';?></div>
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
                <?php
                    $big = 999999999;
                    echo paginate_links( array(
                        'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                        'format' => '?paged=%#%',
                        'current' => max( 1, get_query_var('paged') ),
                        'total' => $query->max_num_pages
                    ) );
                    wp_reset_postdata();
                ?>
            </ul>
        </div>
    </div><!-- yy-group -->
</div><!-- yy-main -->

<?php
get_footer();
?>
