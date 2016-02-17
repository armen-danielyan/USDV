<?php
require_once( dirname(__FILE__) . '/wp-load.php' );

if ($_POST['mrid']) {

    if(get_user_meta($_POST['mrid'], 'payment', true) == 1){?>
        <script>
            window.location = "<?php echo get_permalink(992); ?>";
        </script>
        <?php
    }else{?>
        <script>
            window.location = "<?php echo get_permalink(994); ?>";
        </script>
    <?php }
}