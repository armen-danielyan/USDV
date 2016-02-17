<?php
/**
 * Template Name: Member Payment Page
 */
get_header();
global $wpdb;
?>

<?php $thumb = ( '' != get_the_post_thumbnail() ) ? wp_get_attachment_image_src(get_post_thumbnail_id(), 'purpose-featured-large') : false; ?>

<div <?php post_class(); ?> id="page-<?php the_ID(); ?>">
    <?php if ('' != get_the_post_thumbnail()) { ?>
        <div class="feature-img page-banner" <?php if (!empty($thumb)) { ?> style="background-image: url(<?php echo $thumb[0]; ?>);" <?php } ?>>
            <h1 class="headline img-headline"><?php the_title(); ?></h1>
            <?php the_post_thumbnail('purpose-featured-large'); ?>
        </div>
    <?php } ?>

    <div class="row">
        <div class="content<?php if (empty($thumb)) { ?> no-thumb<?php } ?>">

            <div class="sixteen columns">
                <!-- BEGIN .postarea full -->
                <div class="postarea member_registration_form clearfix">

                    <?php if (!has_post_thumbnail()) { ?>
                        <h1 class="headline"><?php the_title(); ?></h1>
                    <?php } ?>
                    <div class="article">
                       <h2>Update soon....</h2>
                    </div>
                    <div class="clear"></div>
                </div>
                <!-- END .sixteen columns -->
            </div>

        </div>

    </div>
</div>
<?php get_footer();