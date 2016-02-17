<?php


include ('class.usdv_form_base.php');
include ('class.usdv_form_profile.php');
include ('class.usdv_form_photo.php');
include ('class.usdv_form_cv.php');
include ('class.usdv_form_passport.php');


//function ajax_error( $message = '' ) {
//    $result = array(
//        'status' => 'error',
//        'message' => $message,
//    );
//    echo json_encode( $result );
//    die();
//}
//
//function ajax_ok( $message = '' ) {
//    $result = array(
//        'status' => 'ok',
//        'message' => $message,
//    );
//    echo json_encode( $result );
//    die();
//}
//
//
/**
 * @param $form_id
 *
 * @return array|bool|mixed|object|string
 */
function us_map_profile( $form_id ) {
    $map = file_get_contents( get_template_directory_uri() . '/includes/gravityforms/map.profile.json' );
    if ( !$map ) {
        return false;
    }
    $map = json_decode( $map, true );
    if ( $form_id != $map['form_id'] ) {
        return false;
    }
    return $map;
}


/**
 * @param $form_id
 *
 * @return array|bool|mixed|object|string
 */
function us_map_profile_admin( $form_id ) {
    $map = file_get_contents( get_template_directory_uri() . '/includes/gravityforms/map.profile.admin.json' );
    if ( !$map ) {
        return false;
    }
    $map = json_decode( $map, true );
    if ( $form_id != $map['form_id'] ) {
        return false;
    }
    return $map;
}


/**
 * @param $form_id
 *
 * @return array|bool|mixed|object|string
 */
function us_map_profile_photo( $form_id ) {
    $map = file_get_contents( get_template_directory_uri() . '/includes/gravityforms/map.profile.json' );
    if ( !$map ) {
        return false;
    }
    $map = json_decode( $map, true );
    if ( $form_id != $map['form_id'] ) {
        return false;
    }
    return $map;
}


/**
 * @param $form_id
 *
 * @return array|bool|mixed|object|string
 */
function us_map_profile_cv( $form_id ) {
    $map = file_get_contents( get_template_directory_uri() . '/includes/gravityforms/map.cv.json' );
    if ( !$map ) {
        return false;
    }
    $map = json_decode( $map, true );
    if ( $form_id != $map['form_id'] ) {
        return false;
    }
    return $map;
}


/**
 * @param $form_id
 *
 * @return array|bool|mixed|object|string
 */
function us_map_profile_passport( $form_id ) {
    $map = file_get_contents( get_template_directory_uri() . '/includes/gravityforms/map.passrorts.json' );
    if ( !$map ) {
        return false;
    }
    $map = json_decode( $map, true );
    if ( $form_id != $map['form_id'] ) {
        return false;
    }
    return $map;
}


// Photos
/**
 * @param $form
 * @return mixed
 */
//function usdv_render_form_photos( $form ) {
//    $map = file_get_contents( get_template_directory_uri() . '/includes/gravityforms/map.photo.json' );
//    if ( !$map ) {
//        return $form;
//    }
//
//    $map = json_decode( $map, true );
//
//    if ( $form['id'] != $map['form_id'] ) {
//        return $form;
//    }
//
//    foreach( $form['fields'] as &$field ) {
//        switch ( $field['id'] ) {
//
//            // Labels
//            case( $map['fields']['married_status'] ):
//                $field['defaultValue'] = get_user_meta( get_current_user_id(), 'married_status', true );
//                break;
//            case( $map['fields']['number_of_childs'] ):
//                $field['defaultValue'] = get_user_meta( get_current_user_id(), 'no_of_children', true );
//                break;
//            case( $map['fields']['my_photo'] ):
//                $field['label'] = (get_user_meta( get_current_user_id(), 'first_name', true ) && get_user_meta( get_current_user_id(), 'last_name', true )) ? get_user_meta( get_current_user_id(), 'first_name', true ) .' '. get_user_meta( get_current_user_id(), 'last_name', true ) : 'My photo';
//                break;
//            case( $map['fields']['spouse_photo'] ):
//                $field['label'] = (get_user_meta( get_current_user_id(), 'spouse_first_name', true ) && get_user_meta( get_current_user_id(), 'spouse_last_name', true )) ? get_user_meta( get_current_user_id(), 'spouse_first_name', true ) .' '. get_user_meta( get_current_user_id(), 'spouse_last_name', true ) : 'Spouse photo';
//                break;
//            case( $map['fields']['child_1_photo'] ):
//                $field['label'] = (get_user_meta( get_current_user_id(), 'child_1_first_name', true ) ) ? get_user_meta( get_current_user_id(), 'child_1_first_name', true ) : 'Child 1 photo';
//                break;
//            case( $map['fields']['child_2_photo'] ):
//                $field['label'] = (get_user_meta( get_current_user_id(), 'child_2_first_name', true ) ) ? get_user_meta( get_current_user_id(), 'child_2_first_name', true ) : 'Child 2 photo';
//                break;
//            case( $map['fields']['child_3_photo'] ):
//                $field['label'] = (get_user_meta( get_current_user_id(), 'child_3_first_name', true ) ) ? get_user_meta( get_current_user_id(), 'child_3_first_name', true ) : 'Child 3 photo';
//                break;
//            case( $map['fields']['child_4_photo'] ):
//                $field['label'] = (get_user_meta( get_current_user_id(), 'child_4_first_name', true ) ) ? get_user_meta( get_current_user_id(), 'child_4_first_name', true ) : 'Child 4 photo';
//                break;
//            case( $map['fields']['child_5_photo'] ):
//                $field['label'] = (get_user_meta( get_current_user_id(), 'child_5_first_name', true ) ) ? get_user_meta( get_current_user_id(), 'child_5_first_name', true ) : 'Child 5 photo';
//                break;
//
//            // Previews
//            case( $map['fields']['my_preview'] ):
//                $field['content'] = get_user_meta( get_current_user_id(), 'photo_url', true ) ? '<img width="150" height="150" src="'.get_user_meta( get_current_user_id(), 'photo_url', true ).'"/>' : '<img width="150" height="150" src="'.get_template_directory_uri() . '/images/no_image.png'.'" />';
//                break;
//            case( $map['fields']['spouse_preview'] ):
//                $field['content'] = get_user_meta( get_current_user_id(), 'spouse_photo_url', true ) ? '<img width="150" height="150" src="'.get_user_meta( get_current_user_id(), 'spouse_photo_url', true ).'"/>' : '<img width="150" height="150" src="'.get_template_directory_uri() . '/images/no_image.png'.'" />';
//                break;
//            case( $map['fields']['child_1_preview'] ):
//                $field['content'] = get_user_meta( get_current_user_id(), 'child_1_photo_url', true ) ? '<img width="150" height="150" src="'.get_user_meta( get_current_user_id(), 'child_1_photo_url', true ).'"/>' : '<img width="150" height="150" src="'.get_template_directory_uri() . '/images/no_image.png'.'" />';
//                break;
//            case( $map['fields']['child_2_preview'] ):
//                $field['content'] = get_user_meta( get_current_user_id(), 'child_2_photo_url', true ) ? '<img width="150" height="150" src="'.get_user_meta( get_current_user_id(), 'child_2_photo_url', true ).'"/>' : '<img width="150" height="150" src="'.get_template_directory_uri() . '/images/no_image.png'.'" />';
//                break;
//            case( $map['fields']['child_3_preview'] ):
//                $field['content'] = get_user_meta( get_current_user_id(), 'child_3_photo_url', true ) ? '<img width="150" height="150" src="'.get_user_meta( get_current_user_id(), 'child_3_photo_url', true ).'"/>' : '<img width="150" height="150" src="'.get_template_directory_uri() . '/images/no_image.png'.'" />';
//                break;
//            case( $map['fields']['child_4_preview'] ):
//                $field['content'] = get_user_meta( get_current_user_id(), 'child_4_photo_url', true ) ? '<img width="150" height="150" src="'.get_user_meta( get_current_user_id(), 'child_4_photo_url', true ).'"/>' : '<img width="150" height="150" src="'.get_template_directory_uri() . '/images/no_image.png'.'" />';
//                break;
//            case( $map['fields']['child_5_preview'] ):
//                $field['content'] = get_user_meta( get_current_user_id(), 'child_5_photo_url', true ) ? '<img width="150" height="150" src="'.get_user_meta( get_current_user_id(), 'child_5_photo_url', true ).'"/>' : '<img width="150" height="150" src="'.get_template_directory_uri() . '/images/no_image.png'.'" />';
//                break;
//        }
//    }
//
//    return $form;
//}
//add_filter( 'gform_pre_render', 'usdv_render_form_photos' );


/**
 * @param $entry
 * @param $form
 */
//function usdv_submission_form_photos( $entry, $form ) {
//    $map = file_get_contents( get_template_directory_uri() . '/includes/gravityforms/map.photo.json' );
//    if ( !$map ) {
//        return;
//    }
//
//    $map = json_decode( $map, true );
//
//    if ( $form['id'] != $map['form_id'] ) {
//        return;
//    }
//
//    foreach( $entry as $item ) {
//
//        if ( !empty( $entry[$map['fields']['my_photo']] )) {
//            update_user_meta( get_current_user_id(), 'photo_url', wp_make_link_relative( $entry[$map['fields']['my_photo']] ) );
//        }
//        if ( !empty( $entry[$map['fields']['spouse_photo']] )) {
//            update_user_meta( get_current_user_id(), 'spouse_photo_url', wp_make_link_relative( $entry[$map['fields']['spouse_photo']] ) );
//        }
//        if ( !empty( $entry[$map['fields']['child_1_photo']] )) {
//            update_user_meta( get_current_user_id(), 'child_1_photo_url', wp_make_link_relative( $entry[$map['fields']['child_1_photo']] ) );
//        }
//        if ( !empty( $entry[$map['fields']['child_2_photo']] )) {
//            update_user_meta( get_current_user_id(), 'child_2_photo_url', wp_make_link_relative( $entry[$map['fields']['child_2_photo']] ) );
//        }
//        if ( !empty( $entry[$map['fields']['child_3_photo']] )) {
//            update_user_meta( get_current_user_id(), 'child_3_photo_url', wp_make_link_relative( $entry[$map['fields']['child_3_photo']] ) );
//        }
//        if ( !empty( $entry[$map['fields']['child_4_photo']] )) {
//            update_user_meta( get_current_user_id(), 'child_4_photo_url', wp_make_link_relative( $entry[$map['fields']['child_4_photo']] ) );
//        }
//        if ( !empty( $entry[$map['fields']['child_5_photo']] )) {
//            update_user_meta( get_current_user_id(), 'child_5_photo_url', wp_make_link_relative( $entry[$map['fields']['child_5_photo']] ) );
//        }
//    }
//}
//add_action( 'gform_after_submission', 'usdv_submission_form_photos', 10, 2 );


