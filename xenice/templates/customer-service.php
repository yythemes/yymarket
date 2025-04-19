<?php 
if(!defined('ABSPATH')) exit;

$html  = '';
if(yy_get('customer_service_qq')){
    $html .= '<li><div class="icon"><i class="fa fa-qq" aria-hidden="true"></i></div><div class="text"><div class="t1">QQ:</div><div class="t2">'.yy_get('customer_service_qq').'</div></div></li>';
}
if(yy_get('customer_service_wechat')){
    $html .= '<li><div class="icon"><i class="fa fa-weixin" aria-hidden="true"></i></div><div class="text"><div class="t1">'.__('Wechat', 'onenice').':</div><div class="t2">'.yy_get('customer_service_wechat').'</div></div></li>';
}
$html  = '<ul class="customer-service">' . $html . '</ul>';

?>



<a class="btn btn-secondary" href="#" title="<?php echo esc_attr__('Contact Information', 'onenice')?>" data-toggle="popover" data-placement="bottom" data-content='<?php echo $html?>' data-html="true">
    <?php echo esc_html__('Contact customer service', 'onenice')?>
</a>