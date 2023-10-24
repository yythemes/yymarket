<?php

namespace ext;

require __DIR__ . '/functions.php';

class Ext{

    /**
	 * Constructor
	 */
	public function __construct(){
        // add_action('init', [$this, 'reset_options']);
        add_filter('yy_config', [$this, 'config'], 10);
        add_filter('yy_import_file', [$this, 'import_file'], 10, 2);
        add_action('wp_enqueue_scripts', [$this, 'load_scripts'], 20);
        add_filter('yy_default_values', [$this, 'default_values']);
        add_action('pre_get_posts', [$this, 'modify_main_query']);
        
        // change rollbar
        add_action('wp_head', function(){
            remove_action('wp_footer', 'yy_rollbar', 99);
            add_action('wp_footer', [$this, 'rollbar'], 99);
        });

        
        new xcommerce\Xcommerce;
        
	}
	
	/**
     * Reset options (Comment it out when it's officially operational)
     */
    public function reset_options(){
        (new Config)->reset();
    }
    
	/**
     * Change theme config
     */
    public function config(){
        return new Config;
    }

	/**
     * Change template file
     */
    public function import_file($file, $name){
        $file = EXT_DIR .'/'. $name . '.php';
        /*
        if($name == 'header'){
            $file = EXT_DIR .'/'. $name . '.php';
            
            if(is_front_page()){
                $file = EXT_DIR .'/'. $name . '-home.php';
            }
            elseif(is_singular()){
                global $post;
                if($post->post_type == 'product'){
                    $file = EXT_DIR .'/'. $name . '-product.php';
                }
            }
        }
        */
        return $file;
    }
    
    /**
     * Load script and style
     */
    public function load_scripts() {
        wp_dequeue_style('xcommerce');
        wp_dequeue_style('yythemes');
        wp_dequeue_script('yythemes');
        wp_enqueue_style('yythemes-ext', EXT_STATIC_URL . '/css/style.css', array(), filemtime(EXT_STATIC_DIR . '/css/style.css'));
    	wp_enqueue_script('yythemes-ext', EXT_STATIC_URL . '/js/script.js', array(), filemtime(EXT_STATIC_DIR . '/js/script.js'));
    	
    }

    /**
     * Filter default values
     */
    public function default_values($defaults){
    
        $defaults = [
            'main_color' => '#FF5E52',
            'dark_color' => '#f13c2f',
            'light_color'=> '#fc938b',
            'link_color' => '#555555',
            'bg_color'   => '#fafafa',
            'fg_color'   => '#333333',
            
            'hf_main_color' => '#FF5E52',
            'hf_dark_color' => '#f13c2f',
            'hf_light_color'=> '#fc938b',
            'hf_link_color' => '#555555',
            'hf_bg_color'   => '#ffffff',
            'hf_fg_color'   => '#333333',
            
            'page_width' => 1320,
            
        ];
        return $defaults;
    }
    
    /**
     * Filter post query args
     */
    public function modify_main_query( $query ) {
        if ( !is_admin() && $query->is_main_query() ) {
            if(is_front_page()){
                $query->set( 'post_type', 'product');
            }
            $query->set( 'orderby', 'modified');
            $query->set( 'posts_per_page', yy_get('resource_quantity'));
            
        }
    }
    
    
    public function rollbar(){
        ?>
        <script>
            jQuery(function($){
                $(".rollbar .scroll-top").on("click",function(){
    				$("body,html").animate({"scrollTop":0},500);
    			});
            });
        </script>
        <?php
        echo '<div class="rollbar md-down-none">';
        if ( yy_get( 'customer_service_qq' ) ) {
            $info = '<ul class="customer-service"><li><div class="icon"><i class="fa fa-qq" aria-hidden="true"></i></div><div class="text"><div class="t1">QQ:</div><div class="t2">'.yy_get('customer_service_qq').'</div></div></li></ul>';
			?>
			<div class="rollbar-item" title="<?php esc_attr_e( 'QQ customer service', 'onenice' ); ?>" data-toggle="qq-popover" data-placement="right" data-content='<?php echo $info?>' data-html="true"  data-trigger="hover" >
			    <i class="fa fa-qq"></i>
			</div>
			<?php

		}
		if ( yy_get( 'customer_service_wechat' ) ) {
		     $info = '<ul class="customer-service"><li><div class="icon"><i class="fa fa-weixin" aria-hidden="true"></i></div><div class="text"><div class="t1">'.__('Wechat', 'onenice').':</div><div class="t2">'.yy_get('customer_service_wechat').'</div></div></li></ul>';
			?>
			<div class="rollbar-item" title="<?php esc_attr_e( 'WeChat customer service', 'onenice' ); ?>" data-toggle="wechat-popover" data-placement="right" data-content='<?php echo $info?>' data-html="true"  data-trigger="hover" >
			    <i class="fa fa-weixin"></i>
			</div>
			<?php

		}
		if ( yy_get( 'enable_back_to_top' ) ) {
			?>
			<div class="rollbar-item scroll-top" title="<?php esc_attr_e( 'Back to top', 'onenice' ); ?>"><i class="fa fa-angle-up"></i></div>
			<?php

		}
		echo '</div>';
    }
    
}