//function usdv_confirmation_form_photos( $confirmation, $form, $entry ) {
//    $map = file_get_contents( get_template_directory_uri() . '/includes/gravityforms/map.photo.json' );
//    if ( !$map ) {
//        return;
//    }
//
//    $map = json_decode( $map, true );
//
//    if ( $form['id'] != $map['form_id'] ) {
//        return $confirmation;
//    }
//
//    $confirmation = array( 'redirect' => get_permalink(983) );
//    return $confirmation;
//}
//add_filter( 'gform_confirmation', 'usdv_confirmation_form_photos', 10, 3 );


//function profile_gform_pre_render( $form ) {
//    $map = file_get_contents( get_template_directory_uri() . '/includes/gravityforms/map.profile.json' );
//    if ( !$map ) {
//        return $form;
//    }
//
//    $map = json_decode( $map, true );
//
//    if ( $form['id'] != $map['form_id'] ) {
//        return $form;
//    }
//
//    $user = new WP_User( get_current_user_id() );
//    $user_id = (int)get_current_user_id();
//
//    foreach( $form['fields'] as &$field ) {
//        switch ( $field->id ) {
//
//            // Step 1
//            case( $map['fields']['step_1']['married_status'] ):
//                $field['defaultValue'] = get_user_meta( $user_id, 'married_status', true );
//                break;
//            case( $map['fields']['step_1']['no_of_children'] ):
//                $field['defaultValue'] = get_user_meta( $user_id, 'no_of_children', true );
//                break;
//
//            // Step 2
//            case( $map['fields']['step_2']['first_name'] ):
//                $field['defaultValue'] = get_user_meta( $user_id, 'first_name', true );
//                break;
//            case( $map['fields']['step_2']['middle_name'] ):
//                $field['defaultValue'] = get_user_meta( $user_id, 'middle_name', true );
//                break;
//            case( $map['fields']['step_2']['last_name'] ):
//                $field['defaultValue'] = get_user_meta( $user_id, 'last_name', true );
//                break;
//            case( $map['fields']['step_2']['birth_date'] ):
//                $timestamp = strtotime( get_user_meta( $user_id, 'birth_date', true ) );
//                foreach ( $field->inputs as &$input ) {
//                    switch ( $input['id'] ) {
//                        case( $map['fields']['step_2']['dob']['month'] ):
//                            $input['defaultValue'] = date( 'm', $timestamp );
//                            break;
//                        case( $map['fields']['step_2']['dob']['day'] ):
//                            $input['defaultValue'] = date( 'd', $timestamp );
//                            break;
//                        case( $map['fields']['step_2']['dob']['year'] ):
//                            $input['defaultValue'] = date( 'Y', $timestamp );
//                            break;
//                    }
//                }
//                break;
//            case( $map['fields']['step_2']['gender'] ):
//                $field['defaultValue'] = get_user_meta( $user_id, 'gender', true );
//                break;
//            case( $map['fields']['step_2']['birth_city'] ):
//                $field['defaultValue'] = get_user_meta( $user_id, 'birth_city', true );
//                break;
//            case( $map['fields']['step_2']['birth_country'] ):
//                $field['defaultValue'] = get_user_meta( $user_id, 'birth_country', true );
//                break;
//            case( $map['fields']['step_2']['education_level'] ):
//                $field['defaultValue'] = get_user_meta( $user_id, 'education_level', true );
//                break;
//            case( $map['fields']['step_2']['occupation'] ):
//                $field['defaultValue'] = get_user_meta( $user_id, 'occupation', true );
//                break;
//            case( $map['fields']['step_2']['work_experience'] ):
//                $field['defaultValue'] = get_user_meta( $user_id, 'work_experience', true );
//                break;
//            case( $map['fields']['step_2']['annual_income'] ):
//                $field['defaultValue'] = get_user_meta( $user_id, 'annual_income', true );
//                break;
//            case( $map['fields']['step_2']['english_level'] ):
//                $field['defaultValue'] = get_user_meta( $user_id, 'english_level', true );
//                break;
//
//            // Step 3
//            case( $map['fields']['step_3']['first_name'] ):
//                $field['defaultValue'] = get_user_meta( $user_id, 'spouse_first_name', true );
//                break;
//            case( $map['fields']['step_3']['middle_name'] ):
//                $field['defaultValue'] = get_user_meta( $user_id, 'spouse_middle_name', true );
//                break;
//            case( $map['fields']['step_3']['last_name'] ):
//                $field['defaultValue'] = get_user_meta( $user_id, 'spouse_last_name', true );
//                break;
//            case( $map['fields']['step_3']['birth_date'] ):
//                $timestamp = strtotime( get_user_meta( $user_id, 'spouse_birth_date', true ) );
//                foreach ( $field->inputs as &$input ) {
//                    switch ( $input['id'] ) {
//                        case( $map['fields']['step_3']['dob']['month'] ):
//                            $input['defaultValue'] = date( 'm', $timestamp );
//                            break;
//                        case( $map['fields']['step_3']['dob']['day'] ):
//                            $input['defaultValue'] = date( 'd', $timestamp );
//                            break;
//                        case( $map['fields']['step_3']['dob']['year'] ):
//                            $input['defaultValue'] = date( 'Y', $timestamp );
//                            break;
//                    }
//                }
//                break;
//            case( $map['fields']['step_3']['gender'] ):
//                $field['defaultValue'] = get_user_meta( $user_id, 'spouse_gender', true );
//                break;
//            case( $map['fields']['step_3']['birth_city'] ):
//                $field['defaultValue'] = get_user_meta( $user_id, 'spouse_birth_city', true );
//                break;
//            case( $map['fields']['step_3']['birth_country'] ):
//                $field['defaultValue'] = get_user_meta( $user_id, 'spouse_birth_country', true );
//                break;
//            case( $map['fields']['step_3']['education_level'] ):
//                $field['defaultValue'] = get_user_meta( $user_id, 'spouse_education_level', true );
//                break;
//            case( $map['fields']['step_3']['occupation'] ):
//                $field['defaultValue'] = get_user_meta( $user_id, 'spouse_occupation', true );
//                break;
//            case( $map['fields']['step_3']['work_experience'] ):
//                $field['defaultValue'] = get_user_meta( $user_id, 'spouse_work_experience', true );
//                break;
//            case( $map['fields']['step_3']['annual_income'] ):
//                $field['defaultValue'] = get_user_meta( $user_id, 'spouse_annual_income', true );
//                break;
//            case( $map['fields']['step_3']['english_level'] ):
//                $field['defaultValue'] = get_user_meta( $user_id, 'spouse_english_level', true );
//                break;
//
//            // Step 4
//            case( $map['fields']['step_4']['first_name'] ):
//                $field['defaultValue'] = get_user_meta( $user_id, 'child_1_first_name', true );
//                break;
//            case( $map['fields']['step_4']['last_name'] ):
//                $field['defaultValue'] = get_user_meta( $user_id, 'child_1_last_name', true );
//                break;
//            case( $map['fields']['step_4']['birth_date'] ):
//                $timestamp = strtotime( get_user_meta( $user_id, 'child_1_birth_date', true ) );
//                foreach ( $field->inputs as &$input ) {
//                    switch ( $input['id'] ) {
//                        case( $map['fields']['step_4']['dob']['month'] ):
//                            $input['defaultValue'] = date( 'm', $timestamp );
//                            break;
//                        case( $map['fields']['step_4']['dob']['day'] ):
//                            $input['defaultValue'] = date( 'd', $timestamp );
//                            break;
//                        case( $map['fields']['step_4']['dob']['year'] ):
//                            $input['defaultValue'] = date( 'Y', $timestamp );
//                            break;
//                    }
//                }
//                break;
//            case( $map['fields']['step_4']['gender'] ):
//                $field['defaultValue'] = get_user_meta( $user_id, 'child_1_gender', true );
//                break;
//            case( $map['fields']['step_4']['birth_city'] ):
//                $field['defaultValue'] = get_user_meta( $user_id, 'child_1_birth_city', true );
//                break;
//            case( $map['fields']['step_4']['birth_country'] ):
//                $field['defaultValue'] = get_user_meta( $user_id, 'child_1_birth_country', true );
//                break;
//
//            // Step 5
//            case( $map['fields']['step_5']['first_name'] ):
//                $field['defaultValue'] = get_user_meta( $user_id, 'child_2_first_name', true );
//                break;
//            case( $map['fields']['step_5']['last_name'] ):
//                $field['defaultValue'] = get_user_meta( $user_id, 'child_2_last_name', true );
//                break;
//            case( $map['fields']['step_5']['birth_date'] ):
//                $timestamp = strtotime( get_user_meta( $user_id, 'child_2_birth_date', true ) );
//                foreach ( $field->inputs as &$input ) {
//                    switch ( $input['id'] ) {
//                        case( $map['fields']['step_5']['dob']['month'] ):
//                            $input['defaultValue'] = date( 'm', $timestamp );
//                            break;
//                        case( $map['fields']['step_5']['dob']['day'] ):
//                            $input['defaultValue'] = date( 'd', $timestamp );
//                            break;
//                        case( $map['fields']['step_5']['dob']['year'] ):
//                            $input['defaultValue'] = date( 'Y', $timestamp );
//                            break;
//                    }
//                }
//                break;
//            case( $map['fields']['step_5']['gender'] ):
//                $field['defaultValue'] = get_user_meta( $user_id, 'child_2_gender', true );
//                break;
//            case( $map['fields']['step_5']['birth_city'] ):
//                $field['defaultValue'] = get_user_meta( $user_id, 'child_2_birth_city', true );
//                break;
//            case( $map['fields']['step_5']['birth_country'] ):
//                $field['defaultValue'] = get_user_meta( $user_id, 'child_2_birth_country', true );
//                break;
//
//            // Step 6
//            case( $map['fields']['step_6']['first_name'] ):
//                $field['defaultValue'] = get_user_meta( $user_id, 'child_3_first_name', true );
//                break;
//            case( $map['fields']['step_6']['last_name'] ):
//                $field['defaultValue'] = get_user_meta( $user_id, 'child_3_last_name', true );
//                break;
//            case( $map['fields']['step_6']['birth_date'] ):
//                $timestamp = strtotime( get_user_meta( $user_id, 'child_3_birth_date', true ) );
//                foreach ( $field->inputs as &$input ) {
//                    switch ( $input['id'] ) {
//                        case( $map['fields']['step_6']['dob']['month'] ):
//                            $input['defaultValue'] = date( 'm', $timestamp );
//                            break;
//                        case( $map['fields']['step_6']['dob']['day'] ):
//                            $input['defaultValue'] = date( 'd', $timestamp );
//                            break;
//                        case( $map['fields']['step_6']['dob']['year'] ):
//                            $input['defaultValue'] = date( 'Y', $timestamp );
//                            break;
//                    }
//                }
//                break;
//            case( $map['fields']['step_6']['gender'] ):
//                $field['defaultValue'] = get_user_meta( $user_id, 'child_3_gender', true );
//                break;
//            case( $map['fields']['step_6']['birth_city'] ):
//                $field['defaultValue'] = get_user_meta( $user_id, 'child_3_birth_city', true );
//                break;
//            case( $map['fields']['step_6']['birth_country'] ):
//                $field['defaultValue'] = get_user_meta( $user_id, 'child_3_birth_country', true );
//                break;
//
//            // Step 7
//            case( $map['fields']['step_7']['first_name'] ):
//                $field['defaultValue'] = get_user_meta( $user_id, 'child_4_first_name', true );
//                break;
//            case( $map['fields']['step_7']['last_name'] ):
//                $field['defaultValue'] = get_user_meta( $user_id, 'child_4_last_name', true );
//                break;
//            case( $map['fields']['step_7']['birth_date'] ):
//                $timestamp = strtotime( get_user_meta( $user_id, 'child_4_birth_date', true ) );
//                foreach ( $field->inputs as &$input ) {
//                    switch ( $input['id'] ) {
//                        case( $map['fields']['step_7']['dob']['month'] ):
//                            $input['defaultValue'] = date( 'm', $timestamp );
//                            break;
//                        case( $map['fields']['step_7']['dob']['day'] ):
//                            $input['defaultValue'] = date( 'd', $timestamp );
//                            break;
//                        case( $map['fields']['step_7']['dob']['year'] ):
//                            $input['defaultValue'] = date( 'Y', $timestamp );
//                            break;
//                    }
//                }
//                break;
//            case( $map['fields']['step_7']['gender'] ):
//                $field['defaultValue'] = get_user_meta( $user_id, 'child_4_gender', true );
//                break;
//            case( $map['fields']['step_7']['birth_city'] ):
//                $field['defaultValue'] = get_user_meta( $user_id, 'child_4_birth_city', true );
//                break;
//            case( $map['fields']['step_7']['birth_country'] ):
//                $field['defaultValue'] = get_user_meta( $user_id, 'child_4_birth_country', true );
//                break;
//
//            // Step 8
//            case( $map['fields']['step_8']['first_name'] ):
//                $field['defaultValue'] = get_user_meta( $user_id, 'child_5_first_name', true );
//                break;
//            case( $map['fields']['step_8']['last_name'] ):
//                $field['defaultValue'] = get_user_meta( $user_id, 'child_5_last_name', true );
//                break;
//            case( $map['fields']['step_8']['birth_date'] ):
//                $timestamp = strtotime( get_user_meta( $user_id, 'child_5_birth_date', true ) );
//                foreach ( $field->inputs as &$input ) {
//                    switch ( $input['id'] ) {
//                        case( $map['fields']['step_8']['dob']['month'] ):
//                            $input['defaultValue'] = date( 'm', $timestamp );
//                            break;
//                        case( $map['fields']['step_8']['dob']['day'] ):
//                            $input['defaultValue'] = date( 'd', $timestamp );
//                            break;
//                        case( $map['fields']['step_8']['dob']['year'] ):
//                            $input['defaultValue'] = date( 'Y', $timestamp );
//                            break;
//                    }
//                }
//                break;
//            case( $map['fields']['step_8']['gender'] ):
//                $field['defaultValue'] = get_user_meta( $user_id, 'child_5_gender', true );
//                break;
//            case( $map['fields']['step_8']['birth_city'] ):
//                $field['defaultValue'] = get_user_meta( $user_id, 'child_5_birth_city', true );
//                break;
//            case( $map['fields']['step_8']['birth_country'] ):
//                $field['defaultValue'] = get_user_meta( $user_id, 'child_5_birth_country', true );
//                break;
//
//            // Step 9
//            case( $map['fields']['step_19']['route'] ):
//                $field['defaultValue'] = get_user_meta( $user_id, 'route', true );
//                break;
//            case( $map['fields']['step_19']['street_number'] ):
//                $field['defaultValue'] = get_user_meta( $user_id, 'street_number', true );
//                break;
//            case( $map['fields']['step_19']['locality'] ):
//                $field['defaultValue'] = get_user_meta( $user_id, 'locality', true );
//                break;
//            case( $map['fields']['step_19']['district'] ):
//                $field['defaultValue'] = get_user_meta( $user_id, 'administrative_area_level_1', true );
//                break;
//            case( $map['fields']['step_19']['postal_code'] ):
//                $field['defaultValue'] = get_user_meta( $user_id, 'postal_code', true );
//                break;
//            case( $map['fields']['step_19']['country'] ):
//                $field['defaultValue'] = get_user_meta( $user_id, 'country', true );
//                break;
//            case( $map['fields']['step_19']['phone'] ):
//                $field['defaultValue'] = get_user_meta( $user_id, 'phone', true );
//                break;
//            case( $map['fields']['step_19']['email'] ):
//                $field['defaultValue'] = get_user_meta( $user_id, 'email', true );
//                break;
//            case( $map['fields']['step_19']['country_of_residence'] ):
//                $field['defaultValue'] = get_user_meta( $user_id, 'country_of_residence', true );
//                break;
//            case( $map['fields']['step_19']['eligibility'] ):
//                $field['defaultValue'] = get_user_meta( $user_id, 'eligibility', true );
//                break;
//        }
//    }
//
//    return $form;
//
//}
//add_filter( 'gform_pre_render', 'profile_gform_pre_render', 10 );





