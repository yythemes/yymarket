<?php

namespace vessel;

define( 'HOME_URL', home_url( '', empty( $_SERVER['HTTPS'] ) ? 'http' : 'https' ) );
define( 'AUTHOR_URI', wp_get_theme()->get('AuthorURI'));
define( 'THEME_URI', wp_get_theme()->get('ThemeURI'));
define( 'THEME_NAME', 'yymarket' );
define( 'THEME_TITLE', 'YYMarket' );
define( 'THEME_VER', wp_get_theme()->get( 'Version' ) );
define( 'THEME_DIR', get_template_directory() );
define( 'THEME_URL', get_template_directory_uri());
define( 'STATIC_DIR', THEME_DIR . '/static' );
define( 'STATIC_URL', THEME_URL . '/static' );
define( 'AJAX_URL', admin_url( 'admin-ajax.php' ) );

spl_autoload_register('vessel\__autoload');

add_action('init', 'vessel\init');
add_action('after_setup_theme', 'vessel\active_theme');
add_action('admin_menu', 'vessel\admin_menu');

get('enable_theme_widgets') && new widgets\Widgets;
get('enable_theme_login_interface') && new login\Login;
get('enable_like') && new ajax\LikeAjax;



/**
 * Autoload class
 *
 * @param string $classname class name.
 */
function __autoload($classname){
    $classname = str_replace('\\','/',$classname);
    $vessel = 'vessel';
    if(strpos($classname, $vessel) === 0){
        $filename = str_replace($vessel, '', $classname);
        require  __DIR__ .  $filename . '.php';
    }
}

/**
 * Init
 * 
 */
function init(){
    load_theme_textdomain('onenice', THEME_DIR . '/languages/' );
}

/**
 * Active theme
 * 
 */
function active_theme(){
    
    global $pagenow;
    if('themes.php' == $pagenow && isset( $_GET['activated'])){
        $config = apply_filters('yy_config', null);
        if(!$config){
            $config = new Config;
        }
        $config->active();

        wp_redirect( admin_url( 'admin.php?page=yymarket'));
        exit;
    }
}


/**
 * Get option
 * 
 * @param string $name option name.
 */
function get($name, $key='xenice_yy'){
    static $option = [];
    if(!$option){
        $options = get_option($key)?:[];
        foreach($options as $o){
            $option = array_merge($option, $o);
        }
    }
    return $option[$name]??'';
}



/**
 * Set option
 * 
 * @param string $name option name.
 * @param string $value option value.
 */
function set($name, $value, $key='xenice_yy'){
    $options = get_option($key)?:[];
    foreach($options as $id=>&$o){
        if(isset($o[$name])){
            $o[$name] = $value;
            update_option($key, $options);
            return;
        }
    }
}


/**
 * Admin menu
 * 
 */
function admin_menu(){
    add_menu_page('YYMarket', 'YYMarket', 'manage_options', 'yymarket', '', 'dashicons-admin-customizer', 58);
    add_submenu_page('yymarket', esc_html__('Settings','onenice'), esc_html__('Settings','onenice'), 'manage_options', 'yymarket', function(){
        $config = apply_filters('yy_config', null);
        if(!$config){
            $config = new Config;
        }
        $config->show();
    });

    add_submenu_page('yymarket', esc_html__('Mail','onenice'), esc_html__('Mail','onenice'), 'manage_options', 'yymarket_mail', function(){
        (new mail\Config)->show();
    });

}

