<?php
/*
Template Name: Update Log
*/

if(!defined('ABSPATH')) exit;

add_filter( 'body_class', function( $classes ) {
	return array_merge( $classes, array( 'update-log' ) );
});

get_header();

?>
<style>
    .yy-main .container{
        background-color: #fff;
        padding:15px 0 30px 0;
        
    }
    .yy-main ul{
        list-style-type: none;
        margin:0;
        padding:0;
    }
    .yy-main ul li{
        list-style-type:none;
        margin:0;
        font-size: 14px;
    }
    .yy-main li ul{
        display: flex;
        justify-content: space-between;
    }
    
    .yy-main .list > li{
        padding:10px 5px;
    }
    .yy-main .list > li:hover{
        padding:10px 5px;
        background-color: #fafafa;
    }
    .yy-main li ul li{
        padding:0 6px;
    }
    .yy-main li ul li:nth-child(1){
    }
    .yy-main li ul li:nth-child(1) span{
        font-size:12px;
        color:#a7a7a7;
        background-color: #f6f6f6;
        padding:5px 6px;
        border-radius: 5px;
        white-space: nowrap;
    }
    .yy-main li ul li:nth-child(2){
        flex-grow:1;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }
    .yy-main li ul li:nth-child(3){
        width:100px;
        color:#999;
    }
    .yy-main li ul li:nth-child(4){
        
    }
    .yy-main li ul li:nth-child(4) a{
        font-size:12px;
        display: inline;
        padding:5px 15px;
        border-radius: 5px;
        white-space: nowrap;
    }
    
@media screen and (max-width: 767px){
    .yy-main li ul li:nth-child(3){
        display: none;
    }
}

</style>
<div class="yy-main">
    <div class="yy-group">
        <div class="container">
            <ul class="list" >
                <?php
                $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1; 
                $args = array(
                    'post_type' => 'product',
                    'orderby' => 'date',
                    'posts_per_page' => 20,
                    'paged' => $paged
                );
                $query = new WP_Query( $args );
                ?>
                <?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); 
                    $categories = get_the_terms( get_the_ID(), 'product_category' );
                    $category_name = __('Uncategorized', 'onenice');
                    if ( $categories && ! is_wp_error( $categories ) ) {
                        foreach ( $categories as $category ) {
                            $category_name = $category->name . ' ';
                        }
                    }
                ?>
                <li>
                    <ul>
                        <li><span><?php echo $category_name?></span></li>
                        <li><a href="<?php the_permalink()?>" title="<?php the_title() ?>"><?php the_title() ?></a></li>
                        <li><time><?php echo get_post_time('Y-m-d', get_the_ID()); ?></time></li>
                        <li><a class="btn btn-custom" href="<?php the_permalink()?>" title="<?php the_title() ?>"><?php echo __('View', 'onenice')?></a></li>
                    </ul>
                </li>
                <?php endwhile;?>
                
                <?php else: ?>
                <div class="card">
                    <div class="card-body">
                        <div class="data">
                            <p class="card-text"><?php echo __('No products.', 'xenice-commerce')?></p>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                    
                
            </ul> <!-- flex -->
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
