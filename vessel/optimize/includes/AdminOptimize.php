<?php
namespace vessel\optimize\includes;

use function vessel\optimize_get as get;

class AdminOptimize
{
    public function __construct()
    {
        //Hide the Upgrade Notice to Recent Versions
        get('disable_update_remind') && add_filter( 'pre_site_transient_update_core', create_function( '$a', "return null;" ) );
		get('disable_post_revision') && remove_action('post_updated','wp_save_post_revision' );
		get('enable_empty_email_save') && add_action('user_profile_update_errors',[$this,'enableEmptyEmailSave'],10,3);
		get('remove_w_icon') && add_action('wp_before_admin_bar_render',[$this,'removeWIcon']);
		get('enable_link') && add_filter( 'pre_option_link_manager_enabled', '__return_true' );
		get('enable_code_escape') && add_filter( 'content_save_pre', [$this, 'replaceCodeTags'], 9 );
		if(get('remove_image_attribute')){
    		add_filter( 'post_thumbnail_html', [$this, 'removeImageAttribute'], 10 );
            add_filter( 'image_send_to_editor', [$this, 'removeImageAttribute'], 10 );
		}
		get('extend_class_editor_buttons') && add_action('after_wp_tiny_mce', [$this, 'tinyMceButtons']);
    }

	public function enableEmptyEmailSave($errors, $update, $user)
	{
	    if(isset($errors->errors['empty_email'])){
            unset($errors->errors['empty_email']);
            unset($errors->errors['empty_data']);
        }
	    
	}
	
	public function removeWIcon()
	{
        global $wp_admin_bar;
        $wp_admin_bar->remove_menu('wp-logo');
    }

    public function escapeCode($arr)
    {
    	$output = htmlspecialchars($arr[2], ENT_NOQUOTES, get_bloginfo('charset'), false); 
    	if (! empty($output)) {
    		return  $arr[1] . $output . $arr[3];
    	}
    	else
    	{
    		return  $arr[1] . $arr[2] . $arr[3];
    	}
    	
    }
    
    public function replaceCodeTags($data)
    {
    	$data = preg_replace_callback('@(<code.*>)(.*)(</code>)@isU', [$this,'escapeCode'], $data);
    	return $data;
    }
    
    public function removeImageAttribute( $html ) {
    	$html = preg_replace('/<img.+(src="?[^"]+"?)[^\/]+\/>/i',"<img \${1} />",$html);
    	return $html;
    }
    
    public function tinyMceButtons(){
        ?>
        <script>
            QTags.addButton( 'h4', 'h4', "<h4>", "</h4>");
            QTags.addButton( 'h5', 'h5', "<h5>", "</h5>");
            QTags.addButton( 'strong', 'strong', "<strong>", "</strong>");
            QTags.addButton( 'pre', 'pre', "<pre>", "</pre>");
            QTags.addButton( 'pre/code', 'pre/code', "<pre><code>", "</code></pre>");
        </script>
        
        <script>

            jQuery(document).ready(function($) {

                // 创建自定义按钮
                var customButton = '<input type="button" id="add_ul_li" class="ed_button button button-small" value="ul/li">';

                // 将按钮添加到工具栏
                $(customButton).appendTo('#ed_toolbar');

                // 按钮点击事件
                $(document).on('click', '#add_ul_li', function(e) {
                    e.preventDefault();
                    
                    // 获取编辑器对象
                    var editor = document.getElementById('content');

                    // 获取选定的文本
                    var selectedText = '';
                    if (window.getSelection) {
                        selectedText = window.getSelection().toString();
                    } else if (document.selection && document.selection.type != "Control") {
                        selectedText = document.selection.createRange().text;
                    }
    
                    // 按行分割文本
                    var lines = selectedText.split('\n');
    
                    // 添加li标签到每一行
                    var formattedText = '';
                    for (var i = 0; i < lines.length; i++) {
                        formattedText += '<li>' + lines[i] + '</li>\n';
                    }
    
                    // 替换选中的文本
                    if (document.execCommand) {
                        document.execCommand('insertText', false, '<ul>\n' + formattedText + '</ul>');
                    } else {
                        editor.setRangeText('<ul>\n' + formattedText + '</ul>');
                    }
                });
            });
        </script>
        <?php
    }
    
}