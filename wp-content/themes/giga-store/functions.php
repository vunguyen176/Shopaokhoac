<?php
////////////////////////////////////////////////////////////////////
// Setting theme options
//////////////////////////////////////////////////////////////////// 
include_once( trailingslashit( get_template_directory() ) . 'lib/plugin-activation.php' );
include_once( trailingslashit( get_template_directory() ) . 'lib/theme-config.php' );
include_once( trailingslashit( get_template_directory() ) . 'lib/include-kirki.php' );
include_once( trailingslashit( get_template_directory() ) . 'lib/customizer.php' );

add_action( 'after_setup_theme', 'giga_store_setup' );

if ( !function_exists( 'giga_store_setup' ) ) :

	function giga_store_setup() {

		// Theme lang
		load_theme_textdomain( 'giga-store', get_template_directory() . '/languages' );

		// Add Title Tag Support
		add_theme_support( 'title-tag' );

		add_theme_support( 'custom-logo', array(
			'height'		 => 100,
			'width'			 => 400,
			'flex-height'	 => true,
			'flex-width'	 => true,
			'header-text'	 => array( 'site-title', 'site-description' ),
		) );

		// Register Menus
		register_nav_menus(
		array(
			'top_menu'		 => __( 'Top Menu', 'giga-store' ),
			'main_menu'		 => __( 'Main Menu', 'giga-store' ),
			'footer_menu'	 => __( 'Footer Menu', 'giga-store' ),
		)
		);

		// Add support for a featured image and the size
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 300, 300, true );
		add_image_size( 'giga-store-home', 400, 300, true );
		add_image_size( 'giga-store-square', 400, 400, true );
		add_image_size( 'giga-store-single', 1600, 400, true );
		
		// Add Custom Background Support
		$args = array(
			'default-color' => 'FFFFFF',
		);
		add_theme_support( 'custom-background', $args );

		// Adds RSS feed links to for posts and comments.
		add_theme_support( 'automatic-feed-links' );

		// WooCommerce support
		add_theme_support( 'woocommerce' );
	}

endif;

// Set Content Width
function giga_store_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'giga_store_content_width', 1170 );
}
add_action( 'after_setup_theme', 'giga_store_content_width', 0 );

////////////////////////////////////////////////////////////////////
// Enqueue Styles (normal style.css and bootstrap.css)
////////////////////////////////////////////////////////////////////
function giga_store_theme_stylesheets() {
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.css', array(), '3.3.6' );
	wp_enqueue_style( 'giga-store-stylesheet', get_stylesheet_uri(), array(), '1.0.4', 'all' );
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css', array(), '4.6.3' );
	wp_enqueue_style( 'flexslider', get_template_directory_uri() . '/css/flexslider.css', array(), '2.6.0' );
	wp_enqueue_style( 'of-canvas-menu', get_template_directory_uri() . '/css/jquery.mmenu.all.css', array(), '5.5.3' );
	wp_enqueue_style( 'animate', get_template_directory_uri() . '/css/animate.min.css', array(), '3.5.1' );
}

add_action( 'wp_enqueue_scripts', 'giga_store_theme_stylesheets' );

////////////////////////////////////////////////////////////////////
// Register Bootstrap JS with jquery
////////////////////////////////////////////////////////////////////
function giga_store_theme_js() {
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ), '3.3.6', true );
	wp_enqueue_script( 'giga-store-theme-js', get_template_directory_uri() . '/js/customscript.js', array( 'jquery' ), '1.0.2', true );
	wp_enqueue_script( 'flexslider', get_template_directory_uri() . '/js/jquery.flexslider-min.js', array( 'jquery' ), '2.6.0', true );
	wp_enqueue_script( 'of-canvas-menu', get_template_directory_uri() . '/js/jquery.mmenu.min.all.js', array( 'jquery' ), '5.5.3', true );
}

add_action( 'wp_enqueue_scripts', 'giga_store_theme_js' );


////////////////////////////////////////////////////////////////////
// Register Custom Navigation Walker include custom menu widget to use walkerclass
////////////////////////////////////////////////////////////////////

require_once( trailingslashit( get_template_directory() ) . 'lib/wp_bootstrap_navwalker.php' );

////////////////////////////////////////////////////////////////////
// Theme Info page
////////////////////////////////////////////////////////////////////

if ( is_admin() ) {
	require_once( trailingslashit( get_template_directory() ) . 'lib/theme-info.php' );
}

////////////////////////////////////////////////////////////////////
// Register the Sidebar(s)
////////////////////////////////////////////////////////////////////
add_action( 'widgets_init', 'giga_store_widgets_init' );

