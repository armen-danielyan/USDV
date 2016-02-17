<?php
/**
 * Template Name: Member Profile Photo
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
    <style>
        #progress { position:relative; width:75%; border: 1x solid #dc9596; padding: 1px; border-radius: 3px;float: left;margin-bottom: 6px;display: none }
        #bar { background-color: #00a651; width:0%; height:8px; border-radius: 3px; }
        #percent { position:absolute; display:inline-block; top:-2px; left:48%;font-size: 10px;font-weight: 600 }
		.postarea.right{padding: 64px 9%;} 
		.sidebar{padding-bottom: 0px;}		
    </style>

    <script src="<?php echo get_template_directory_uri(); ?>/js/member/jquery.form.min.js" type="text/javascript"></script>
    <script>
        function uploadMemberPhoto(file){
            var reg=/(.jpg|.jpeg|.gif|.png|.zip|.pdf|.doc|.docx)$/;
            if (!reg.test(file)) {
                alert('Invalid File Type. ');
                return false;
            }

            jQuery("#member_photo_upload").ajaxSubmit({
                dataType: 'json',
                beforeSend: function()
                {
                    jQuery("#progress").show();
                    //clear everything
                    jQuery("#bar").width('0%');
                    jQuery("#message").html("");
                    jQuery("#percent").html("0%");
                },
                uploadProgress: function(event, position, total, percentComplete)
                {
                    jQuery("#bar").width(percentComplete+'%');
                    jQuery("#percent").html(percentComplete+'%');

                },
                complete: function(response)
                {
                    jQuery("#progress").hide();
                    jQuery("#bar").width('0%');
                    jQuery("#percent").html("0%");
                },
                success: function(data, statusText, xhr, wrapper){
                    setTimeout(function () {
                        jQuery("#attachmentMessage").html('');
                    }, 5000);
                    jQuery.each(data, function(index, value) {
                        if(value.status == 1){
                            jQuery("#imageSrc").attr("src",value.url);
                        }else if(value.status == 0){
                            alert('error');
                        }
                    });
                }

            });
        }
    </script>

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

                    <?php if (!has_post_thumbnail()) { ?>
                        <h1 class="headline headline2"><?php the_title(); ?></h1>
                    <?php } ?>
                    <div class="article">
                        <div id="progress">
                            <div id="bar"></div>
                            <div id="percent">0%</div >
                        </div>
                        <form style="" action="<?php echo admin_url( 'admin-ajax.php' ) ?>" id="member_photo_upload" name="member_photo_upload" enctype="multipart/form-data" method="post" role="application" class="wizard clearfix">
                            <input name="action" type="hidden" value="member_photo_upload" />
                            <table>
                                <tbody>
                                <tr>
                                    <td width="20%" style="text-align:center;"><?php echo get_user_meta($user_id, 'first_name', true).' '.get_user_meta($user_id, 'last_name', true); ?></td>
                                    <td width="50%" style="text-align:center;"><input name="photo" type="file" onchange="uploadMemberPhoto(this.value)"></td>
                                    <td width="30%" style="text-align:center;">
                                        <?php
                                        if(!$photo_url = get_user_meta($user_id, 'photo_url', true)){
                                            $photo_url = get_template_directory_uri().'/images/no_image.png';
                                        } ?>
                                        <img src="<?php echo $photo_url; ?>"  id="imageSrc" width="100"></td>
                                </tr>

                                </tbody>
                            </table>

                        </form>
                    </div>
                    <div class="clear"></div>
                </div>
                <!-- END .sixteen columns -->
            </div>

        </div>

    </div>
</div>
<?php get_footer('client');