<?php 
if(!defined('ABSPATH')) exit;

use function xenice\commerce\get as get;
//use function xenice\commerce\get_vip_discount_text as get_vip_discount_text;

?>

<div class="flex">
  <div class="top">
    <h2 class="field post-title"><a href="<?php the_permalink()?>"
        title="<?php the_title()?>"><?php the_title()?></a>
        <?php if(xc_get_field(get_the_ID(),'version')):?>
        <span class="badge badge-secondary"><?php echo xc_get_field(get_the_ID(),'version');?></span>
        <?php endif;?>
    </h2>
    <div class="field excerpt"><?php the_excerpt()?></div>
    
    <div class="field price">
        <?php echo xc_get_price($post->ID)?>
        <?php
        /*
        $discount_text = get_vip_discount_text($post->ID);
        if($discount_text){?>
        <span class="badge badge-custom"><?php echo $discount_text ?></span>
        <?php } */ ?>
    </div>
    <div class="field buttons">
        <?php if(!empty(get_post_meta($post->ID, 'xc_regular_price', true))):?>
            <form id="formBuy" action="<?php echo xc_get_page_url('checkout')?>" method="post">
                <input type="hidden" name="buy" value="<?php echo $buy_nonce ?>">
                <input type="hidden" name="id" value="<?php echo $post->ID ?>" />
                <button class="btn btn-custom"><?php echo __('Buy Now', 'xenice-commerce') ?></button>
            </form>
        <?php endif;?>
        <?php do_action('yymarket_after_buy_now_button', $post->ID); ?>
        
        <?php
            // show admin download
            if(yy_get('enable_admin_download') && current_user_can('manage_options')){
                $data = [
                    'download_url'=>get_post_meta($post->ID, 'xc_download_url', true),
                    'verify_code'=>get_post_meta($post->ID, 'xc_verify_code', true),
                ];
                if(!empty($data['download_url'])){
                    echo '<a class="btn btn-danger" target="_blank" href="'.$data['download_url'].'">'.__('Administrator download', 'onenice') .'</a>';
                    if($data['verify_code']){
                        echo '<span style="margin-left:5px;display:inline-block">'.__('Verification code:', 'xenice-commerce').'<span>'.$data['verify_code'].'</span></span>';
                    }
                }
            }
        ?>
        
        <?php if(xc_get_field(get_the_ID(),'free_download_url')):?>
            <a class="btn btn-info" target="_blank" href="<?php echo xc_get_field(get_the_ID(),'free_download_url')?>">
                <?php echo esc_html__('Free download', 'onenice')?>
            </a>
        <?php endif;?>
        <?php if(xc_get_field(get_the_ID(),'demo_url')):?>
            <a class="btn btn-success" href="<?php echo xc_get_field(get_the_ID(),'demo_url')?>" target="_blank">
                <?php echo esc_html__('Demo url', 'onenice')?>
            </a>
        <?php endif;?>
        
        <?php 
            if(yy_get('enable_customer_service')){
                include __DIR__ . '/customer-service.php';
            }
        ?>
            
    </div>
    <?php 
    $info = get_post_meta($post->ID, 'xc_service_info', true);
    if($info){
        $str = '<div class="service"><ul>';
        $arr =  explode(',', $info);
        foreach($arr as $val){
            $str .= '<li><i class="fa fa-check"></i> '.$val.'</li>';
        }
        $str .= '</ul></div>';
        echo $str;
    }
    ?>
  </div> <!-- top -->
  <div class="bottom">
      <div class="cover">
          <?php 
            the_post_thumbnail();
          ?>
          <?php //do_action('yymarket_add_discount_text', $post->ID); ?>
      </div>
  </div>
</div> <!-- flex -->