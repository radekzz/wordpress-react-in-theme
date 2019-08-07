<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( ! twentynineteen_can_show_post_thumbnail() ) : ?>
	<header class="entry-header">
	<script>
		/* 
		Pass data to 2. React app (works also for 1. React app)
		*/
    window.reactInit = {
			scriptData: "<?php echo get_template_directory_uri().'/myReactApp/'; ?>"
		};
</script>
		<?php get_template_part( 'template-parts/header/entry', 'header' ); ?>
		<?php
		
		/*
		Include 1. React app
		*/
// Register the script
wp_register_script( 'my-react-app', get_stylesheet_directory_uri() . '/js/my-react-app.js' );

// Localize the script with new data
$data_array = array(
	'yourName' => 'Radek',
	'yourWebsite' => 'http://www.mezulanik.cz',
);
//Pass data to Javascript
wp_localize_script( 'my-react-app', 'personData', json_encode($data_array) );

// Enqueued script with localized data.
wp_enqueue_script( 'my-react-app' );
		/*
		#Include 1. React app
		*/
		?>
	</header>
	<?php endif; ?>

	<div class="entry-content">
		<!-- 1. REACT APP -->
		<div id="myApp"></div>
		<!-- # 1. REACT APP -->
		<!-- 2. REACT APP -->
		<div id="root"></div>
		<!-- # 2. REACT APP -->
		<?php
		the_content();

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'twentynineteen' ),
				'after'  => '</div>',
			)
		);
		?>
	</div><!-- .entry-content -->

	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer">
			<?php
			edit_post_link(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Edit <span class="screen-reader-text">%s</span>', 'twentynineteen' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				),
				'<span class="edit-link">',
				'</span>'
			);
			?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->
<script crossorigin src="https://unpkg.com/react@16/umd/react.production.min.js"></script>
<script crossorigin src="https://unpkg.com/react-dom@16/umd/react-dom.production.min.js"></script>
<script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>