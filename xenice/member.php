<?php

add_action('wp_head', function($post_id){
    if(!function_exists('xm_is_member')) return;
?>
<style>
    .xc-vip-discount {
        color: #FF9800!important;
    }
    .xc-vip-discount-price{
        color: #FF9800!important;
    }
    .product-list .xc-vip-discount {
        color: #FF9800;
        font-size: 12px;
        margin-top:5px;
    }
</style>
<?php
    
});

add_action('yymarket_after_buy_now_button', function($post_id){
    if(!function_exists('xm_is_member')) return;
    
    $user_id = get_current_user_id();
    $vip_discount = get_post_meta($post_id, 'xc_vip_discount', true)?:0;
    if($vip_discount || !$user_id || !xm_is_member($user_id, 'vip')){
        $checkout_url = xenice\member\get_checkout_url();
        echo '<a class="btn btn-primary" href="'.$checkout_url.'">'.__('VIP download', 'onenice') .'</a>';
        return;
    }
    $download_url = get_post_meta($post_id, 'xc_download_url', true);
    $verify_code = get_post_meta($post_id, 'xc_verify_code', true);
     echo '<a class="btn btn-primary" target="_blank" href="'.$download_url.'">'.__('VIP download', 'onenice') .'</a>';
    if($verify_code){
        echo '<span style="margin-left:5px;display:inline-block">'.__('Verification code:', 'xenice-commerce').'<span>'.$verify_code.'</span></span>';
    }
    
});

/*
add_action('yymarket_add_discount_text', function($post_id){
    if(!function_exists('xm_is_member')) return;
    $vip_discount = get_post_meta($post_id, 'xc_vip_discount', true)?:0;
    if($vip_discount == 1) return;
    if($vip_discount == 0){
        echo '<div class="badge bg-warning bg-opacity-50">' .  __('VIP free', 'onenice') . '</div>';
    }
    else{
        echo '<div class="badge bg-warning bg-opacity-50">' .  ($vip_discount * 10) . __('折', 'onenice') . '</div>';
    }
    
});
*/