/**
 * @param $entry
 * @param $form
 */
//function us_save_applicant_meta( $entry, $form ) {
//
//    if ( is_admin() ) {
//        return;
//    }
//
//    $map = us_map_profile( $form['id'] );
//    if ( ! $map ) {
//        return;
//    }
//
//    $user_id = get_current_user_id();
//
//    $no_of_children = rgar( $entry, $map['fields']['step_1']['no_of_children'] );
//    $have_children = $no_of_children > 0 ? 'Yes' : 'No';
//
//    // Step 1
//    update_user_meta( $user_id, 'have_children'               , $have_children );
//    update_user_meta( $user_id, 'married_status'              , rgar( $entry, $map['fields']['step_1']['married_status'] ) );
//    update_user_meta( $user_id, 'no_of_children'              , rgar( $entry, $map['fields']['step_1']['no_of_children'] ) );
//
//    // Step 2
//    update_user_meta( $user_id, 'first_name'                  , rgar( $entry, $map['fields']['step_2']['first_name'] ) );
//    update_user_meta( $user_id, 'middle_name'                 , rgar( $entry, $map['fields']['step_2']['middle_name'] ) );
//    update_user_meta( $user_id, 'last_name'                   , rgar( $entry, $map['fields']['step_2']['last_name'] ) );
//    update_user_meta( $user_id, 'birth_date'                  , rgar( $entry, $map['fields']['step_2']['birth_date'] ) );
//    update_user_meta( $user_id, 'gender'                      , rgar( $entry, $map['fields']['step_2']['gender'] ) );
//    update_user_meta( $user_id, 'birth_city'                  , rgar( $entry, $map['fields']['step_2']['birth_city'] ) );
//    update_user_meta( $user_id, 'birth_country'               , rgar( $entry, $map['fields']['step_2']['birth_country'] ) );
//    update_user_meta( $user_id, 'education_level'             , rgar( $entry, $map['fields']['step_2']['education_level'] ) );
//    update_user_meta( $user_id, 'occupation'                  , rgar( $entry, $map['fields']['step_2']['occupation'] ) );
//    update_user_meta( $user_id, 'work_experience'             , rgar( $entry, $map['fields']['step_2']['work_experience'] ) );
//    update_user_meta( $user_id, 'annual_income'               , rgar( $entry, $map['fields']['step_2']['annual_income'] ) );
//    update_user_meta( $user_id, 'english_level'               , rgar( $entry, $map['fields']['step_2']['english_level'] ) );
//
//    // Step 3
//    update_user_meta( $user_id, 'spouse_first_name'           , rgar( $entry, $map['fields']['step_3']['first_name'] ) );
//    update_user_meta( $user_id, 'spouse_middle_name'          , rgar( $entry, $map['fields']['step_3']['middle_name'] ) );
//    update_user_meta( $user_id, 'spouse_last_name'            , rgar( $entry, $map['fields']['step_3']['last_name'] ) );
//    update_user_meta( $user_id, 'spouse_birth_date'           , rgar( $entry, $map['fields']['step_3']['birth_date'] ) );
//    update_user_meta( $user_id, 'spouse_gender'               , rgar( $entry, $map['fields']['step_3']['gender'] ) );
//    update_user_meta( $user_id, 'spouse_birth_city'           , rgar( $entry, $map['fields']['step_3']['birth_city'] ) );
//    update_user_meta( $user_id, 'spouse_birth_country'        , rgar( $entry, $map['fields']['step_3']['birth_country'] ) );
//    update_user_meta( $user_id, 'spouse_education_level'      , rgar( $entry, $map['fields']['step_3']['education_level'] ) );
//    update_user_meta( $user_id, 'spouse_occupation'           , rgar( $entry, $map['fields']['step_3']['occupation'] ) );
//    update_user_meta( $user_id, 'spouse_work_experience'      , rgar( $entry, $map['fields']['step_3']['work_experience'] ) );
//    update_user_meta( $user_id, 'spouse_annual_income'        , rgar( $entry, $map['fields']['step_3']['annual_income'] ) );
//    update_user_meta( $user_id, 'spouse_english_level'        , rgar( $entry, $map['fields']['step_3']['english_level'] ) );
//
//    // Step 4
//    update_user_meta( $user_id, 'child_1_first_name'          , rgar( $entry, $map['fields']['step_4']['first_name'] ) );
//    update_user_meta( $user_id, 'child_1_last_name'           , rgar( $entry, $map['fields']['step_4']['last_name'] ) );
//    update_user_meta( $user_id, 'child_1_birth_date'          , rgar( $entry, $map['fields']['step_4']['birth_date'] ) );
//    update_user_meta( $user_id, 'child_1_gender'              , rgar( $entry, $map['fields']['step_4']['gender'] ) );
//    update_user_meta( $user_id, 'child_1_birth_city'          , rgar( $entry, $map['fields']['step_4']['birth_city'] ) );
//    update_user_meta( $user_id, 'child_1_birth_country'       , rgar( $entry, $map['fields']['step_4']['birth_country'] ) );
//
//    // Step 5
//    update_user_meta( $user_id, 'child_2_first_name'          , rgar( $entry, $map['fields']['step_5']['first_name'] ) );
//    update_user_meta( $user_id, 'child_2_last_name'           , rgar( $entry, $map['fields']['step_5']['last_name'] ) );
//    update_user_meta( $user_id, 'child_2_birth_date'          , rgar( $entry, $map['fields']['step_5']['birth_date'] ) );
//    update_user_meta( $user_id, 'child_2_gender'              , rgar( $entry, $map['fields']['step_5']['gender'] ) );
//    update_user_meta( $user_id, 'child_2_birth_city'          , rgar( $entry, $map['fields']['step_5']['birth_city'] ) );
//    update_user_meta( $user_id, 'child_2_birth_country'       , rgar( $entry, $map['fields']['step_5']['birth_country'] ) );
//
//    // Step 6
//    update_user_meta( $user_id, 'child_3_first_name'          , rgar( $entry, $map['fields']['step_6']['first_name'] ) );
//    update_user_meta( $user_id, 'child_3_last_name'           , rgar( $entry, $map['fields']['step_6']['last_name'] ) );
//    update_user_meta( $user_id, 'child_3_birth_date'          , rgar( $entry, $map['fields']['step_6']['birth_date'] ) );
//    update_user_meta( $user_id, 'child_3_gender'              , rgar( $entry, $map['fields']['step_6']['gender'] ) );
//    update_user_meta( $user_id, 'child_3_birth_city'          , rgar( $entry, $map['fields']['step_6']['birth_city'] ) );
//    update_user_meta( $user_id, 'child_3_birth_country'       , rgar( $entry, $map['fields']['step_6']['birth_country'] ) );
//
//    // Step 7
//    update_user_meta( $user_id, 'child_4_first_name'          , rgar( $entry, $map['fields']['step_7']['first_name'] ) );
//    update_user_meta( $user_id, 'child_4_last_name'           , rgar( $entry, $map['fields']['step_7']['last_name'] ) );
//    update_user_meta( $user_id, 'child_4_birth_date'          , rgar( $entry, $map['fields']['step_7']['birth_date'] ) );
//    update_user_meta( $user_id, 'child_4_gender'              , rgar( $entry, $map['fields']['step_7']['gender'] ) );
//    update_user_meta( $user_id, 'child_4_birth_city'          , rgar( $entry, $map['fields']['step_7']['birth_city'] ) );
//    update_user_meta( $user_id, 'child_4_birth_country'       , rgar( $entry, $map['fields']['step_7']['birth_country'] ) );
//
//    // Step 8
//    update_user_meta( $user_id, 'child_5_first_name'          , rgar( $entry, $map['fields']['step_8']['first_name'] ) );
//    update_user_meta( $user_id, 'child_5_last_name'           , rgar( $entry, $map['fields']['step_8']['last_name'] ) );
//    update_user_meta( $user_id, 'child_5_birth_date'          , rgar( $entry, $map['fields']['step_8']['birth_date'] ) );
//    update_user_meta( $user_id, 'child_5_gender'              , rgar( $entry, $map['fields']['step_8']['gender'] ) );
//    update_user_meta( $user_id, 'child_5_birth_city'          , rgar( $entry, $map['fields']['step_8']['birth_city'] ) );
//    update_user_meta( $user_id, 'child_5_birth_country'       , rgar( $entry, $map['fields']['step_8']['birth_country'] ) );
//
//    // Step 9
//    update_user_meta( $user_id, 'route'                       , rgar( $entry, $map['fields']['step_9']['route'] ) );
//    update_user_meta( $user_id, 'street_number'               , rgar( $entry, $map['fields']['step_9']['street_number'] ) );
//    update_user_meta( $user_id, 'locality'                    , rgar( $entry, $map['fields']['step_9']['locality'] ) );
//    update_user_meta( $user_id, 'administrative_area_level_1' , rgar( $entry, $map['fields']['step_9']['district'] ) );
//    update_user_meta( $user_id, 'postal_code'                 , rgar( $entry, $map['fields']['step_9']['postal_code'] ) );
//    update_user_meta( $user_id, 'country'                     , rgar( $entry, $map['fields']['step_9']['country'] ) );
//    update_user_meta( $user_id, 'phone'                       , rgar( $entry, $map['fields']['step_9']['phone'] ) );
//    update_user_meta( $user_id, 'email'                       , rgar( $entry, $map['fields']['step_9']['email'] ) );
//    update_user_meta( $user_id, 'country_of_residence'        , rgar( $entry, $map['fields']['step_9']['country_of_residence'] ) );
//
//}
//add_action( 'gform_after_submission', 'us_save_applicant_meta', 10, 2 );


