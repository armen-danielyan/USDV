<?php


add_action( 'wp_ajax_us_ready_to_apply', 'usdv_ready_to_apply' );
add_action( 'wp_ajax_nopriv_us_ready_to_apply', 'usdv_ready_to_apply' );

function usdv_ready_to_apply() {

    if ( ! is_user_logged_in() ) {
        ajax_error( 'User is not logged in' );
    }

    $map = file_get_contents( get_template_directory_uri() . '/includes/gravityforms/map.profile.json' );
    if ( ! $map ) {
        ajax_error( 'Unable to read profile config file' );
    }

    $map = json_decode( $map, true );

    $user = new WP_User( get_current_user_id() );

    $option = get_option( '_transient_gfdp_1_' . $user->user_login );
    $option = json_decode( $option, true );


    $result = array();

    $result['step_1']['ready'] = '';
    $result['step_1']['title'] = 'General info';
    $result['step_1']['href']  = '<span id="step_1" class="step">%s</span>';

    $result['step_2']['ready'] = '<span class="ready">Ready to apply</span>';
    $result['step_2']['title'] = $option['input_'.$map['fields']['step_2']['first_name']] ? $option['input_'.$map['fields']['step_2']['first_name']] : '';
    $result['step_2']['href']  = '<span id="step_2" class="step">%s</span>';
    foreach( @$map['fields']['step_2']['required'] as $key=>$value ) {
        if ( !isset( $option['input_' . $value] ) or empty($option['input_' . $value]) ) {
            $result['step_2']['ready'] = '<span class="uncomplete">Incomplete</span>';
        }
    }

    $result['step_3']['ready'] = '<span class="ready">Ready to apply</span>';
    $result['step_3']['title'] = $option['input_'.$map['fields']['step_3']['first_name']] ? $option['input_'.$map['fields']['step_3']['first_name']] : 'Spouse';
    $result['step_3']['href']  = '<span id="step_3" class="step">%s</span>';
    foreach( @$map['fields']['step_3']['required'] as $key=>$value ) {
        if ( !isset( $option['input_' . $value] ) or empty($option['input_' . $value]) ) {
            $result['step_3']['ready'] = '<span class="uncomplete">Incomplete</span>';
        }
    }

    $result['step_4']['ready'] = '<span class="ready">Ready to apply</span>';
    $result['step_4']['title'] = $option['input_'.$map['fields']['step_4']['first_name']] ? $option['input_'.$map['fields']['step_4']['first_name']] : 'Child 1';
    $result['step_4']['href']  = '<span id="step_4" class="step">%s</span>';
    foreach( @$map['fields']['step_4']['required'] as $key=>$value ) {
        if ( !isset( $option['input_' . $value] ) or empty($option['input_' . $value]) ) {
            $result['step_4']['ready'] = '<span class="uncomplete">Incomplete</span>';
        }
    }

    $result['step_5']['ready'] = '<span class="ready">Ready to apply</span>';
    $result['step_5']['title'] = $option['input_'.$map['fields']['step_5']['first_name']] ? $option['input_'.$map['fields']['step_5']['first_name']] : 'Child 2';
    $result['step_5']['href']  = '<span id="step_5" class="step">%s</span>';
    foreach( @$map['fields']['step_5']['required'] as $key=>$value ) {
        if ( !isset( $option['input_' . $value] ) or empty($option['input_' . $value]) ) {
            $result['step_5']['ready'] = '<span class="uncomplete">Incomplete</span>';
        }
    }

    $result['step_6']['ready'] = '<span class="ready">Ready to apply</span>';
    $result['step_6']['title'] = $option['input_'.$map['fields']['step_6']['first_name']] ? $option['input_'.$map['fields']['step_6']['first_name']] : 'Child 3';
    $result['step_6']['href']  = '<span id="step_6" class="step">%s</span>';
    foreach( @$map['fields']['step_6']['required'] as $key=>$value ) {
        if ( !isset( $option['input_' . $value] ) or empty($option['input_' . $value]) ) {
            $result['step_6']['ready'] = '<span class="uncomplete">Incomplete</span>';
        }
    }

    $result['step_7']['ready'] = '<span class="ready">Ready to apply</span>';
    $result['step_7']['title'] = $option['input_'.$map['fields']['step_7']['first_name']] ? $option['input_'.$map['fields']['step_7']['first_name']] : 'Child 4';
    $result['step_7']['href']  = '<span id="step_7" class="step">%s</span>';
    foreach( @$map['fields']['step_7']['required'] as $key=>$value ) {
        if ( !isset( $option['input_' . $value] ) or empty($option['input_' . $value]) ) {
            $result['step_7']['ready'] = '<span class="uncomplete">Incomplete</span>';
        }
    }

    $result['step_8']['ready'] = '<span class="ready">Ready to apply</span>';
    $result['step_8']['title'] = $option['input_'.$map['fields']['step_8']['first_name']] ? $option['input_'.$map['fields']['step_8']['first_name']] : 'Child 5';
    $result['step_8']['href']  = '<span id="step_8" class="step">%s</span>';
    foreach( @$map['fields']['step_8']['required'] as $key=>$value ) {
        if ( !isset( $option['input_' . $value] ) or empty($option['input_' . $value]) ) {
            $result['step_8']['ready'] = '<span class="uncomplete">Incomplete</span>';
        }
    }

    $result['step_9']['ready'] = '<span class="ready">Ready to apply</span>';
    $result['step_9']['title'] = $option['input_'.$map['fields']['step_9']['first_name']] ? $option['input_'.$map['fields']['step_9']['first_name']] : 'Child 6';
    $result['step_9']['href']  = '<span id="step_9" class="step">%s</span>';
    foreach( @$map['fields']['step_9']['required'] as $key=>$value ) {
        if ( !isset( $option['input_' . $value] ) or empty($option['input_' . $value]) ) {
            $result['step_9']['ready'] = '<span class="uncomplete">Incomplete</span>';
        }
    }

    $result['step_10']['ready'] = '<span class="ready">Ready to apply</span>';
    $result['step_10']['title'] = $option['input_'.$map['fields']['step_10']['first_name']] ? $option['input_'.$map['fields']['step_10']['first_name']] : 'Child 7';
    $result['step_10']['href']  = '<span id="step_10" class="step">%s</span>';
    foreach( @$map['fields']['step_10']['required'] as $key=>$value ) {
        if ( !isset( $option['input_' . $value] ) or empty($option['input_' . $value]) ) {
            $result['step_10']['ready'] = '<span class="uncomplete">Incomplete</span>';
        }
    }

    $result['step_11']['ready'] = '<span class="ready">Ready to apply</span>';
    $result['step_11']['title'] = $option['input_'.$map['fields']['step_11']['first_name']] ? $option['input_'.$map['fields']['step_11']['first_name']] : 'Child 8';
    $result['step_11']['href']  = '<span id="step_11" class="step">%s</span>';
    foreach( @$map['fields']['step_11']['required'] as $key=>$value ) {
        if ( !isset( $option['input_' . $value] ) or empty($option['input_' . $value]) ) {
            $result['step_11']['ready'] = '<span class="uncomplete">Incomplete</span>';
        }
    }

    $result['step_12']['ready'] = '<span class="ready">Ready to apply</span>';
    $result['step_12']['title'] = $option['input_'.$map['fields']['step_12']['first_name']] ? $option['input_'.$map['fields']['step_12']['first_name']] : 'Child 9';
    $result['step_12']['href']  = '<span id="step_12" class="step">%s</span>';
    foreach( @$map['fields']['step_12']['required'] as $key=>$value ) {
        if ( !isset( $option['input_' . $value] ) or empty($option['input_' . $value]) ) {
            $result['step_12']['ready'] = '<span class="uncomplete">Incomplete</span>';
        }
    }

    $result['step_13']['ready'] = '<span class="ready">Ready to apply</span>';
    $result['step_13']['title'] = $option['input_'.$map['fields']['step_13']['first_name']] ? $option['input_'.$map['fields']['step_13']['first_name']] : 'Child 10';
    $result['step_13']['href']  = '<span id="step_13" class="step">%s</span>';
    foreach( @$map['fields']['step_13']['required'] as $key=>$value ) {
        if ( !isset( $option['input_' . $value] ) or empty($option['input_' . $value]) ) {
            $result['step_13']['ready'] = '<span class="uncomplete">Incomplete</span>';
        }
    }

    $result['step_14']['ready'] = '<span class="ready">Ready to apply</span>';
    $result['step_14']['title'] = $option['input_'.$map['fields']['step_14']['first_name']] ? $option['input_'.$map['fields']['step_14']['first_name']] : 'Child 11';
    $result['step_14']['href']  = '<span id="step_14" class="step">%s</span>';
    foreach( @$map['fields']['step_14']['required'] as $key=>$value ) {
        if ( !isset( $option['input_' . $value] ) or empty($option['input_' . $value]) ) {
            $result['step_14']['ready'] = '<span class="uncomplete">Incomplete</span>';
        }
    }

    $result['step_15']['ready'] = '<span class="ready">Ready to apply</span>';
    $result['step_15']['title'] = $option['input_'.$map['fields']['step_15']['first_name']] ? $option['input_'.$map['fields']['step_15']['first_name']] : 'Child 12';
    $result['step_15']['href']  = '<span id="step_15" class="step">%s</span>';
    foreach( @$map['fields']['step_15']['required'] as $key=>$value ) {
        if ( !isset( $option['input_' . $value] ) or empty($option['input_' . $value]) ) {
            $result['step_15']['ready'] = '<span class="uncomplete">Incomplete</span>';
        }
    }

    $result['step_16']['ready'] = '<span class="ready">Ready to apply</span>';
    $result['step_16']['title'] = $option['input_'.$map['fields']['step_16']['first_name']] ? $option['input_'.$map['fields']['step_16']['first_name']] : 'Child 13';
    $result['step_16']['href']  = '<span id="step_16" class="step">%s</span>';
    foreach( @$map['fields']['step_16']['required'] as $key=>$value ) {
        if ( !isset( $option['input_' . $value] ) or empty($option['input_' . $value]) ) {
            $result['step_16']['ready'] = '<span class="uncomplete">Incomplete</span>';
        }
    }

    $result['step_17']['ready'] = '<span class="ready">Ready to apply</span>';
    $result['step_17']['title'] = $option['input_'.$map['fields']['step_17']['first_name']] ? $option['input_'.$map['fields']['step_17']['first_name']] : 'Child 14';
    $result['step_17']['href']  = '<span id="step_17" class="step">%s</span>';
    foreach( @$map['fields']['step_17']['required'] as $key=>$value ) {
        if ( !isset( $option['input_' . $value] ) or empty($option['input_' . $value]) ) {
            $result['step_17']['ready'] = '<span class="uncomplete">Incomplete</span>';
        }
    }

    $result['step_18']['ready'] = '<span class="ready">Ready to apply</span>';
    $result['step_18']['title'] = $option['input_'.$map['fields']['step_18']['first_name']] ? $option['input_'.$map['fields']['step_18']['first_name']] : 'Child 15';
    $result['step_18']['href']  = '<span id="step_18" class="step">%s</span>';
    foreach( @$map['fields']['step_17']['required'] as $key=>$value ) {
        if ( !isset( $option['input_' . $value] ) or empty($option['input_' . $value]) ) {
            $result['step_18']['ready'] = '<span class="uncomplete">Incomplete</span>';
        }
    }

    $result['step_19']['ready'] = '<span class="ready">Ready to apply</span>';
    $result['step_19']['title'] = 'Contact info';
    $result['step_19']['href']  = '<span id="step_19" class="step">%s</span>';
    foreach( @$map['fields']['step_19']['required'] as $key=>$value ) {
        if ( !isset( $option['input_' . $value] ) or empty($option['input_' . $value]) ) {
            $result['step_19']['ready'] = '<span class="uncomplete">Incomplete</span>';
        }
    }

    if ( $option['input_'.$map['fields']['step_1']['married_status']] != 'Married' ) {
        unset($result['step_3']);
    }
    if ( $option['input_'.$map['fields']['step_1']['no_of_children']] < 1 ) {
        unset($result['step_4']);
        unset($result['step_5']);
        unset($result['step_6']);
        unset($result['step_7']);
        unset($result['step_9']);
        unset($result['step_10']);
        unset($result['step_11']);
        unset($result['step_12']);
        unset($result['step_13']);
        unset($result['step_14']);
        unset($result['step_15']);
        unset($result['step_16']);
        unset($result['step_17']);
        unset($result['step_18']);
    }
    if ( $option['input_'.$map['fields']['step_1']['no_of_children']] < 2 ) {
        unset($result['step_5']);
    }
    if ( $option['input_'.$map['fields']['step_1']['no_of_children']] < 3 ) {
        unset($result['step_6']);
    }
    if ( $option['input_'.$map['fields']['step_1']['no_of_children']] < 4 ) {
        unset($result['step_7']);
    }
    if ( $option['input_'.$map['fields']['step_1']['no_of_children']] < 5 ) {
        unset($result['step_8']);
    }
    if ( $option['input_'.$map['fields']['step_1']['no_of_children']] < 6 ) {
        unset($result['step_9']);
    }
    if ( $option['input_'.$map['fields']['step_1']['no_of_children']] < 7 ) {
        unset($result['step_10']);
    }
    if ( $option['input_'.$map['fields']['step_1']['no_of_children']] < 8 ) {
        unset($result['step_11']);
    }
    if ( $option['input_'.$map['fields']['step_1']['no_of_children']] < 9 ) {
        unset($result['step_12']);
    }
    if ( $option['input_'.$map['fields']['step_1']['no_of_children']] < 10 ) {
        unset($result['step_13']);
    }
    if ( $option['input_'.$map['fields']['step_1']['no_of_children']] < 11 ) {
        unset($result['step_14']);
    }
    if ( $option['input_'.$map['fields']['step_1']['no_of_children']] < 12 ) {
        unset($result['step_15']);
    }
    if ( $option['input_'.$map['fields']['step_1']['no_of_children']] < 13 ) {
        unset($result['step_16']);
    }
    if ( $option['input_'.$map['fields']['step_1']['no_of_children']] < 14 ) {
        unset($result['step_17']);
    }
    if ( $option['input_'.$map['fields']['step_1']['no_of_children']] < 15 ) {
        unset($result['step_18']);
    }

    ob_start();

    $n = 1;
    $html = '<ul>';
    foreach($result as $key=>$value) {
        $html.= '<li>' .sprintf( $value['href'], $n ). '<strong>'.$value['title'].'</strong><span>'.$value['ready'].'</span></li>';
        $n++;
    }
    $html.= '</ul>';

    $html.= '
    <script type="text/javascript">
    (function($) {
        var $step_1 = $("#step_1");
        var $step_2 = $("#step_2");
        var $step_3 = $("#step_3");
        var $step_4 = $("#step_4");
        var $step_5 = $("#step_5");
        var $step_6 = $("#step_6");
        var $step_7 = $("#step_7");
        var $step_8 = $("#step_8");
        var $step_9 = $("#step_9");
        var $step_10 = $("#step_10");
        var $step_11 = $("#step_11");
        var $step_12 = $("#step_12");
        var $step_13 = $("#step_13");
        var $step_14 = $("#step_14");
        var $step_15 = $("#step_15");
        var $step_16 = $("#step_16");
        var $step_17 = $("#step_17");
        var $step_18 = $("#step_18");
        var $step_19 = $("#step_19");

        $step_1.click(function() {
            $("#gform_target_page_number_1").val("1");
            $("#gform_1").trigger("submit",[true]);
        });
        $step_2.click(function() {
            $("#gform_target_page_number_1").val("2");
            $("#gform_1").trigger("submit",[true]);
        });
        $step_3.click(function() {
            $("#gform_target_page_number_1").val("3");
            $("#gform_1").trigger("submit",[true]);
        });
        $step_4.click(function() {
            $("#gform_target_page_number_1").val("4");
            $("#gform_1").trigger("submit",[true]);
        });
        $step_5.click(function() {
            $("#gform_target_page_number_1").val("5");
            $("#gform_1").trigger("submit",[true]);
        });
        $step_6.click(function() {
            $("#gform_target_page_number_1").val("6");
            $("#gform_1").trigger("submit",[true]);
        });
        $step_7.click(function() {
            $("#gform_target_page_number_1").val("7");
            $("#gform_1").trigger("submit",[true]);
        });
        $step_8.click(function() {
            $("#gform_target_page_number_1").val("8");
            $("#gform_1").trigger("submit",[true]);
        });
        $step_9.click(function() {
            $("#gform_target_page_number_1").val("9");
            $("#gform_1").trigger("submit",[true]);
        });
        $step_10.click(function() {
            $("#gform_target_page_number_1").val("10");
            $("#gform_1").trigger("submit",[true]);
        });
        $step_11.click(function() {
            $("#gform_target_page_number_1").val("11");
            $("#gform_1").trigger("submit",[true]);
        });
        $step_12.click(function() {
            $("#gform_target_page_number_1").val("12");
            $("#gform_1").trigger("submit",[true]);
        });
        $step_13.click(function() {
            $("#gform_target_page_number_1").val("13");
            $("#gform_1").trigger("submit",[true]);
        });
        $step_14.click(function() {
            $("#gform_target_page_number_1").val("14");
            $("#gform_1").trigger("submit",[true]);
        });
        $step_15.click(function() {
            $("#gform_target_page_number_1").val("15");
            $("#gform_1").trigger("submit",[true]);
        });
        $step_16.click(function() {
            $("#gform_target_page_number_1").val("16");
            $("#gform_1").trigger("submit",[true]);
        });
        $step_17.click(function() {
            $("#gform_target_page_number_1").val("17");
            $("#gform_1").trigger("submit",[true]);
        });
        $step_18.click(function() {
            $("#gform_target_page_number_1").val("18");
            $("#gform_1").trigger("submit",[true]);
        });
        $step_19.click(function() {
            $("#gform_target_page_number_1").val("19");
            $("#gform_1").trigger("submit",[true]);
        });


        $(".steps_container li").addClass("w_'.($n-1).'");

        var active_to = $("#gform_source_page_number_1").val();

        var n = 1;
        $(".steps_container li").each(function() {
            var $this = $(this);
            if ( n <= active_to ) {
                $this.addClass("active");
            }
            n = n+1;
        });

    })(jQuery);
    </script>';

    echo json_encode( $html, JSON_UNESCAPED_UNICODE );
    die();
}


function ajax_error( $message = '' ) {
    $result = array(
        'status' => 'error',
        'message' => $message,
    );
    echo json_encode( $result );
    die();
}

function ajax_ok( $message = '' ) {
    $result = array(
        'status' => 'ok',
        'message' => $message,
    );
    echo json_encode( $result );
    die();
}