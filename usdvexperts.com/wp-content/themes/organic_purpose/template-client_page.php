<?php
/**
 * Template Name: Member Page Template
 */
get_header('client');
global $wpdb;
$user_id = get_current_user_id();
if ($user_id == 0) {?>
    <script>
        window.location = "<?php echo esc_url(home_url('/')); ?>"; //redirect if email exists
    </script>
    <?php
}
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
            <!-- BEGIN .three columns -->
            <div class="three columns">
                <?php get_sidebar('member'); ?>
                <!-- END .three columns -->
            </div>

            <div class="thirteen columns">
                <!--lang swicher-->
                <?php get_sidebar('language'); ?>
                <!-- BEGIN .postarea full -->
                <div class="postarea right member_registration_form clearfix">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <?php //if (!has_post_thumbnail()) { ?>
                        <h1 class="headline headline2"><?php the_title(); ?></h1>
                    <?php //} ?>
                    <div class="article">
                        <?php the_content(); ?>
                    </div>
                    <div class="clear"></div>
<?php endwhile; endif; ?>
                </div>
                <!-- END .sixteen columns -->
            </div>

        </div>

    </div>
</div>
<?php get_footer('client');