<?php
get_header();

if ( function_exists( 'giga_store_breadcrumb' ) && get_theme_mod( 'breadcrumbs-check', 1 ) != 0 ) {
	giga_store_breadcrumb();
}
?>

<!-- start content container -->
<div class="row container rsrc-content">

	<?php get_sidebar( 'left' ); ?>

	<div class="col-md-<?php giga_store_main_content_width_columns(); ?> rsrc-main">
		<?php if ( have_posts() ) : ?>
			<h1 class="page-title text-center">
				<?php the_archive_title(); ?>
			</h1>

			<?php
			while ( have_posts() ) : the_post();
				get_template_part( 'content', get_post_format() );
			endwhile;
			?>
			<div class="footer-pagination"><?php the_posts_pagination(); ?></div>
			<?php
		else :
			get_404_template();
		endif;
		?>
	</div>

	<?php get_sidebar( 'right' ); ?>

</div>
<!-- end content container -->
<?php

get_template_part( 'template-part', 'footernav' );

get_footer();