/**
 * @description passport scan upload form render
 *
 * @param $form
 *
 * @return mixed
 */
//function us_passport_upload_form_render( $form ) {
//    $map = us_map_profile_passport( $form['id'] );
//    if ( !$map ) {
//        return $form;
//    }
//
//    foreach ( $form['fields'] as &$field ) {
//        switch ( $field['id'] ) {
//            // Labels
//            case( $map['fields']['married_status'] ):
//                $field['defaultValue'] = get_user_meta( get_current_user_id(), 'married_status', true );
//                break;
//            case( $map['fields']['number_of_childs'] ):
//                $field['defaultValue'] = get_user_meta( get_current_user_id(), 'no_of_children', true );
//                break;
//            case( $map['fields']['my_passport'] ):
//                $field['label'] = (get_user_meta( get_current_user_id(), 'first_name', true ) && get_user_meta( get_current_user_id(), 'last_name', true )) ? get_user_meta( get_current_user_id(), 'first_name', true ) .' '. get_user_meta( get_current_user_id(), 'last_name', true ) : 'My passport';
//                break;
//            case( $map['fields']['spouse_passport'] ):
//                $field['label'] = (get_user_meta( get_current_user_id(), 'spouse_first_name', true ) && get_user_meta( get_current_user_id(), 'spouse_last_name', true )) ? get_user_meta( get_current_user_id(), 'spouse_first_name', true ) .' '. get_user_meta( get_current_user_id(), 'spouse_last_name', true ) : 'Spouse passport';
//                break;
//            case( $map['fields']['child_1_passport'] ):
//                $field['label'] = (get_user_meta( get_current_user_id(), 'child_1_first_name', true ) ) ? get_user_meta( get_current_user_id(), 'child_1_first_name', true ) : 'Child 1 passport';
//                break;
//            case( $map['fields']['child_2_passport'] ):
//                $field['label'] = (get_user_meta( get_current_user_id(), 'child_2_first_name', true ) ) ? get_user_meta( get_current_user_id(), 'child_2_first_name', true ) : 'Child 2 passport';
//                break;
//            case( $map['fields']['child_3_passport'] ):
//                $field['label'] = (get_user_meta( get_current_user_id(), 'child_3_first_name', true ) ) ? get_user_meta( get_current_user_id(), 'child_3_first_name', true ) : 'Child 3 passport';
//                break;
//            case( $map['fields']['child_4_passport'] ):
//                $field['label'] = (get_user_meta( get_current_user_id(), 'child_4_first_name', true ) ) ? get_user_meta( get_current_user_id(), 'child_4_first_name', true ) : 'Child 4 passport';
//                break;
//            case( $map['fields']['child_5_passport'] ):
//                $field['label'] = (get_user_meta( get_current_user_id(), 'child_5_first_name', true ) ) ? get_user_meta( get_current_user_id(), 'child_5_first_name', true ) : 'Child 5 passport';
//                break;
//
//            // Previews
//            case( $map['fields']['my_preview'] ):
//                $field['content'] = get_user_meta( get_current_user_id(), 'passport_url', true ) ? '<img width="150" height="150" src="'.get_user_meta( get_current_user_id(), 'passport_url', true ).'"/>' : '<img width="150" height="150" src="'.get_template_directory_uri() . '/images/no_image.png'.'" />';
//                break;
//            case( $map['fields']['spouse_preview'] ):
//                $field['content'] = get_user_meta( get_current_user_id(), 'spouse_passport_url', true ) ? '<img width="150" height="150" src="'.get_user_meta( get_current_user_id(), 'spouse_passport_url', true ).'"/>' : '<img width="150" height="150" src="'.get_template_directory_uri() . '/images/no_image.png'.'" />';
//                break;
//            case( $map['fields']['child_1_preview'] ):
//                $field['content'] = get_user_meta( get_current_user_id(), 'child_1_passport_url', true ) ? '<img width="150" height="150" src="'.get_user_meta( get_current_user_id(), 'child_1_passport_url', true ).'"/>' : '<img width="150" height="150" src="'.get_template_directory_uri() . '/images/no_image.png'.'" />';
//                break;
//            case( $map['fields']['child_2_preview'] ):
//                $field['content'] = get_user_meta( get_current_user_id(), 'child_2_passport_url', true ) ? '<img width="150" height="150" src="'.get_user_meta( get_current_user_id(), 'child_2_passport_url', true ).'"/>' : '<img width="150" height="150" src="'.get_template_directory_uri() . '/images/no_image.png'.'" />';
//                break;
//            case( $map['fields']['child_3_preview'] ):
//                $field['content'] = get_user_meta( get_current_user_id(), 'child_3_passport_url', true ) ? '<img width="150" height="150" src="'.get_user_meta( get_current_user_id(), 'child_3_passport_url', true ).'"/>' : '<img width="150" height="150" src="'.get_template_directory_uri() . '/images/no_image.png'.'" />';
//                break;
//            case( $map['fields']['child_4_preview'] ):
//                $field['content'] = get_user_meta( get_current_user_id(), 'child_4_passport_url', true ) ? '<img width="150" height="150" src="'.get_user_meta( get_current_user_id(), 'child_4_passport_url', true ).'"/>' : '<img width="150" height="150" src="'.get_template_directory_uri() . '/images/no_image.png'.'" />';
//                break;
//            case( $map['fields']['child_5_preview'] ):
//                $field['content'] = get_user_meta( get_current_user_id(), 'child_5_passport_url', true ) ? '<img width="150" height="150" src="'.get_user_meta( get_current_user_id(), 'child_5_passport_url', true ).'"/>' : '<img width="150" height="150" src="'.get_template_directory_uri() . '/images/no_image.png'.'" />';
//                break;
//        }
//    }
//
//    return $form;
//}
//add_filter( 'gform_pre_render_11', 'us_passport_upload_form_render' );