function giga_store_widgets_init() {
	register_sidebar(
	array(
		'name'			 => __( 'Right Sidebar', 'giga-store' ),
		'id'			 => 'giga-store-right-sidebar',
		'before_widget'	 => '<div id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</div>',
		'before_title'	 => '<h3 class="widget-title">',
		'after_title'	 => '</h3>',
	) );

	register_sidebar(
	array(
		'name'			 => __( 'Left Sidebar', 'giga-store' ),
		'id'			 => 'giga-store-left-sidebar',
		'before_widget'	 => '<div id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</div>',
		'before_title'	 => '<h3 class="widget-title">',
		'after_title'	 => '</h3>',
	) );

	register_sidebar(
	array(
		'name'			 => __( 'Footer Section', 'giga-store' ),
		'id'			 => 'giga-store-footer-area',
		'description'	 => __( 'Content Footer Section', 'giga-store' ),
		'before_widget'	 => '<div id="%1$s" class="widget %2$s col-md-3"><div class="widget-inner">',
		'after_widget'	 => '</div></div>',
		'before_title'	 => '<h3 class="widget-title">',
		'after_title'	 => '</h3>',
	) );
}

////////////////////////////////////////////////////////////////////
// Register hook and action to set Main content area col-md- width based on sidebar declarations
////////////////////////////////////////////////////////////////////

add_action( 'giga_store_main_content_width_hook', 'giga_store_main_content_width_columns' );

function giga_store_main_content_width_columns() {

	$columns = '12';

	if ( get_theme_mod( 'rigth-sidebar-check', 1 ) != 0 ) {
		$columns = $columns - absint( get_theme_mod( 'right-sidebar-size', 3 ) );
	}

	if ( get_theme_mod( 'left-sidebar-check', 0 ) != 0 ) {
		$columns = $columns - absint( get_theme_mod( 'left-sidebar-size', 3 ) );
	}

	echo absint( $columns );
}

