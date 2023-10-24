<?php
if(!defined('ABSPATH')) exit;
global $s;

?>
<div class="yy-site">
<div class="shade"></div>
<div class="yy-header">
    <div class="yy-group">
        <div class="navbar navbar-expand-md">
        	<div class="container">
        		<!-- Brand -->
        		<?php
        		$logo = yy_get( 'site_logo' );
        		if ( $logo ) :
        			?>
        		<a class="navbar-brand" href="<?php echo esc_attr( home_url() ); ?>"><h1><img class="logo" src="<?php echo esc_attr( $logo ); ?>" alt="<?php bloginfo( 'name' ); ?>" /></h1></a>
        		<?php else : ?>
        		<a class="navbar-brand" href="<?php echo esc_attr( home_url() ); ?>"><h1><?php bloginfo( 'name' ); ?></h1></a>
        		<?php endif; ?>
        		<!-- Toggler/collapsibe Button -->
        		<div class="menu-toggle d-md-none">
        		<i class="fa fa-bars"></i>
        		</div>
        		
        		<?php if ( yy_get( 'show_search' ) ) : ?>
                    <div class="search-toggle d-md-none">
            		<i class="fa fa-search"></i>
            		</div>
        		<?php else:?>
        		    <style>
        		        .yy-header .navbar .user-login {
                            right: 0px;
                        }
        		    </style>
                <?php endif; ?>
        		<!-- Navbar links -->
        		<div class="navbar-collapse menu-collapse d-md-flex justify-content-md-between">
        			<?php
        				wp_nav_menu(
        					array(
        						'fallback_cb'     => false,
        						'theme_location'  => 'main-menu',
        						'container_class' => 'main-menu',
        						'menu_class'      => 'navbar-nav',
        					)
        				);
        			?>
        		</div> 
        		<?php if ( yy_get( 'show_search' ) ) : ?>
    			<div class="d-md-flex justify-content-md-end">
    				<form class="search-form" method="get" onsubmit="return yy_check_search()" action="<?php echo esc_attr( home_url() ); ?>/" >
    					<div class="form-group">
    						<input id="wd" type="text" name="s" class="form-control keywords" placeholder="<?php echo yy_get('search_box_tips'); ?>" value="<?php echo empty($s) ?  '':esc_attr( $s ); ?>" />
    						<button type="submit" class="rounded submit">
    							<i class="fa fa-search"></i>
    						</button>
    					</div>
    				</form>
    			</div>
    			<?php endif; ?>
        		<?php
        		if ( yy_get( 'show_login_button' ) ) {
        			yy_login();}
        		?>
        	</div>
        </div><!-- navbar -->
    </div><!-- yy-group -->
</div><!-- yy-header -->
