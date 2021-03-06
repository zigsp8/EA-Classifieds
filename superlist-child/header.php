<?php
/**
 * The template for displaying header
 *
 * @package Superlist
 * @since Superlist 1.0.0
 */
/* mods:
 19may17 zig - remove archor nav for single listing
 31May17 zig - add braodstreet javascript
 5Nov19 zig - remove broadstreet javascript - using WP plugin with J2 method
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js" prefix="og: http://ogp.me/ns#">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <?php /* zig xout <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script> */ ?>
    <?php if ( is_singular() ) { wp_enqueue_script( 'comment-reply' ); } ?>

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php if ( function_exists( 'gtm4wp_the_gtm_tag' ) ) { gtm4wp_the_gtm_tag(); } ?>
<?php if ( class_exists( 'Inventor_Template_Loader' ) ) :   ?>
    <?php echo Inventor_Template_Loader::load( 'misc/messages' ); ?>
<?php endif; ?>

<div class="page-wrapper">
    <?php $header_type = get_theme_mod( 'superlist_general_header_type', 'header-regular' ); ?>
    <?php get_template_part( 'templates/header-types/' . $header_type ); ?>

    <?php if ( class_exists( 'Inventor_Post_Types' ) ) : ?>
        <?php $post_types = Inventor_Post_Types::get_listing_post_types(); ?>
        <?php if ( is_singular( $post_types ) ) : ?>
            <?php /* zig do we want the header?  get_template_part( 'templates/content-listing-banner' ); */  ?>

            <?php /* zig xout <div class="listing-detail-menu-wrapper">
                <div class="listing-detail-menu">
                    <div class="container">
                        <ul class="nav nav-pills"></ul>
                    </div><!-- /.container -->
                </div><!-- /.listing-detail-menu -->
            </div><!-- /.listing-detail-menu-wrapper --> */ ?>
        <?php endif; ?>
    <?php endif; ?>

    <div class="main">

        <?php dynamic_sidebar( 'top-fullwidth' ); ?>

        <div class="main-inner">
            <div class="container">
                <?php dynamic_sidebar( 'top' ); ?>