////////////////////////////////////////////////////////////////////
// Breadcrumbs
////////////////////////////////////////////////////////////////////
if ( !function_exists( 'giga_store_breadcrumb' ) ) :

	function giga_store_breadcrumb() {
		global $post, $wp_query;

		$home		 = esc_html__( 'Home', 'giga-store' );
		$delimiter	 = ' &raquo; ';
		$homeLink	 = home_url();
		if ( is_home() || is_front_page() ) {

			// no need for breadcrumbs in homepage
		} else {
			echo '<div id="breadcrumbs" >';
			echo '<div class="breadcrumbs-inner container text-left">';

			// main breadcrumbs lead to homepage

			echo '<span><a href="' . esc_url( $homeLink ) . '">' . '<i class="fa fa-home"></i><span>' . $home . '</span>' . '</a></span>' . $delimiter . ' ';

			// if blog page exists

			if ( 'page' == get_option( 'show_on_front' ) && get_option( 'page_for_posts' ) ) {
				echo '<span><a href="' . esc_url( get_permalink( get_option( 'page_for_posts' ) ) ) . '">' . '<span>' . esc_html__( 'Blog', 'giga-store' ) . '</span></a></span>' . $delimiter . ' ';
			}

			if ( is_category() ) {
				$thisCat = get_category( get_query_var( 'cat' ), false );
				if ( $thisCat->parent != 0 ) {
					$category_link = get_category_link( $thisCat->parent );
					echo '<span><a href="' . esc_url( $category_link ) . '">' . '<span>' . get_cat_name( $thisCat->parent ) . '</span>' . '</a></span>' . $delimiter . ' ';
				}

				$category_id	 = get_cat_ID( single_cat_title( '', false ) );
				$category_link	 = get_category_link( $category_id );
				echo '<span><a href="' . esc_url( $category_link ) . '">' . '<span>' . single_cat_title( '', false ) . '</span>' . '</a></span>';
			} elseif ( is_single() && !is_attachment() ) {
				if ( get_post_type() != 'post' ) {
					$post_type	 = get_post_type_object( get_post_type() );
					$link		 = get_post_type_archive_link( get_post_type() );
					if ( $link ) {
						printf( '<span><a href="%s">%s</a></span>', esc_url( $link ), $post_type->labels->name );
						echo ' ' . $delimiter . ' ';
					}
					echo get_the_title();
				} else {
					$category = get_the_category();
					if ( $category ) {
						foreach ( $category as $cat ) {
							echo '<span><a href="' . esc_url( get_category_link( $cat->term_id ) ) . '">' . '<span>' . $cat->name . '</span>' . '</a></span>' . $delimiter . ' ';
						}
					}

					echo get_the_title();
				}
			} elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() && !is_search() && !is_author() ) {
				$post_type = get_post_type_object( get_post_type() );
				echo $post_type->labels->singular_name;
			} elseif ( is_attachment() ) {
				$parent = get_post( $post->post_parent );
				echo '<span><a href="' . esc_url( get_permalink( $parent ) ) . '">' . '<span>' . $parent->post_title . '</span>' . '</a></span>';
				echo ' ' . $delimiter . ' ' . get_the_title();
			} elseif ( is_page() && !$post->post_parent ) {
				echo '<span><a href="' . esc_url( get_permalink() ) . '">' . '<span>' . get_the_title() . '</span>' . '</a></span>';
			} elseif ( is_page() && $post->post_parent ) {
				$parent_id	 = $post->post_parent;
				$breadcrumbs = array();
				while ( $parent_id ) {
					$page			 = get_page( $parent_id );
					$breadcrumbs[]	 = '<span><a href="' . esc_url( get_permalink( $page->ID ) ) . '">' . '<span>' . get_the_title( $page->ID ) . '</span>' . '</a></span>';
					$parent_id		 = $page->post_parent;
				}

				$breadcrumbs = array_reverse( $breadcrumbs );
				for ( $i = 0; $i < count( $breadcrumbs ); $i++ ) {
					echo $breadcrumbs[ $i ];
					if ( $i != count( $breadcrumbs ) - 1 )
						echo ' ' . $delimiter . ' ';
				}

				echo $delimiter . '<span><a href="' . esc_url( get_permalink() ) . '">' . '<span>' . the_title_attribute( 'echo=0' ) . '</span>' . '</a></span>';
			}
			elseif ( is_tag() ) {
				$tag_id = get_term_by( 'name', single_cat_title( '', false ), 'post_tag' );
				if ( $tag_id ) {
					$tag_link = get_tag_link( $tag_id->term_id );
				}

				echo '<span><a href="' . esc_url( $tag_link ) . '">' . '<span>' . single_cat_title( '', false ) . '</span>' . '</a></span>';
			} elseif ( is_author() ) {
				global $author;
				$userdata = get_userdata( $author );
				echo '<span><a href="' . esc_url( get_author_posts_url( $userdata->ID ) ) . '">' . '<span>' . $userdata->display_name . '</span>' . '</a></span>';
			} elseif ( is_404() ) {
				echo esc_html__( 'Error 404', 'giga-store' );
			} elseif ( is_search() ) {
				echo esc_html__( 'Search results for', 'giga-store' ) . ' ' . get_search_query();
			} elseif ( is_day() ) {
				echo '<span><a href="' . esc_url( get_year_link( get_the_time( 'Y' ) ) ) . '">' . '<span>' . get_the_time( esc_html__( 'Y', 'giga-store' ) ) . '</span>' . '</a></span>' . $delimiter . ' ';
				echo '<span><a href="' . esc_url( get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) ) . '">' . '<span>' . get_the_time( esc_html__( 'F', 'giga-store' ) ) . '</span>' . '</a></span>' . $delimiter . ' ';
				echo '<span><a href="' . esc_url( get_day_link( get_the_time( 'Y' ), get_the_time( 'm' ), get_the_time( 'd' ) ) ) . '">' . '<span>' . get_the_time( esc_html__( 'd', 'giga-store' ) ) . '</span>' . '</a></span>';
			} elseif ( is_month() ) {
				echo '<span><a href="' . esc_url( get_year_link( get_the_time( 'Y' ) ) ) . '">' . '<span>' . get_the_time( esc_html__( 'Y', 'giga-store' ) ) . '</span>' . '</a></span>' . $delimiter . ' ';
				echo '<span><a href="' . esc_url( get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) ) . '">' . '<span>' . get_the_time( esc_html__( 'F', 'giga-store' ) ) . '</span>' . '</a></span>';
			} elseif ( is_year() ) {
				echo '<span><a href="' . esc_url( get_year_link( get_the_time( 'Y' ) ) ) . '">' . '<span>' . get_the_time( esc_html__( 'Y', 'giga-store' ) ) . '</span>' . '</a></span>';
			}

			if ( get_query_var( 'paged' ) ) {
				if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() )
					echo ' (';
				echo esc_html__( 'Page', 'giga-store' ) . ' ' . get_query_var( 'paged' );
				if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() )
					echo ')';
			}

			echo '</div></div>';
		}
	}

endif;

////////////////////////////////////////////////////////////////////
// Social links
////////////////////////////////////////////////////////////////////
if ( !function_exists( 'giga_store_social_links' ) ) :

	function giga_store_social_links() {
		$twp_social_links	 = array(
			'facebook'		 => 'Facebook',
			'twitter'		 => 'Twitter',
			'google-plus'	 => 'Google-Plus',
			'instagram'		 => 'Instagram',
			'pinterest-p'	 => 'Pinterest',
			'youtube'		 => 'YouTube',
			'reddit'		 => 'Reddit',
			'linkedin'		 => 'LinkedIn',
			'vimeo'			 => 'Vimeo',
			'envelope-o'	 => 'Email',
		);
		?>
		<div class="social-links">
			<ul>
				<?php
				$i					 = 0;
				$twp_links_output	 = '';
				foreach ( $twp_social_links as $key => $value ) {
					$link = get_theme_mod( $key, '' );
					if ( !empty( $link ) ) {
						$twp_links_output .=
						'<li><a href="' . esc_url( $link ) . '" title="' . esc_attr( $value ) . '" target="_blank"><i class="fa fa-' . strtolower( $key ) . '"></i></a></li>';
					}
					$i++;
				}
				echo $twp_links_output;
				?>
			</ul>
		</div><!-- .social-links -->
		<?php
	}

