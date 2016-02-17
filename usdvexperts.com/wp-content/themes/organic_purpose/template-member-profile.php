<?php
/**
 * Template name: Member Profile Steps
 */

if ( ! is_user_logged_in() ) {
    wp_redirect( get_site_url() );
}

$user = new WP_User( get_current_user_id() );

get_header('client'); ?>



<?php $thumb = ( '' != get_the_post_thumbnail() ) ? wp_get_attachment_image_src(get_post_thumbnail_id(), 'purpose-featured-large') : false; ?>

<div <?php post_class(); ?> id="page-<?php the_ID(); ?>">
    <div class="row">

        <div class="content<?php if (empty($thumb)) { ?> no-thumb<?php } ?>">
            <!-- BEGIN .three columns -->
            <div class="three columns">
            <?php get_sidebar('member'); ?>
            <!-- END .three columns -->
        </div>

        <!-- BEGIN .sixteen columns -->
        <div class="thirteen columns">
            <!--lang swicher-->
            <?php get_sidebar('language'); ?>
            <!-- BEGIN .postarea full -->
            <div class="postarea right member_registration_form clearfix profileContent">

                <?php if (!has_post_thumbnail()) { ?>
                    <h1 class="headline"><?php the_title(); ?></h1>
                <?php } ?>

                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <div class="steps_container"></div>
                    <?php the_content(); ?>
                <?php endwhile; endif; ?>
<!--                <div id="append"></div>-->

            </div>
        </div>
    </div>
</div>

<?php get_footer('client'); ?>