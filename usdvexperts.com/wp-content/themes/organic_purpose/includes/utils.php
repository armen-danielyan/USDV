<?php


/**
 * @param $str
 * @param string $comments
 */
function debug($str, $comments=""){
    echo "<pre style=\"border:1px solid #000000; color: #000000; background-color: #CDCDCD;\"><b>$comments</b>\n"; print_r($str); echo "\n</pre>\n<br />\n";
}

add_action('wp_head', 'usdv_ajaxurl' );
function usdv_ajaxurl() {
    ?>
    <script type="text/javascript">
        var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
    </script>
    <?php
}

function getAge( $dob ) {

    if ( !strlen( $dob ) ) {
        return '-';
    }
    //calculate years of age (input string: YYYY-MM-DD)
    list($year, $month, $day) = explode("-", $dob);

    $year_diff  = date("Y") - $year;
    $month_diff = date("m") - $month;
    $day_diff   = date("d") - $day;

    if ($day_diff < 0 || $month_diff < 0)
        $year_diff--;

    return $year_diff;
}

/**
 * @return bool
 */
function is_ready_to_apply() {

    $married_status   = get_user_meta( get_current_user_id(), 'married_status', true );
    $no_of_children   = get_user_meta( get_current_user_id(), 'no_of_children', true );
    $ready_collection = get_user_meta( get_current_user_id(), 'ready_to_apply', true );

    if ( !$married_status )   return false;
    if ( !$no_of_children )   return false;
    if ( !$ready_collection ) return false;

    $res = true;

    // Applicant ready check
    if ( !isset( $ready_collection['step_2'] ) or $ready_collection['step_2'] == 0 ) {
        $res = false;
    }

    // Spouse ready check
    if ( $married_status == 'Married' ) {
        if ( !isset( $ready_collection['step_3'] ) or $ready_collection['step_3'] == 0 ) {
            $res = false;
        }
    }

    // Children ready check
    $start = 4; // start of children step
    for ( $i = $start; $i < $start + $no_of_children - 1; $i++ ) {
        foreach ( $ready_collection as $item ) {
            if ( $item['step_'.$i] == 0 ) {
                $res = false; break;
            }
        }
    }

    // Address ready check
    if ( $ready_collection['step_19'] == 0 ) {
        $res = false;
    }

    return $res;
}


function is_photo_ready_to_apply() {

    $married_status   = get_user_meta( get_current_user_id(), 'married_status', true );
    $no_of_children   = get_user_meta( get_current_user_id(), 'no_of_children', true );

    if ( !$married_status )   return false;
    if ( !$no_of_children )   return false;

    $res = true;

    // Applicant photo ready check
    if ( ! get_user_meta( get_current_user_id(), 'photo_url', true ) ) {
        $res = false;
    }

    // Spouse photo ready check
    if ( $married_status ) {
        if ( ! get_user_meta( get_current_user_id(), 'spouse_photo_url', true ) ) {
            $res = false;
        }
    }


    // Children photo ready check
    if ( $no_of_children ) {
        for ( $i = 1; $i <= $no_of_children; $i++ ) {
            $child_photo = get_user_meta( get_current_user_id(), 'child_'.$i.'_photo_url', true );
            if ( !$child_photo ) {
                $res = false;
            }
        }
    }

    return $res;
}


/**
 * Step check ready to apply
 *
 * @param $required
 * @param $entry
 *
 * @return bool
 */
function step_check_ready( $required, $entry ) {

    $res = true;

    foreach ( $required as $item ) {
        foreach ( $entry as $key => $value ) {
            if ( $item == $key && !strlen( $value ) ) {
                $res = false; break;
            }
        }
    }

    return $res;
}



