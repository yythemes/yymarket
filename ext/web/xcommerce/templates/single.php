<?php
if(!defined('ABSPATH')) exit;

use function xenice\commerce\get as get;
use function xenice\commerce\get_price as get_price;
use function xenice\commerce\get_page_url as get_page_url;

add_filter( 'the_excerpt', 'vessel\ext\product_excerpt_lenght',99);
global $post;

get_header();

add_action('wp_footer', function(){
    ?>
    <script>
        
    </script>
    <?php
});

$terms = wp_get_post_terms($post->ID, 'product_category');

$content = get_the_content();
$arr = explode('===', trim($content));
$data = [];
foreach($arr as $key=>$value){
    if($key == 0) continue;
    if ($key % 2 == 0) {
        $data[$front_value] = trim($value);
        continue;
    }
    $front_value = trim($value);
}

$buy_nonce = wp_create_nonce('buy');
?>
<style>

</style>
<div class="yy-main">
    <div class="yy-group">
        <div class="breadcrumb">
        	<div class="container">
        	    <a class="breadcrumb-item" href="<?php echo home_url()?>"><?php echo __('Home', 'xenice-commerce') ?></a>
        	    <?php if(isset($terms[0])):?>
        	    <a class="breadcrumb-item" href="<?php echo get_term_link($terms[0]->term_id, 'product_category')?>"><?php echo $terms[0]->name ?></a>
        	    <?php else:?>
        	    <a class="breadcrumb-item" href="<?php echo get_post_type_archive_link('product')?>"><?php echo __('Products', 'xenice-commerce') ?></a>
        	    <?php endif;?>
        	    <span class="breadcrumb-item active"><?php echo $post->post_title ?></span>
        	</div>
        </div>
    </div><!-- yy-group -->
    
    <div class="yy-group detail-show">
        <div class="container">
        	<div class="row">
        	  <div class="col-md-8">
        	      <div class="md-up-none">
                      <?php include __DIR__ . '/download-part.php';?>
                  </div>
        	        <div class="post">
        	            <h3><?php echo __('Detailed Introduction', 'onenice')?></h3>
        	            <div class="post-meta">
                    		<?php if ( yy_get( 'single_show_date' ) ) : ?>
                    			<span><?php echo get_the_modified_date('Y-m-d'); ?></span>
                    		<?php endif; ?>
                    		<?php if ( yy_get( 'single_show_author' ) ) : ?>
                    			<span class="card-link md-down-none"><?php echo esc_html( get_the_author_meta( 'display_name', $post->post_author ) ); ?></span>
                    		<?php endif; ?>
                    		<?php if (current_user_can('edit_posts')) : ?>
                    			<a class="card-link" href="<?php echo esc_attr(get_edit_post_link())?>"><?php _e('Edit', 'onenice')?></a>
                    		<?php endif; ?>
                    	</div>
                		<div class="post-content gallery"><?php the_content()?></div>
                		<?php /*
                        <div class="adjacent d-flex justify-content-between">
                            <span class="previous"><?php previous_post_link(__('Previous Post'). '<br/>%link', '%title', true); ?></span>
                            <span class="next"><?php next_post_link(__('Next Post') . '<br/>%link', '%title', true); ?></span>
                        </div>
                        <?php if(onenice_get('show_related_posts')) {get_template_part('template-parts/related', 'posts' );} ?>
                        */?>
        	        </div>

                    <?php comments_template(); ?>

                    
        	  </div>
              <div class="col-md-4 right">
                  <div class="md-down-none">
                      <?php include __DIR__ . '/download-part.php';?>
                  </div>
            	  
                  <h3><?php echo __('Hot Recommendation', 'onenice')?></h3>
                  <ul class="hot">
                    <?php 
                        $r = new WP_Query(
            				array(
            				    //'tax_query'           => [['taxonomy' =>'category', 'terms' => wp_get_post_categories($post->ID)]],
            				    //'category__in'        => wp_get_post_categories($post->ID), 
            					'posts_per_page'      => 6,
            					'post__not_in'        => [$post->ID],
            					'post_type'           => 'product',
            					//'no_found_rows'       => true,
            					'post_status'         => 'publish',
            					'meta_key' => 'xc_sales',
        	                    'orderby' => 'meta_value_num',
            					//'ignore_sticky_posts' => true,
            				)
            			
            		);
            
            		if ( !$r->have_posts() ) {
            			echo '<li>'.__('None ..', 'xenice-commerce').'<li>';
            		}
            		else{
            		    foreach ( $r->posts as $cur_post ) : 
            		        $post_title   = get_the_title( $cur_post->ID );
            			    $title        = ( ! empty( $post_title ) ) ? $post_title : __( '(no title)' );
            		    ?>
                    		<li>
                    		    <a href="<?=the_permalink( $cur_post->ID )?>" title="<?=$title?>">
                                    <div class="thumbnail"><?php echo get_the_post_thumbnail($cur_post->ID, 'medium_large')?></div>
                                </a>
                                <div class="meta">
                                    <h4><a href="<?php echo the_permalink( $cur_post->ID )?>" title="<?php echo $title?>"><?php echo $title?></a></h4>
                                    <div class="bottom-data">
                                	    <div class="time"><?php echo get_the_date('Y-m-d', $cur_post->ID); ?></div>
                                	    <div class="price"><?php echo get_price( $cur_post->ID)?:'';?></div>
                                	</div>
                                </div>
                            </li>
                            
            				
            			<?php endforeach; ?>
            		    
            		<?php }?>
                    
                </ul>
              </div>
        	</div><!-- row -->
        </div>
    </div><!-- yy-group -->
</div><!-- yy-main -->
<?php

get_footer();