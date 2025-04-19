<?php

add_filter('xenice_commerce_templates_dir', function($dir){
    $dir = __DIR__ . '/templates';
	return $dir;
});

add_filter('xenice_commerce_options', function($options, $post_id){
    $options[] = [
        'id'   => 'verify_code',
        'name' => __('Verify code', 'onenice'),
        'type'  => 'text',
        'value' => get_post_meta($post_id, 'xc_verify_code', true)?:'',
    ];
    $options[] = [
        'id'   => 'version',
        'name' => __('Version', 'onenice'),
        'type'  => 'text',
        'value' => get_post_meta($post_id, 'xc_version', true)?:'',
    ];
    $options[] = [
        'id'   => 'free_download_url',
        'name' => __('Free download url', 'onenice'),
        'type'  => 'textarea',
        'rows' => 3,
        'value' => get_post_meta($post_id, 'xc_free_download_url', true)?:'',
    ];
    $options[] = [
        'id'   => 'demo_url',
        'name' => __('Demo url', 'onenice'),
        'type'  => 'textarea',
        'rows' => 3,
        'value' => get_post_meta($post_id, 'xc_demo_url', true)?:'',
    ];
    $options[] = [
        'id'   => 'service_info',
        'name' => __('Service infomation', 'onenice'),
        'desc' => __('Multiple are separated by commas', 'onenice'),
        'type' => 'textarea',
        'rows' => 3,
        'value' => get_post_meta($post_id, 'xc_service_info', true)
    ];
    return $options;
}, 10, 2);


add_filter('xenice_commerce_review_download_link', function($html, $post_id){
    $verify_code = get_post_meta($post_id, 'xc_verify_code', true);
    if($verify_code){
        $html .= sprintf('<span style="margin-left:5px;display:inline-block">%s <span>%s</span></span>', 
        __('Verification code:', 'onenice'), $verify_code);
    }
    return $html;
}, 10, 2);