/**
 * @description CV upload form update user meta
 *
 * @param $entry
 * @param $form
 *
 * @return mixed
 */
function us_passport_upload_form_submission( $entry, $form ) {
    $map = us_map_profile_passport( $form['id'] );
    if ( !$map ) {
        return;
    }

    if ( rgar( $entry, $map['fields']['my_passport'] ) )      update_user_meta( get_current_user_id(), 'passport_url'         , rgar( $entry, $map['fields']['my_passport'] ) );
    if ( rgar( $entry, $map['fields']['spouse_passport'] ) )  update_user_meta( get_current_user_id(), 'spouse_passport_url'  , rgar( $entry, $map['fields']['spouse_passport'] ) );
    if ( rgar( $entry, $map['fields']['child_1_passport'] ) ) update_user_meta( get_current_user_id(), 'child_1_passport_url' , rgar( $entry, $map['fields']['child_1_passport'] ) );
    if ( rgar( $entry, $map['fields']['child_2_passport'] ) ) update_user_meta( get_current_user_id(), 'child_2_passport_url' , rgar( $entry, $map['fields']['child_2_passport'] ) );
    if ( rgar( $entry, $map['fields']['child_3_passport'] ) ) update_user_meta( get_current_user_id(), 'child_3_passport_url' , rgar( $entry, $map['fields']['child_3_passport'] ) );
    if ( rgar( $entry, $map['fields']['child_4_passport'] ) ) update_user_meta( get_current_user_id(), 'child_4_passport_url' , rgar( $entry, $map['fields']['child_4_passport'] ) );
    if ( rgar( $entry, $map['fields']['child_5_passport'] ) ) update_user_meta( get_current_user_id(), 'child_5_passport_url' , rgar( $entry, $map['fields']['child_5_passport'] ) );
}
add_action( 'gform_after_submission', 'us_passport_upload_form_submission', 10, 2 );


/**
 * @description CV upload form confirmation url
 *
 * @param $confirmation
 * @param $form
 * @param $entry
 *
 * @return array
 */
function us_passport_upload_form_confirmation( $confirmation, $form, $entry ) {
    $confirmation = array( 'redirect' => $_SERVER['REQUEST_URI'] );
    return $confirmation;
}
add_filter( 'gform_confirmation_11', 'us_passport_upload_form_confirmation', 10, 3 );



/**
 * @description CV upload form render
 *
 * @param $form
 *
 * @return mixed
 */
//function us_cv_upload_form_render( $form ) {
//    $map = us_map_profile_cv( $form['id'] );
//    if ( !$map ) {
//        return $form;
//    }
//
//    foreach ( $form['fields'] as &$field ) {
//        switch ( $field['id'] ) {
//            // Labels
//            case( $map['fields']['married_status'] ):
//                $field['defaultValue'] = get_user_meta( get_current_user_id(), 'married_status', true );
//                break;
//            case( $map['fields']['number_of_childs'] ):
//                $field['defaultValue'] = get_user_meta( get_current_user_id(), 'no_of_children', true );
//                break;
//            case( $map['fields']['my_cv'] ):
//                $field['label'] = (get_user_meta( get_current_user_id(), 'first_name', true ) && get_user_meta( get_current_user_id(), 'last_name', true )) ? get_user_meta( get_current_user_id(), 'first_name', true ) .' '. get_user_meta( get_current_user_id(), 'last_name', true ) : 'My passport';
//                break;
//            case( $map['fields']['spouse_cv'] ):
//                $field['label'] = (get_user_meta( get_current_user_id(), 'spouse_first_name', true ) && get_user_meta( get_current_user_id(), 'spouse_last_name', true )) ? get_user_meta( get_current_user_id(), 'spouse_first_name', true ) .' '. get_user_meta( get_current_user_id(), 'spouse_last_name', true ) : 'Spouse passport';
//                break;
//            case( $map['fields']['child_1_cv'] ):
//                $field['label'] = (get_user_meta( get_current_user_id(), 'child_1_first_name', true ) ) ? get_user_meta( get_current_user_id(), 'child_1_first_name', true ) : 'Child 1 passport';
//                break;
//            case( $map['fields']['child_2_cv'] ):
//                $field['label'] = (get_user_meta( get_current_user_id(), 'child_2_first_name', true ) ) ? get_user_meta( get_current_user_id(), 'child_2_first_name', true ) : 'Child 2 passport';
//                break;
//            case( $map['fields']['child_3_cv'] ):
//                $field['label'] = (get_user_meta( get_current_user_id(), 'child_3_first_name', true ) ) ? get_user_meta( get_current_user_id(), 'child_3_first_name', true ) : 'Child 3 passport';
//                break;
//            case( $map['fields']['child_4_cv'] ):
//                $field['label'] = (get_user_meta( get_current_user_id(), 'child_4_first_name', true ) ) ? get_user_meta( get_current_user_id(), 'child_4_first_name', true ) : 'Child 4 passport';
//                break;
//            case( $map['fields']['child_5_cv'] ):
//                $field['label'] = (get_user_meta( get_current_user_id(), 'child_5_first_name', true ) ) ? get_user_meta( get_current_user_id(), 'child_5_first_name', true ) : 'Child 5 passport';
//                break;
//
//            // Previews
//            case( $map['fields']['my_preview'] ):
//                $field['content'] = get_user_meta( get_current_user_id(), 'cv_url', true ) ? '<a href="'.get_user_meta( get_current_user_id(), 'cv_url', true ).'">Download</a>' : '';
//                break;
//            case( $map['fields']['spouse_preview'] ):
//                $field['content'] = get_user_meta( get_current_user_id(), 'spouse_cv_url', true )  ? '<a href="'.get_user_meta( get_current_user_id(), 'spouse_cv_url',  true ).'">'.__( 'Download', 'organicthemes' ).'</a>' : '';
//                break;
//            case( $map['fields']['child_1_preview'] ):
//                $field['content'] = get_user_meta( get_current_user_id(), 'child_1_cv_url', true ) ? '<a href="'.get_user_meta( get_current_user_id(), 'child_1_cv_url', true ).'">'.__( 'Download', 'organicthemes' ).'</a>' : '';
//                break;
//            case( $map['fields']['child_2_preview'] ):
//                $field['content'] = get_user_meta( get_current_user_id(), 'child_2_cv_url', true ) ? '<a href="'.get_user_meta( get_current_user_id(), 'child_2_cv_url', true ).'">'.__( 'Download', 'organicthemes' ).'</a>' : '';
//                break;
//            case( $map['fields']['child_3_preview'] ):
//                $field['content'] = get_user_meta( get_current_user_id(), 'child_3_cv_url', true ) ? '<a href="'.get_user_meta( get_current_user_id(), 'child_3_cv_url', true ).'">'.__( 'Download', 'organicthemes' ).'</a>' : '';
//                break;
//            case( $map['fields']['child_4_preview'] ):
//                $field['content'] = get_user_meta( get_current_user_id(), 'child_4_cv_url', true ) ? '<a href="'.get_user_meta( get_current_user_id(), 'child_4_cv_url', true ).'">'.__( 'Download', 'organicthemes' ).'</a>' : '';
//                break;
//            case( $map['fields']['child_5_preview'] ):
//                $field['content'] = get_user_meta( get_current_user_id(), 'child_5_cv_url', true ) ? '<a href="'.get_user_meta( get_current_user_id(), 'child_5_cv_url', true ).'">'.__( 'Download', 'organicthemes' ).'</a>' : '';
//                break;
//        }
//    }
//
//    return $form;
//}
//add_filter( 'gform_pre_render_12', 'us_cv_upload_form_render' );


