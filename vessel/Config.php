<?php
/**
 * @name        xenice options
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2019-09-26
 * @link        http://www.xenice.com/
 * @package     xenice
 */
 
namespace vessel;


class Config extends Options
{
    protected $key = 'yy';
    protected $name = ''; // Database option name
    protected $defaults = [];
    
    public function __construct()
    {
        // #FF5E52 #f13c2f #fc938b Red
		// #1fae67 #229e60 #35dc89 Green
		// #ff4979 #f2295e #fb94af Pink
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
        $this->name = 'xenice_' . $this->key;
        /**
    	 * Filter default values
    	 */
        $defaults = apply_filters('yy_default_values', $defaults);

        $this->defaults[] = [
            'id'=>'settings',
            'name'=> esc_html__('Theme settings','onenice'),
            'submit'=>esc_html__('Save Changes','onenice'),
            'title'=> esc_html__('Theme settings','onenice'),
            'tabs' => [
                [
                    'id' => 'global',
                    'title' => esc_html__('Global', 'onenice'),
                    'fields'=>[
                        [
                            'name' => esc_html__('Global Colors', 'onenice'),
                            'inline' => true,
                            'fields'=>[
                                [
                                    'id'   => 'main_color',
                                    'label' =>esc_html__('Main', 'onenice'),
                                    'type' => 'color',
                                    'value' => $defaults['main_color']
                                ],
                                [
                                    'id'   => 'dark_color',
                                    'label' =>esc_html__('Dark', 'onenice'),
                                    'type' => 'color',
                                    'value' => $defaults['dark_color']
                                ],
                                [
                                    'id'   => 'light_color',
                                    'label' =>esc_html__('Light', 'onenice'),
                                    'type' => 'color',
                                    'value' => $defaults['light_color']
                                ],
                                [
                                    'id'   => 'link_color',
                                    'label' =>esc_html__('Link', 'onenice'),
                                    'type' => 'color',
                                    'value' => $defaults['link_color']
                                ],
                                [
                                    'id'   => 'bg_color',
                                    'label' =>esc_html__('Background ', 'onenice'),
                                    'type' => 'color',
                                    'value' => $defaults['bg_color']
                                ],
                                [
                                    'id'   => 'fg_color',
                                    'label' =>esc_html__('Foreground', 'onenice'),
                                    'type' => 'color',
                                    'value' => $defaults['fg_color']
                                ],
                            ]
                        ],
                        [
                            'name' => esc_html__('Header and footer colors', 'onenice'),
                            'inline' => true,
                            'fields'=>[
                                [
                                    'id'   => 'hf_main_color',
                                    'label' =>esc_html__('Main', 'onenice'),
                                    'type' => 'color',
                                    'value' => $defaults['hf_main_color']
                                ],
                                [
                                    'id'   => 'hf_dark_color',
                                    'label' =>esc_html__('Dark', 'onenice'),
                                    'type' => 'color',
                                    'value' => $defaults['hf_dark_color']
                                ],
                                [
                                    'id'   => 'hf_light_color',
                                    'label' =>esc_html__('Light', 'onenice'),
                                    'type' => 'color',
                                    'value' => $defaults['hf_light_color']
                                ],
                                [
                                    'id'   => 'hf_link_color',
                                    'label' =>esc_html__('Link', 'onenice'),
                                    'type' => 'color',
                                    'value' => $defaults['hf_link_color']
                                ],
                                [
                                    'id'   => 'hf_bg_color',
                                    'label' =>esc_html__('Background ', 'onenice'),
                                    'type' => 'color',
                                    'value' => $defaults['hf_bg_color']
                                ],
                                [
                                    'id'   => 'hf_fg_color',
                                    'label' =>esc_html__('Foreground', 'onenice'),
                                    'type' => 'color',
                                    'value' => $defaults['hf_fg_color']
                                ],
                            ]
                        ],
                        [
                            'id'   => 'page_width',
                            'name' => esc_html__('Page Width', 'onenice'),
                            'type' => 'number',
                            'min'  =>0,
                            'label'=>'PX',
                            'value' => $defaults['page_width']
                        ],
                        [
                            'id'   => 'site_icon',
                            'name' => esc_html__('Site Icon', 'onenice'),
                            'type'  => 'img',
                            'value' => STATIC_URL . '/images/icon.ico'
                        ],
                        [
                            'id'   => 'static_lib_cdn',
                            'name' => esc_html__('Static library CDN', 'onenice' ),
                            'type' => 'select',
                            'opts' =>[
            					''                                  => esc_html__( 'Defalut', 'onenice' ),
            					'https://cdn.staticfile.org'        => 'https://cdn.staticfile.org',
            					'https://cdn.bootcdn.net/ajax/libs' => 'https://cdn.bootcdn.net/ajax/libs',
            					'https://libs.cdnjs.net'            => 'https://libs.cdnjs.net',
                            ],
                            'value' => ''
                        ],
                        [
                            'id'   => 'resource_quantity',
                            'name' => esc_html__('Display resource quantity', 'onenice'),
                            'type' => 'number',
                            'value' => 12,
                        ],
                        [
                            'name'=> esc_html__('Auxiliary functions', 'onenice'),
                            'fields'=>[
                                [
                                    'id'    => 'enable_theme_widgets',
                                    'label' => esc_html__('Enable theme widgets', 'onenice'),
                                    'type'  => 'checkbox',
                                    'value' => true
                                ],
                                [
                                    'id'    => 'enable_theme_login_interface',
                                    'label' => esc_html__('Enable theme login interface', 'onenice'),
                                    'type'  => 'checkbox',
                                    'value' => true
                                ],
                                [
                                    'id'    => 'single_enable_highlight',
                                    'label' => esc_html__('Enable Code Highlight', 'onenice'),
                                    'type'  => 'checkbox',
                                    'value' => true
                                ],
                                [
                                    'id'    => 'use_post_first_image_as_thumbnail',
                                    'label' => esc_html__('When the post does not have a thumbnail, use the first image of the post as a thumbnail', 'onenice'),
                                    'type'  => 'checkbox',
                                    'value' => true
                                ],
                                [
                                    'id'   => 'enable_css_animation',
                                    'type'  => 'checkbox',
                                    'value' => true,
                                    'label'  => esc_html__('Enable css animation', 'onenice')
                                ],
                                [
                                    'id'   => 'enable_like',
                                    'type'  => 'checkbox',
                                    'value' => true,
                                    'label'  => esc_html__('Give a like', 'onenice')
                                ],
                                [
                                    'id'   => 'enable_admin_download',
                                    'type'  => 'checkbox',
                                    'value' => false,
                                    'label'  => esc_html__('Administrators can download it directly.', 'onenice'),
                                ],
                                [
                                    'id'    => 'enable_back_to_top',
                                    'label' => esc_html__('Enable back to top button', 'onenice'),
                                    'type'  => 'checkbox',
                                    'value' => false
                                ],
                                
                                
                            ]
                        ],
                        
                    ]
                ],  #tab global
                [
                    'id' => 'header',
                    'title' => esc_html__('Header', 'onenice'),
                    'fields'=>[
                        [
                            'id'   => 'site_logo',
                            'name' => esc_html__('Site Logo', 'onenice'),
                            'type'  => 'img',
                            'value' => STATIC_URL . '/images/logo.png',
                        ],
                        [
                            'id'    => 'show_search',
                            'name'  => esc_html__('Show Search', 'onenice'),
                            'label' => esc_html__('Enable', 'onenice'),
                            'type'  => 'checkbox',
                            'value' => true
                        ],
                        [
                            'id'    => 'show_login_button',
                            'name'  => esc_html__('Show Login Button', 'onenice'),
                            'label' => esc_html__('Enable', 'onenice'),
                            'type'  => 'checkbox',
                            'value' => true
                        ],
                    ]
                ], #tab header
                [
                    'id' => 'footer',
                    'title' => esc_html__('Footer', 'onenice'),
                    'fields'=>[
                        [
                            'id'   => 'icp_number',
                            'name' => esc_html__('ICP Number', 'onenice'),
                            'type'  => 'text',
                            'value' => ''
                        ],
                        [
                            'id'    => 'delete_theme_copyright',
                            'name'  => esc_html__('Delete Theme Copyright', 'onenice'),
                            'label' => esc_html__('Enable', 'onenice'),
                            'type'  => 'checkbox',
                            'value' => false
                        ],
                        [
                            'id'    => 'footer_copyright_notice',
                            'name'  => esc_html__('Footer Copyright Notice', 'onenice'),
                            'desc'  => esc_html__('Add a copyright notice at the bottom of the website.', 'onenice'),
                            'type'  => 'textarea',
                            'rows'  => 4,
                            'value' => '',
                        ],
                    ]
                ], #tab footer
                [
                    'id' => 'slides',
                    'title' => esc_html__('Slides', 'onenice'),
                    'fields'=>[
                        [
                            'id'    => 'enable_slides',
                            'name'  => esc_html__('Slides', 'onenice'),
                            'label' => esc_html__('Enable', 'onenice'),
                            'type'  => 'checkbox',
                            'value' => true
                        ],
                        [
                            'id'   => 'slides',
                            'name' => esc_html__('Slides Settings', 'onenice'),
                            'type'  => 'slide',
                            'value' => [
                                [
                                    'url'=>'https://www.yythemes.com/',
                                    'src'=>STATIC_URL . '/images/placeholder-large.png',
                                    'title'=>esc_html__( 'OneNice Theme', 'onenice' ),
                                    'desc'=>esc_html__('OneNice is a super concise WordPress theme, supporting both Chinese and English, free open source, no encryption, no redundant code, no authorization restrictions, can be used freely.', 'onenice')
                                ],
                                [
                                    'url'=>'https://www.yythemes.com/',
                                    'src'=>STATIC_URL . '/images/placeholder-large.png',
                                    'title'=>esc_html__( 'OneNice Theme', 'onenice' ),
                                    'desc'=>esc_html__('OneNice is a super concise WordPress theme, supporting both Chinese and English, free open source, no encryption, no redundant code, no authorization restrictions, can be used freely.', 'onenice')
                                ],
                                [
                                    'url'=>'https://www.yythemes.com/',
                                    'src'=>STATIC_URL . '/images/placeholder-large.png',
                                    'title'=>esc_html__( 'OneNice Theme', 'onenice' ),
                                    'desc'=>esc_html__('OneNice is a super concise WordPress theme, supporting both Chinese and English, free open source, no encryption, no redundant code, no authorization restrictions, can be used freely.', 'onenice')
                                ],
                            ],
                        ],
                        
                    ]
                ], #tab slides
                [
                    'id' => 'home',
                    'title' => esc_html__('Home', 'onenice'),
                    'fields'=>[
                        [
                            'id'   => 'search_box_title',
                            'name' => esc_html__('Search box title', 'onenice'),
                            'type' => 'text',
                            'value' => __('Search website resources', 'onenice'),
                        ],
                        [
                            'id'   => 'search_box_description',
                            'name' => esc_html__('Search box description', 'onenice'),
                            'type' => 'textarea',
                            'rows' => 3,
                            'value' => __('YYSmarket is a virtual resource paid download mall theme developed by YYThemes', 'onenice')
                        ],
                        [
                            'id'   => 'search_box_tips',
                            'name' => esc_html__('Search box tips', 'onenice'),
                            'type' => 'text',
                            'value' => esc_html__( 'Search', 'onenice' )
                        ],
                        [
                            'id'   => 'last_published_alias',
                            'name' => esc_html__('Last published alias', 'onenice'),
                            'type' => 'text',
                            'value' => esc_html__('Latest publish', 'onenice'),
                        ],
                        [
                            'id'   => 'last_published_description',
                            'name' => esc_html__('Last published description', 'onenice'),
                            'type' => 'textarea',
                            'rows' => 3,
                            'value' => __('We will continue to update the latest hot resources and continue to provide you with more choices!', 'onenice')
                        ],
                        
                    ]
                ], #tab home
                [
                    'id' => 'archive',
                    'title' => esc_html__('Archive', 'onenice'),
                    'fields'=>[
                        [
                            'id'   => 'list_style',
                            'name' => esc_html__('List Style', 'onenice'),
                            'type' => 'radio',
                            'opts' =>[
            					'text' => esc_html__( 'Text', 'onenice' ),
            					'thumbnail' => esc_html__( 'Thumbnail', 'onenice' ),
                            ],
                            'value' => 'thumbnail'
                        ],
                        [
                            'id'   => 'excerpt_length',
                            'name' => esc_html__('Excerpt Length', 'onenice'),
                            'type' => 'number',
                            'min'  =>0,
                            'value' => 100,
                        ],
                        [
                            'id'   => 'site_thumbnail',
                            'name' => esc_html__('Site Thumbnail', 'onenice'),
                            'type'  => 'img',
                            'value' => STATIC_URL . '/images/thumbnail.png'
                        ],
                        [
                            'id'   => 'site_loading_image',
                            'name' => esc_html__('Site Loading Image', 'onenice'),
                            'type'  => 'img',
                            'value' => STATIC_URL . '/images/loading.png'
                        ],
                        [
                            'id'    => 'archive_show_date',
                            'name'  => esc_html__('Show Date', 'onenice'),
                            'label' => esc_html__('Enable', 'onenice'),
                            'type'  => 'checkbox',
                            'value' => true
                        ],
                        [
                            'id'    => 'archive_show_author',
                            'name'  => esc_html__('Show Author', 'onenice'),
                            'label' => esc_html__('Enable', 'onenice'),
                            'type'  => 'checkbox',
                            'value' => true
                        ],
                        
                    ]
                ], #tab archive
                [
                    'id' => 'posts',
                    'title' => esc_html__('Posts', 'onenice'),
                    'fields'=>[
                        [
                            'id'    => 'single_show_date',
                            'name'  => esc_html__('Show Date', 'onenice'),
                            'label' => esc_html__('Enable', 'onenice'),
                            'type'  => 'checkbox',
                            'value' => true
                        ],
                        [
                            'id'    => 'single_show_author',
                            'name'  => esc_html__('Show Author', 'onenice'),
                            'label' => esc_html__('Enable', 'onenice'),
                            'type'  => 'checkbox',
                            'value' => true
                        ],
                        [
                            'id'    => 'single_show_tags',
                            'name'  => esc_html__('Show Tags', 'onenice'),
                            'label' => esc_html__('Enable', 'onenice'),
                            'type'  => 'checkbox',
                            'value' => true
                        ],
                        [
                            'id'    => 'single_show_previous_next',
                            'name'  => esc_html__('Show Previous/Next Posts', 'onenice'),
                            'label' => esc_html__('Enable', 'onenice'),
                            'type'  => 'checkbox',
                            'value' => true
                        ],
                        [
                            'id'    => 'show_related_posts',
                            'name'  => esc_html__('Show Related Posts', 'onenice'),
                            'label' => esc_html__('Enable', 'onenice'),
                            'type'  => 'checkbox',
                            'value' => true
                        ],
                        [
                            'id'    => 'single_show_share',
                            'name'  => esc_html__('Show Share', 'onenice'),
                            'label' => esc_html__('Enable', 'onenice'),
                            'type'  => 'checkbox',
                            'value' => true
                        ],
                        [
                            'id'    => 'single_disable_share_buttons',
                            'name'  => esc_html__('Disable Share Buttons', 'onenice'),
                            'desc'  => esc_html__('weibo,wechat,qq,douban,qzone,tencent,linkedin,diandian,google,twitter,facebook', 'onenice'),
                            'type'  => 'textarea',
                            'rows'  => 4,
                            'value' => 'qzone,tencent,linkedin,diandian,google,twitter,facebook'
                        ],
                        [
                            'id'    => 'copyright_notice',
                            'name'  => esc_html__('Copyright Notice', 'onenice'),
                            'desc'  => esc_html__('Add a copyright notice at the bottom of the article.', 'onenice'),
                            'type'  => 'textarea',
                            'rows'  => 4,
                            'value' => esc_html__('All articles on this site, unless otherwise specified, are original publications of this site. If the content of this site violates your legitimate rights and interests, please contact us to deal with it.', 'onenice')
                        ],
                    ]
                ], #tab posts
                [
                    'id' => 'service',
                    'title' => esc_html__('Customer service', 'onenice'),
                    'fields'=>[
                        [
                            'id'    => 'enable_customer_service',
                            'name'  => esc_html__('Enable customer service', 'onenice'),
                            'label' => esc_html__('When enabled, a customer service button will be displayed on the details page.', 'onenice'),
                            'type'  => 'checkbox',
                            'value' => true
                        ],
                        [
                            'id'    => 'customer_service_qq',
                            'name'  => esc_html__('Customer service QQ', 'onenice'),
                            'type'  => 'text',
                            'value' => ''
                        ],
                        [
                            'id'    => 'customer_service_wechat',
                            'name'  => esc_html__('Customer service wechat', 'onenice'),
                            'type'  => 'text',
                            'value' => ''
                        ],
                    ]
                ]
            ] #tab posts
        ];
	    parent::__construct();
    }

}