<?php
/**
 * Displays content for front page
 *
 * @package Dokanee
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<section class="product-cat-section">
    <div class="grid-container">
        <h2 class="section-title"><?php _e( 'Products Category', 'dokanee' ); ?></h2>

        <div class="product-cat-wrapper">
            <?php

            $terms = get_terms( $args = array( 'taxonomy' => 'product_cat' ) );

            foreach ($terms as $term) {

                echo '<div class="product-cat-box">';

                woocommerce_subcategory_thumbnail( $term );

                echo '<h3 itemprop="name" class="product-title entry-title">'.$term->name.'</h3>';

                echo '<a href="' . esc_url( get_term_link( $term->term_id ) ) . '" class="btn btn-border btn-default">Show More <i class="fa fa-arrow-right"></i></a>';

                echo '</div>';
            }

            ?>
        </div>
    </div>
</section> <!-- .product-cat-section -->

<section class="products-section">
    <div class="grid-container container grid-parent">
        <div class="grid-parent mobile-grid-100 grid-75 tablet-grid-75">

	        <?php if ( function_exists( 'dokan_get_featured_products' ) ) { ?>
		        <?php if ( get_theme_mod( 'show_featured', 'on' ) == 'on' ) { ?>
                    <div class="slider-container woocommerce">
                        <h2 class="slider-heading"><?php _e( 'Featured Products', 'dokanee' ); ?></h2>

                        <div class="product-sliders flexslider">
                            <ul class="slides products">
						        <?php
						        $featured_query = dokan_get_featured_products();
						        ?>
						        <?php while ( $featured_query->have_posts() ) : $featured_query->the_post(); ?>

							        <?php wc_get_template_part( 'content', 'product' ); ?>

						        <?php endwhile; ?>
                            </ul>
                        </div>
                    </div> <!-- .slider-container -->
		        <?php } ?>
	        <?php } ?>

	        <?php do_action( 'dokan_home_after_featured' ); ?>

	        <?php if ( function_exists( 'dokan_get_latest_products' ) ) {
		        $show_latest = get_theme_mod( 'show_latest_pro', 'on' );
		        if ( $show_latest === true || $show_latest == 'on' ) {
			        ?>
                    <div class="slider-container woocommerce">
                        <h2 class="slider-heading"><?php _e( 'Latest Products', 'dokanee' ); ?></h2>

                        <div class="product-sliders flexslider">
                            <ul class="slides products">
						        <?php
						        $latest_query = dokan_get_latest_products();
						        ?>
						        <?php while ( $latest_query->have_posts() ) : $latest_query->the_post(); ?>

							        <?php wc_get_template_part( 'content', 'product' ); ?>

						        <?php endwhile; ?>
                            </ul>
                        </div>
                    </div> <!-- .slider-container -->
		        <?php } ?>
	        <?php } ?>

	        <?php if ( function_exists( 'dokan_get_best_selling_products' ) ) { ?>
		        <?php if ( get_theme_mod( 'show_best_selling', 'on' ) == 'on' ) { ?>
                    <div class="slider-container woocommerce">
                        <h2 class="slider-heading"><?php _e( 'Best Selling Products', 'dokanee' ); ?></h2>

                        <div class="product-sliders flexslider">
                            <ul class="slides products">
						        <?php
						        $best_selling_query = dokan_get_best_selling_products();
						        ?>
						        <?php while ( $best_selling_query->have_posts() ) : $best_selling_query->the_post(); ?>

							        <?php wc_get_template_part( 'content', 'product' ); ?>

						        <?php endwhile; ?>
                            </ul>
                        </div>
                    </div> <!-- .slider-container -->
		        <?php } ?>
	        <?php } ?>

        </div>
        <div class="widget-area grid-25 tablet-grid-25 grid-parent sidebar">
            <div class="inside-right-sidebar">
	            <?php dynamic_sidebar( 'home' ); ?>
            </div>
        </div>
    </div>
</section> <!-- .products-section -->

<section class="store-section">
    <div class="grid-container">
        <h2 class="section-title"><?php _e( 'Store List', 'dokanee' ); ?></h2>

        <div class="store-wrapper">
            <div class="tabs">
                <input type="radio" name="tabs" id="all-store" checked="checked">
                <label for="all-store">All</label>
                <div class="tab">
	                <?php
	                $new_sellers    = dokan()->vendor->all( array( 'number' => 8 ) );

	                $template_args = array(
		                'sellers'         => $new_sellers,
		                'limit'           => $limit,
		                'offset'          => $offset,
		                'paged'           => $paged,
		                'search_query'    => $search_query,
		                'pagination_base' => $pagination_base,
		                'per_row'         => 4,
		                'search_enabled'  => $search,
		                'image_size'      => $image_size,
	                );

	                dokan_get_template_part( 'new-store-lists-loop', false, $template_args );
	                ?>
                </div>

                <input type="radio" name="tabs" id="best-seller">
                <label for="best-seller">Best seller</label>
                <div class="tab">
	                <?php
	                $best_sellers = dokan_get_best_sellers(8);

	                $template_args = array(
		                'sellers'         => $best_sellers,
		                'limit'           => $limit,
		                'offset'          => $offset,
		                'paged'           => $paged,
		                'search_query'    => $search_query,
		                'pagination_base' => $pagination_base,
		                'per_row'         => 4,
		                'search_enabled'  => $search,
		                'image_size'      => $image_size,
	                );

	                ?>

	                <?php dokan_get_template_part( 'best-store-lists-loop', false, $template_args ); ?>
                </div>

                <input type="radio" name="tabs" id="featured-store">
                <label for="featured-store">Featured</label>
                <div class="tab">
	                <?php
	                $feature_sellers = dokan_get_feature_sellers(8);

	                $template_args = array(
		                'sellers'         => $feature_sellers,
		                'limit'           => $limit,
		                'offset'          => $offset,
		                'paged'           => $paged,
		                'search_query'    => $search_query,
		                'pagination_base' => $pagination_base,
		                'per_row'         => 4,
		                'search_enabled'  => $search,
		                'image_size'      => $image_size,
	                );

	                ?>

	                <?php dokan_get_template_part( 'featured-store-lists-loop', false, $template_args ); ?>
                </div>

                <input type="radio" name="tabs" id="latest-store">
                <label for="latest-store">New</label>

                <div class="tab">
                    <?php
                    $new_sellers    = dokan()->vendor->all( array( 'order' => 'DESC', 'number' => 8 ) );

                    $template_args = array(
	                    'sellers'         => $new_sellers,
	                    'limit'           => $limit,
	                    'offset'          => $offset,
	                    'paged'           => $paged,
	                    'search_query'    => $search_query,
	                    'pagination_base' => $pagination_base,
	                    'per_row'         => 4,
	                    'search_enabled'  => $search,
	                    'image_size'      => $image_size,
                    );

                    dokan_get_template_part( 'new-store-lists-loop', false, $template_args );
                    ?>
                </div>
            </div>
        </div>
    </div>
</section> <!-- .store-section -->