/**
 * @description CV upload form update user meta
 *
 * @param $entry
 * @param $form
 *
 * @return mixed
 */
//function us_cv_upload_form_submission( $entry, $form ) {
//    $map = us_map_profile_cv( $form['id'] );
//    if ( !$map ) {
//        return;
//    }
//
//    if ( rgar( $entry, $map['fields']['my_cv'] ) )      update_user_meta( get_current_user_id(), 'cv_url'         , rgar( $entry, $map['fields']['my_cv'] ) );
//    if ( rgar( $entry, $map['fields']['spouse_cv'] ) )  update_user_meta( get_current_user_id(), 'spouse_cv_url'  , rgar( $entry, $map['fields']['spouse_cv'] ) );
//    if ( rgar( $entry, $map['fields']['child_1_cv'] ) ) update_user_meta( get_current_user_id(), 'child_1_cv_url' , rgar( $entry, $map['fields']['child_1_cv'] ) );
//    if ( rgar( $entry, $map['fields']['child_2_cv'] ) ) update_user_meta( get_current_user_id(), 'child_2_cv_url' , rgar( $entry, $map['fields']['child_2_cv'] ) );
//    if ( rgar( $entry, $map['fields']['child_3_cv'] ) ) update_user_meta( get_current_user_id(), 'child_3_cv_url' , rgar( $entry, $map['fields']['child_3_cv'] ) );
//    if ( rgar( $entry, $map['fields']['child_4_cv'] ) ) update_user_meta( get_current_user_id(), 'child_4_cv_url' , rgar( $entry, $map['fields']['child_4_cv'] ) );
//    if ( rgar( $entry, $map['fields']['child_5_cv'] ) ) update_user_meta( get_current_user_id(), 'child_5_cv_url' , rgar( $entry, $map['fields']['child_5_cv'] ) );
//}
//add_action( 'gform_after_submission', 'us_cv_upload_form_submission', 10, 2 );


/**
 * @description CV upload form confirmation url
 *
 * @param $confirmation
 * @param $form
 * @param $entry
 *
 * @return array
 */
//function us_cv_upload_form_confirmation( $confirmation, $form, $entry ) {
//    $confirmation = array( 'redirect' => $_SERVER['REQUEST_URI'] );
//    return $confirmation;
//}
//add_filter( 'gform_confirmation_12', 'us_cv_upload_form_confirmation', 10, 3 );


/**
 * @param $form
 * @return mixed
 */
function us_aplication_1_render( $form ) {
    if ( ! is_user_logged_in() ) return $form;
    $map = file_get_contents( get_template_directory_uri() . '/includes/gravityforms/map.products.1.json' );
    if ( !$map ) return $form; $map = json_decode( $map, true );  if ( $form['id'] != $map['form_id'] ) return $form;

    foreach ( $form['fields'] as &$field ) {
        switch ( $field['id'] ) {
            case( $map['fields']['marital'] ):
                $field['defaultValue'] = get_user_meta( get_current_user_id(), 'married_status', true );
                break;
            default:
                $field['defaultValue'] = '';
                break;
        }
    }

    return $form;
}
add_filter( 'gform_pre_render_4', 'us_aplication_1_render' );


/**
 * @param $form
 * @return mixed
 */
function us_aplication_2_render( $form ) {
    if ( ! is_user_logged_in() ) return $form;
    $map = file_get_contents( get_template_directory_uri() . '/includes/gravityforms/map.products.2.json' );
    if ( !$map ) return $form; $map = json_decode( $map, true );  if ( $form['id'] != $map['form_id'] ) return $form;

    foreach ( $form['fields'] as &$field ) {
        switch ( $field['id'] ) {
            case( $map['fields']['marital'] ):
                $field['defaultValue'] = get_user_meta( get_current_user_id(), 'married_status', true );
                break;
            default:
                $field['defaultValue'] = '';
                break;
        }
    }

    return $form;
}
add_filter( 'gform_pre_render_13', 'us_aplication_2_render' );











/**
 *
 *  Start admin profile form
 *
 */









add_action('admin_menu', 'mt_add_pages');
function mt_add_pages() {
    if ( !is_admin() ) return;
    add_menu_page( 'Edit user data', 'Edit user data', 'manage_options', 'edit_data', 'edit_data');
    function edit_data() {
        echo '<h2>Applicant information</h2>';
        echo do_shortcode('[gravityform id="10" title="false" description="false"]');
    }
}


/**
 * @param $form
 *
 * @return mixed
 */