endif;

////////////////////////////////////////////////////////////////////
// Excerpt functions
////////////////////////////////////////////////////////////////////
function giga_store_excerpt_length( $length ) {
	return 20;
}

add_filter( 'excerpt_length', 'giga_store_excerpt_length', 999 );

function giga_store_excerpt_more( $more ) {
	return '&hellip;';
}

add_filter( 'excerpt_more', 'giga_store_excerpt_more' );

////////////////////////////////////////////////////////////////////
// Comment style
////////////////////////////////////////////////////////////////////
function giga_store_comment_text( $content ) {
    return "<div class=\"comment-inner\">" . $content . "</div>";
}
add_filter( 'comment_text', 'giga_store_comment_text', 1000 );

////////////////////////////////////////////////////////////////////
// WooCommerce section
////////////////////////////////////////////////////////////////////
if ( class_exists( 'WooCommerce' ) ) {

////////////////////////////////////////////////////////////////////
// WooCommerce header cart
////////////////////////////////////////////////////////////////////
	if ( !function_exists( 'giga_store_cart_link' ) ) {

		function giga_store_cart_link() {
			?>	
			<a class="cart-contents text-right" href="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" title="<?php esc_html_e( 'View your shopping cart', 'giga-store' ); ?>">
				<i class="fa fa-shopping-cart"><span class="count"><?php echo wp_kses_data( WC()->cart->get_cart_contents_count() ); ?></span></i><div class="amount-title"><?php echo esc_html_e( 'Cart ', 'giga-store' ); ?></div><div class="amount-cart"><?php echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?></div> 
			</a>
			<?php
		}

	}
	if ( !function_exists( 'giga_store_head_wishlist' ) ) {

		function giga_store_head_wishlist() {
			if ( function_exists( 'YITH_WCWL' ) ) {
				$wishlist_url = YITH_WCWL()->get_wishlist_url();
				?>
				<div class="top-wishlist text-right">
					<a href="<?php echo esc_url( $wishlist_url ); ?>" title="<?php esc_html_e( 'Wishlist', 'giga-store' ); ?>" data-toggle="tooltip" data-placement="top">
						<div class="fa fa-heart"><div class="count"><span><?php echo absint( yith_wcwl_count_products() ); ?></span></div></div>
					</a>
				</div>
				<?php
			}
		}

	}
	add_action( 'wp_ajax_yith_wcwl_update_single_product_list', 'giga_store_head_wishlist' );
	add_action( 'wp_ajax_nopriv_yith_wcwl_update_single_product_list', 'giga_store_head_wishlist' );

	if ( !function_exists( 'giga_store_header_cart' ) ) {

		function giga_store_header_cart() {
			?>
			<div class="header-cart text-right col-sm-5 text-center-sm text-center-xs no-gutter">
				<div class="header-cart-block">
					<div class="header-cart-inner">
						<?php giga_store_cart_link(); ?>
						<ul class="site-header-cart menu list-unstyled">
							<li>
								<?php the_widget( 'WC_Widget_Cart', 'title=' ); ?>
							</li>
						</ul>
					</div>
					<?php
					if ( get_theme_mod( 'wishlist-top-icon', 0 ) != 0 ) {
						giga_store_head_wishlist();
					}
					?>
				</div>
			</div>
			<?php
		}

	}
	if ( ! function_exists( 'giga_store_header_add_to_cart_fragment' ) ) {
		add_filter( 'woocommerce_add_to_cart_fragments', 'giga_store_header_add_to_cart_fragment' );

		function giga_store_header_add_to_cart_fragment( $fragments ) {
			ob_start();

			giga_store_cart_link();

			$fragments[ 'a.cart-contents' ] = ob_get_clean();

			return $fragments;
		}
	}
	
	add_filter( 'loop_shop_columns', 'giga_store_loop_columns' );
	
	if ( !function_exists( 'giga_store_loop_columns' ) ) {

		function giga_store_loop_columns() {
			return absint( get_theme_mod( 'archive_number_columns', 4 ) );
		}

	}
	
	add_filter( 'loop_shop_per_page', create_function( '$cols', 'return ' . absint( get_theme_mod( 'archive_number_products', 24 ) ) . ';' ), 20 );
	
}
