<?php get_header(); ?>

<?php if ( function_exists( 'giga_store_breadcrumb' ) && get_theme_mod( 'breadcrumbs-check', 1 ) != 0 ) {
	giga_store_breadcrumb();
} ?> 

<!-- start content container -->
<?php get_template_part( 'content', 'single' ); ?>
<!-- end content container -->

<?php

get_template_part( 'template-part', 'footernav' );

get_footer();