function profile_admin_gform_pre_render( $form ) {
    if ( ! is_admin() ) {
        return $form;
    }

    $map = us_map_profile_admin( $form['id'] );
    if ( ! $map ) {
        return $form;
    }
    if ( $form['id'] != $map['form_id'] ) {
        return $form;
    }

    $user_id = (int)$_GET['user_id'];
    if( !$user_id ) {
        wp_redirect('/wp-admin/');
        exit();
    }



    foreach ( $form['fields'] as &$field ) {
        switch( $field->id ) {

            // Step 1
            case( $map['fields']['step_1']['married_status'] ):
                $field['defaultValue'] = get_user_meta( $user_id, 'married_status', true );
                break;
            case( $map['fields']['step_1']['no_of_children'] ):
                $field['defaultValue'] = get_user_meta( $user_id, 'no_of_children', true );
                break;

            // Step 2
            case( $map['fields']['step_2']['first_name'] ):
                $field['defaultValue'] = get_user_meta( $user_id, 'first_name', true );
                break;
            case( $map['fields']['step_2']['middle_name'] ):
                $field['defaultValue'] = get_user_meta( $user_id, 'middle_name', true );
                break;
            case( $map['fields']['step_2']['last_name'] ):
                $field['defaultValue'] = get_user_meta( $user_id, 'last_name', true );
                break;
            case( $map['fields']['step_2']['birth_date'] ):
                $timestamp = strtotime( get_user_meta( $user_id, 'birth_date', true ) );
                foreach ( $field->inputs as &$input ) {
                    switch ( $input['id'] ) {
                        case( $map['fields']['step_2']['dob']['month'] ):
                            $input['defaultValue'] = date( 'm', $timestamp );
                            break;
                        case( $map['fields']['step_2']['dob']['day'] ):
                            $input['defaultValue'] = date( 'd', $timestamp );
                            break;
                        case( $map['fields']['step_2']['dob']['year'] ):
                            $input['defaultValue'] = date( 'Y', $timestamp );
                            break;
                    }
                }
                break;
            case( $map['fields']['step_2']['gender'] ):
                $field['defaultValue'] = get_user_meta( $user_id, 'gender', true );
                break;
            case( $map['fields']['step_2']['birth_city'] ):
                $field['defaultValue'] = get_user_meta( $user_id, 'birth_city', true );
                break;
            case( $map['fields']['step_2']['birth_country'] ):
                $field['defaultValue'] = get_user_meta( $user_id, 'birth_country', true );
                break;
            case( $map['fields']['step_2']['education_level'] ):
                $field['defaultValue'] = get_user_meta( $user_id, 'education_level', true );
                break;
            case( $map['fields']['step_2']['occupation'] ):
                $field['defaultValue'] = get_user_meta( $user_id, 'occupation', true );
                break;
            case( $map['fields']['step_2']['work_experience'] ):
                $field['defaultValue'] = get_user_meta( $user_id, 'work_experience', true );
                break;
            case( $map['fields']['step_2']['annual_income'] ):
                $field['defaultValue'] = get_user_meta( $user_id, 'annual_income', true );
                break;
            case( $map['fields']['step_2']['english_level'] ):
                $field['defaultValue'] = get_user_meta( $user_id, 'english_level', true );
                break;

            // Step 3
            case( $map['fields']['step_3']['first_name'] ):
                $field['defaultValue'] = get_user_meta( $user_id, 'spouse_first_name', true );
                break;
            case( $map['fields']['step_3']['middle_name'] ):
                $field['defaultValue'] = get_user_meta( $user_id, 'spouse_middle_name', true );
                break;
            case( $map['fields']['step_3']['last_name'] ):
                $field['defaultValue'] = get_user_meta( $user_id, 'spouse_last_name', true );
                break;
            case( $map['fields']['step_3']['birth_date'] ):
                $timestamp = strtotime( get_user_meta( $user_id, 'spouse_birth_date', true ) );
                foreach ( $field->inputs as &$input ) {
                    switch ( $input['id'] ) {
                        case( $map['fields']['step_3']['dob']['month'] ):
                            $input['defaultValue'] = date( 'm', $timestamp );
                            break;
                        case( $map['fields']['step_3']['dob']['day'] ):
                            $input['defaultValue'] = date( 'd', $timestamp );
                            break;
                        case( $map['fields']['step_3']['dob']['year'] ):
                            $input['defaultValue'] = date( 'Y', $timestamp );
                            break;
                    }
                }
                break;
            case( $map['fields']['step_3']['gender'] ):
                $field['defaultValue'] = get_user_meta( $user_id, 'spouse_gender', true );
                break;
            case( $map['fields']['step_3']['birth_city'] ):
                $field['defaultValue'] = get_user_meta( $user_id, 'spouse_birth_city', true );
                break;
            case( $map['fields']['step_3']['birth_country'] ):
                $field['defaultValue'] = get_user_meta( $user_id, 'spouse_birth_country', true );
                break;
            case( $map['fields']['step_3']['education_level'] ):
                $field['defaultValue'] = get_user_meta( $user_id, 'spouse_education_level', true );
                break;
            case( $map['fields']['step_3']['occupation'] ):
                $field['defaultValue'] = get_user_meta( $user_id, 'spouse_occupation', true );
                break;
            case( $map['fields']['step_3']['work_experience'] ):
                $field['defaultValue'] = get_user_meta( $user_id, 'spouse_work_experience', true );
                break;
            case( $map['fields']['step_3']['annual_income'] ):
                $field['defaultValue'] = get_user_meta( $user_id, 'spouse_annual_income', true );
                break;
            case( $map['fields']['step_3']['english_level'] ):
                $field['defaultValue'] = get_user_meta( $user_id, 'spouse_english_level', true );
                break;

            // Step 4
            case( $map['fields']['step_4']['first_name'] ):
                $field['defaultValue'] = get_user_meta( $user_id, 'child_1_first_name', true );
                break;
            case( $map['fields']['step_4']['last_name'] ):
                $field['defaultValue'] = get_user_meta( $user_id, 'child_1_last_name', true );
                break;
            case( $map['fields']['step_4']['birth_date'] ):
                $timestamp = strtotime( get_user_meta( $user_id, 'child_1_birth_date', true ) );
                foreach ( $field->inputs as &$input ) {
                    switch ( $input['id'] ) {
                        case( $map['fields']['step_4']['dob']['month'] ):
                            $input['defaultValue'] = date( 'm', $timestamp );
                            break;
                        case( $map['fields']['step_4']['dob']['day'] ):
                            $input['defaultValue'] = date( 'd', $timestamp );
                            break;
                        case( $map['fields']['step_4']['dob']['year'] ):
                            $input['defaultValue'] = date( 'Y', $timestamp );
                            break;
                    }
                }
                break;
            case( $map['fields']['step_4']['gender'] ):
                $field['defaultValue'] = get_user_meta( $user_id, 'child_1_gender', true );
                break;
            case( $map['fields']['step_4']['birth_city'] ):
                $field['defaultValue'] = get_user_meta( $user_id, 'child_1_birth_city', true );
                break;
            case( $map['fields']['step_4']['birth_country'] ):
                $field['defaultValue'] = get_user_meta( $user_id, 'child_1_birth_country', true );
                break;

            // Step 5
            case( $map['fields']['step_5']['first_name'] ):
                $field['defaultValue'] = get_user_meta( $user_id, 'child_2_first_name', true );
                break;
            case( $map['fields']['step_5']['last_name'] ):
                $field['defaultValue'] = get_user_meta( $user_id, 'child_2_last_name', true );
                break;
            case( $map['fields']['step_5']['birth_date'] ):
                $timestamp = strtotime( get_user_meta( $user_id, 'child_2_birth_date', true ) );
                foreach ( $field->inputs as &$input ) {
                    switch ( $input['id'] ) {
                        case( $map['fields']['step_5']['dob']['month'] ):
                            $input['defaultValue'] = date( 'm', $timestamp );
                            break;
                        case( $map['fields']['step_5']['dob']['day'] ):
                            $input['defaultValue'] = date( 'd', $timestamp );
                            break;
                        case( $map['fields']['step_5']['dob']['year'] ):
                            $input['defaultValue'] = date( 'Y', $timestamp );
                            break;
                    }
                }
                break;
            case( $map['fields']['step_5']['gender'] ):
                $field['defaultValue'] = get_user_meta( $user_id, 'child_2_gender', true );
                break;
            case( $map['fields']['step_5']['birth_city'] ):
                $field['defaultValue'] = get_user_meta( $user_id, 'child_2_birth_city', true );
                break;
            case( $map['fields']['step_5']['birth_country'] ):
                $field['defaultValue'] = get_user_meta( $user_id, 'child_2_birth_country', true );
                break;

            // Step 6
            case( $map['fields']['step_6']['first_name'] ):
                $field['defaultValue'] = get_user_meta( $user_id, 'child_3_first_name', true );
                break;
            case( $map['fields']['step_6']['last_name'] ):
                $field['defaultValue'] = get_user_meta( $user_id, 'child_3_last_name', true );
                break;
            case( $map['fields']['step_6']['birth_date'] ):
                $timestamp = strtotime( get_user_meta( $user_id, 'child_3_birth_date', true ) );
                foreach ( $field->inputs as &$input ) {
                    switch ( $input['id'] ) {
                        case( $map['fields']['step_6']['dob']['month'] ):
                            $input['defaultValue'] = date( 'm', $timestamp );
                            break;
                        case( $map['fields']['step_6']['dob']['day'] ):
                            $input['defaultValue'] = date( 'd', $timestamp );
                            break;
                        case( $map['fields']['step_6']['dob']['year'] ):
                            $input['defaultValue'] = date( 'Y', $timestamp );
                            break;
                    }
                }
                break;
            case( $map['fields']['step_6']['gender'] ):
                $field['defaultValue'] = get_user_meta( $user_id, 'child_3_gender', true );
                break;
            case( $map['fields']['step_6']['birth_city'] ):
                $field['defaultValue'] = get_user_meta( $user_id, 'child_3_birth_city', true );
                break;
            case( $map['fields']['step_6']['birth_country'] ):
                $field['defaultValue'] = get_user_meta( $user_id, 'child_3_birth_country', true );
                break;

            // Step 7
            case( $map['fields']['step_7']['first_name'] ):
                $field['defaultValue'] = get_user_meta( $user_id, 'child_4_first_name', true );
                break;
            case( $map['fields']['step_7']['last_name'] ):
                $field['defaultValue'] = get_user_meta( $user_id, 'child_4_last_name', true );
                break;
            case( $map['fields']['step_7']['birth_date'] ):
                $timestamp = strtotime( get_user_meta( $user_id, 'child_4_birth_date', true ) );
                foreach ( $field->inputs as &$input ) {
                    switch ( $input['id'] ) {
                        case( $map['fields']['step_7']['dob']['month'] ):
                            $input['defaultValue'] = date( 'm', $timestamp );
                            break;
                        case( $map['fields']['step_7']['dob']['day'] ):
                            $input['defaultValue'] = date( 'd', $timestamp );
                            break;
                        case( $map['fields']['step_7']['dob']['year'] ):
                            $input['defaultValue'] = date( 'Y', $timestamp );
                            break;
                    }
                }
                break;
            case( $map['fields']['step_7']['gender'] ):
                $field['defaultValue'] = get_user_meta( $user_id, 'child_4_gender', true );
                break;
            case( $map['fields']['step_7']['birth_city'] ):
                $field['defaultValue'] = get_user_meta( $user_id, 'child_4_birth_city', true );
                break;
            case( $map['fields']['step_7']['birth_country'] ):
                $field['defaultValue'] = get_user_meta( $user_id, 'child_4_birth_country', true );
                break;

            // Step 8
            case( $map['fields']['step_8']['first_name'] ):
                $field['defaultValue'] = get_user_meta( $user_id, 'child_5_first_name', true );
                break;
            case( $map['fields']['step_8']['last_name'] ):
                $field['defaultValue'] = get_user_meta( $user_id, 'child_5_last_name', true );
                break;
            case( $map['fields']['step_8']['birth_date'] ):
                $timestamp = strtotime( get_user_meta( $user_id, 'child_5_birth_date', true ) );
                foreach ( $field->inputs as &$input ) {
                    switch ( $input['id'] ) {
                        case( $map['fields']['step_8']['dob']['month'] ):
                            $input['defaultValue'] = date( 'm', $timestamp );
                            break;
                        case( $map['fields']['step_8']['dob']['day'] ):
                            $input['defaultValue'] = date( 'd', $timestamp );
                            break;
                        case( $map['fields']['step_8']['dob']['year'] ):
                            $input['defaultValue'] = date( 'Y', $timestamp );
                            break;
                    }
                }
                break;
            case( $map['fields']['step_8']['gender'] ):
                $field['defaultValue'] = get_user_meta( $user_id, 'child_5_gender', true );
                break;
            case( $map['fields']['step_8']['birth_city'] ):
                $field['defaultValue'] = get_user_meta( $user_id, 'child_5_birth_city', true );
                break;
            case( $map['fields']['step_8']['birth_country'] ):
                $field['defaultValue'] = get_user_meta( $user_id, 'child_5_birth_country', true );
                break;

            // Step 9
            case( $map['fields']['step_9']['route'] ):
                $field['defaultValue'] = get_user_meta( $user_id, 'route', true );
                break;
            case( $map['fields']['step_9']['street_number'] ):
                $field['defaultValue'] = get_user_meta( $user_id, 'street_number', true );
                break;
            case( $map['fields']['step_9']['locality'] ):
                $field['defaultValue'] = get_user_meta( $user_id, 'locality', true );
                break;
            case( $map['fields']['step_9']['district'] ):
                $field['defaultValue'] = get_user_meta( $user_id, 'administrative_area_level_1', true );
                break;
            case( $map['fields']['step_9']['postal_code'] ):
                $field['defaultValue'] = get_user_meta( $user_id, 'postal_code', true );
                break;
            case( $map['fields']['step_9']['country'] ):
                $field['defaultValue'] = get_user_meta( $user_id, 'country', true );
                break;
            case( $map['fields']['step_9']['phone'] ):
                $field['defaultValue'] = get_user_meta( $user_id, 'phone', true );
                break;
            case( $map['fields']['step_9']['email'] ):
                $field['defaultValue'] = get_user_meta( $user_id, 'email', true );
                break;
            case( $map['fields']['step_9']['country_of_residence'] ):
                $field['defaultValue'] = get_user_meta( $user_id, 'country_of_residence', true );
                break;

            case( $map['user_id'] ):
                $field['defaultValue'] = $user_id;
                break;
        }
    }

    return $form;
}
add_filter( 'gform_pre_render', 'profile_admin_gform_pre_render' );




/**
 * @param $entry
 * @param $form
 */
function us_admin_applicant_meta( $entry, $form ) {

    if ( !is_admin() ) {
        return;
    }

    $map = us_map_profile_admin( $form['id'] );
    if ( ! $map ) {
        return;
    }

    $user_id = (int)$_GET['user_id'];

    $no_of_children = rgar( $entry, $map['fields']['step_1']['no_of_children'] );
    $have_children = $no_of_children > 0 ? 'Yes' : 'No';

    // Step 1
    update_user_meta( $user_id, 'have_children'               , $have_children );
    update_user_meta( $user_id, 'married_status'              , rgar( $entry, $map['fields']['step_1']['married_status'] ) );
    update_user_meta( $user_id, 'no_of_children'              , rgar( $entry, $map['fields']['step_1']['no_of_children'] ) );

    // Step 2
    update_user_meta( $user_id, 'first_name'                  , rgar( $entry, $map['fields']['step_2']['first_name'] ) );
    update_user_meta( $user_id, 'middle_name'                 , rgar( $entry, $map['fields']['step_2']['middle_name'] ) );
    update_user_meta( $user_id, 'last_name'                   , rgar( $entry, $map['fields']['step_2']['last_name'] ) );
    update_user_meta( $user_id, 'birth_date'                  , rgar( $entry, $map['fields']['step_2']['birth_date'] ) );
    update_user_meta( $user_id, 'gender'                      , rgar( $entry, $map['fields']['step_2']['gender'] ) );
    update_user_meta( $user_id, 'birth_city'                  , rgar( $entry, $map['fields']['step_2']['birth_city'] ) );
    update_user_meta( $user_id, 'birth_country'               , rgar( $entry, $map['fields']['step_2']['birth_country'] ) );
    update_user_meta( $user_id, 'education_level'             , rgar( $entry, $map['fields']['step_2']['education_level'] ) );
    update_user_meta( $user_id, 'occupation'                  , rgar( $entry, $map['fields']['step_2']['occupation'] ) );
    update_user_meta( $user_id, 'work_experience'             , rgar( $entry, $map['fields']['step_2']['work_experience'] ) );
    update_user_meta( $user_id, 'annual_income'               , rgar( $entry, $map['fields']['step_2']['annual_income'] ) );
    update_user_meta( $user_id, 'english_level'               , rgar( $entry, $map['fields']['step_2']['english_level'] ) );

    // Step 3
    update_user_meta( $user_id, 'spouse_first_name'           , rgar( $entry, $map['fields']['step_3']['first_name'] ) );
    update_user_meta( $user_id, 'spouse_middle_name'          , rgar( $entry, $map['fields']['step_3']['middle_name'] ) );
    update_user_meta( $user_id, 'spouse_last_name'            , rgar( $entry, $map['fields']['step_3']['last_name'] ) );
    update_user_meta( $user_id, 'spouse_birth_date'           , rgar( $entry, $map['fields']['step_3']['birth_date'] ) );
    update_user_meta( $user_id, 'spouse_birth_date'           , rgar( $entry, $map['fields']['step_3']['birth_date'] ) );
    update_user_meta( $user_id, 'spouse_gender'               , rgar( $entry, $map['fields']['step_3']['gender'] ) );
    update_user_meta( $user_id, 'spouse_birth_city'           , rgar( $entry, $map['fields']['step_3']['birth_city'] ) );
    update_user_meta( $user_id, 'spouse_birth_country'        , rgar( $entry, $map['fields']['step_3']['birth_country'] ) );
    update_user_meta( $user_id, 'spouse_education_level'      , rgar( $entry, $map['fields']['step_3']['education_level'] ) );
    update_user_meta( $user_id, 'spouse_occupation'           , rgar( $entry, $map['fields']['step_3']['occupation'] ) );
    update_user_meta( $user_id, 'spouse_work_experience'      , rgar( $entry, $map['fields']['step_3']['work_experience'] ) );
    update_user_meta( $user_id, 'spouse_annual_income'        , rgar( $entry, $map['fields']['step_3']['annual_income'] ) );
    update_user_meta( $user_id, 'spouse_english_level'        , rgar( $entry, $map['fields']['step_3']['english_level'] ) );

    // Step 4
    update_user_meta( $user_id, 'child_1_first_name'          , rgar( $entry, $map['fields']['step_4']['first_name'] ) );
    update_user_meta( $user_id, 'child_1_last_name'           , rgar( $entry, $map['fields']['step_4']['last_name'] ) );
    update_user_meta( $user_id, 'child_1_birth_date'          , rgar( $entry, $map['fields']['step_4']['birth_date'] ) );
    update_user_meta( $user_id, 'child_1_gender'              , rgar( $entry, $map['fields']['step_4']['gender'] ) );
    update_user_meta( $user_id, 'child_1_birth_city'          , rgar( $entry, $map['fields']['step_4']['birth_city'] ) );
    update_user_meta( $user_id, 'child_1_birth_country'       , rgar( $entry, $map['fields']['step_4']['birth_country'] ) );

    // Step 5
    update_user_meta( $user_id, 'child_2_first_name'          , rgar( $entry, $map['fields']['step_5']['first_name'] ) );
    update_user_meta( $user_id, 'child_2_last_name'           , rgar( $entry, $map['fields']['step_5']['last_name'] ) );
    update_user_meta( $user_id, 'child_2_birth_date'          , rgar( $entry, $map['fields']['step_5']['birth_date'] ) );
    update_user_meta( $user_id, 'child_2_gender'              , rgar( $entry, $map['fields']['step_5']['gender'] ) );
    update_user_meta( $user_id, 'child_2_birth_city'          , rgar( $entry, $map['fields']['step_5']['birth_city'] ) );
    update_user_meta( $user_id, 'child_2_birth_country'       , rgar( $entry, $map['fields']['step_5']['birth_country'] ) );

    // Step 6
    update_user_meta( $user_id, 'child_3_first_name'          , rgar( $entry, $map['fields']['step_6']['first_name'] ) );
    update_user_meta( $user_id, 'child_3_last_name'           , rgar( $entry, $map['fields']['step_6']['last_name'] ) );
    update_user_meta( $user_id, 'child_3_birth_date'          , rgar( $entry, $map['fields']['step_6']['birth_date'] ) );
    update_user_meta( $user_id, 'child_3_gender'              , rgar( $entry, $map['fields']['step_6']['gender'] ) );
    update_user_meta( $user_id, 'child_3_birth_city'          , rgar( $entry, $map['fields']['step_6']['birth_city'] ) );
    update_user_meta( $user_id, 'child_3_birth_country'       , rgar( $entry, $map['fields']['step_6']['birth_country'] ) );

    // Step 7
    update_user_meta( $user_id, 'child_4_first_name'          , rgar( $entry, $map['fields']['step_7']['first_name'] ) );
    update_user_meta( $user_id, 'child_4_last_name'           , rgar( $entry, $map['fields']['step_7']['last_name'] ) );
    update_user_meta( $user_id, 'child_4_birth_date'          , rgar( $entry, $map['fields']['step_7']['birth_date'] ) );
    update_user_meta( $user_id, 'child_4_gender'              , rgar( $entry, $map['fields']['step_7']['gender'] ) );
    update_user_meta( $user_id, 'child_4_birth_city'          , rgar( $entry, $map['fields']['step_7']['birth_city'] ) );
    update_user_meta( $user_id, 'child_4_birth_country'       , rgar( $entry, $map['fields']['step_7']['birth_country'] ) );

    // Step 8
    update_user_meta( $user_id, 'child_5_first_name'          , rgar( $entry, $map['fields']['step_8']['first_name'] ) );
    update_user_meta( $user_id, 'child_5_last_name'           , rgar( $entry, $map['fields']['step_8']['last_name'] ) );
    update_user_meta( $user_id, 'child_5_birth_date'          , rgar( $entry, $map['fields']['step_8']['birth_date'] ) );
    update_user_meta( $user_id, 'child_5_gender'              , rgar( $entry, $map['fields']['step_8']['gender'] ) );
    update_user_meta( $user_id, 'child_5_birth_city'          , rgar( $entry, $map['fields']['step_8']['birth_city'] ) );
    update_user_meta( $user_id, 'child_5_birth_country'       , rgar( $entry, $map['fields']['step_8']['birth_country'] ) );

    // Step 9
    update_user_meta( $user_id, 'route'                       , rgar( $entry, $map['fields']['step_9']['route'] ) );
    update_user_meta( $user_id, 'street_number'               , rgar( $entry, $map['fields']['step_9']['street_number'] ) );
    update_user_meta( $user_id, 'locality'                    , rgar( $entry, $map['fields']['step_9']['locality'] ) );
    update_user_meta( $user_id, 'administrative_area_level_1' , rgar( $entry, $map['fields']['step_9']['district'] ) );
    update_user_meta( $user_id, 'postal_code'                 , rgar( $entry, $map['fields']['step_9']['postal_code'] ) );
    update_user_meta( $user_id, 'country'                     , rgar( $entry, $map['fields']['step_9']['country'] ) );
    update_user_meta( $user_id, 'phone'                       , rgar( $entry, $map['fields']['step_9']['phone'] ) );
    update_user_meta( $user_id, 'email'                       , rgar( $entry, $map['fields']['step_9']['email'] ) );
    update_user_meta( $user_id, 'country_of_residence'        , rgar( $entry, $map['fields']['step_9']['country_of_residence'] ) );

}
add_action( 'gform_after_submission', 'us_admin_applicant_meta', 10, 2 );
