<?php

function usdv_form_profile() {

    if ( !is_user_logged_in() ) return;
    if ( is_admin() ) return;

    new USDV_Form_Profile();
}
add_action( 'init', 'usdv_form_profile' );


class USDV_Form_Profile extends USDV_Form_Base
{
    /**
     * @var array
     */
    var $map = array();

    /**
     * USDV_Form_Profile constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->setMap( 'map.profile.json' );

        add_filter( 'gform_pre_render_1', array( $this, 'RenderForm' ), 10 );

        add_action( 'gform_after_submission_1', array( $this, 'UpdateForm' ), 10, 2 );
    }

    /**
     * Profile form render
     * @param $form
     * @return mixed
     */
    function RenderForm( $form ) {

        $user = new WP_User( get_current_user_id() );
        $user_id = (int)get_current_user_id();

        $map = $this->getMap();
        if ( !$map ) {
            return $form;
        }

        foreach( $form['fields'] as &$field ) {
            switch ( $field->id ) {

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
                case( $map['fields']['step_9']['first_name'] ):
                    $field['defaultValue'] = get_user_meta( $user_id, 'child_6_first_name', true );
                    break;
                case( $map['fields']['step_9']['last_name'] ):
                    $field['defaultValue'] = get_user_meta( $user_id, 'child_6_last_name', true );
                    break;
                case( $map['fields']['step_9']['birth_date'] ):
                    $timestamp = strtotime( get_user_meta( $user_id, 'child_6_birth_date', true ) );
                    foreach ( $field->inputs as &$input ) {
                        switch ( $input['id'] ) {
                            case( $map['fields']['step_9']['dob']['month'] ):
                                $input['defaultValue'] = date( 'm', $timestamp );
                                break;
                            case( $map['fields']['step_9']['dob']['day'] ):
                                $input['defaultValue'] = date( 'd', $timestamp );
                                break;
                            case( $map['fields']['step_9']['dob']['year'] ):
                                $input['defaultValue'] = date( 'Y', $timestamp );
                                break;
                        }
                    }
                    break;
                case( $map['fields']['step_9']['gender'] ):
                    $field['defaultValue'] = get_user_meta( $user_id, 'child_6_gender', true );
                    break;
                case( $map['fields']['step_9']['birth_city'] ):
                    $field['defaultValue'] = get_user_meta( $user_id, 'child_6_birth_city', true );
                    break;
                case( $map['fields']['step_9']['birth_country'] ):
                    $field['defaultValue'] = get_user_meta( $user_id, 'child_6_birth_country', true );
                    break;

                // Step 10
                case( $map['fields']['step_10']['first_name'] ):
                    $field['defaultValue'] = get_user_meta( $user_id, 'child_7_first_name', true );
                    break;
                case( $map['fields']['step_10']['last_name'] ):
                    $field['defaultValue'] = get_user_meta( $user_id, 'child_7_last_name', true );
                    break;
                case( $map['fields']['step_10']['birth_date'] ):
                    $timestamp = strtotime( get_user_meta( $user_id, 'child_7_birth_date', true ) );
                    foreach ( $field->inputs as &$input ) {
                        switch ( $input['id'] ) {
                            case( $map['fields']['step_10']['dob']['month'] ):
                                $input['defaultValue'] = date( 'm', $timestamp );
                                break;
                            case( $map['fields']['step_10']['dob']['day'] ):
                                $input['defaultValue'] = date( 'd', $timestamp );
                                break;
                            case( $map['fields']['step_10']['dob']['year'] ):
                                $input['defaultValue'] = date( 'Y', $timestamp );
                                break;
                        }
                    }
                    break;
                case( $map['fields']['step_10']['gender'] ):
                    $field['defaultValue'] = get_user_meta( $user_id, 'child_7_gender', true );
                    break;
                case( $map['fields']['step_10']['birth_city'] ):
                    $field['defaultValue'] = get_user_meta( $user_id, 'child_7_birth_city', true );
                    break;
                case( $map['fields']['step_10']['birth_country'] ):
                    $field['defaultValue'] = get_user_meta( $user_id, 'child_7_birth_country', true );
                    break;

                // Step 11
                case( $map['fields']['step_11']['first_name'] ):
                    $field['defaultValue'] = get_user_meta( $user_id, 'child_8_first_name', true );
                    break;
                case( $map['fields']['step_11']['last_name'] ):
                    $field['defaultValue'] = get_user_meta( $user_id, 'child_8_last_name', true );
                    break;
                case( $map['fields']['step_11']['birth_date'] ):
                    $timestamp = strtotime( get_user_meta( $user_id, 'child_8_birth_date', true ) );
                    foreach ( $field->inputs as &$input ) {
                        switch ( $input['id'] ) {
                            case( $map['fields']['step_11']['dob']['month'] ):
                                $input['defaultValue'] = date( 'm', $timestamp );
                                break;
                            case( $map['fields']['step_11']['dob']['day'] ):
                                $input['defaultValue'] = date( 'd', $timestamp );
                                break;
                            case( $map['fields']['step_11']['dob']['year'] ):
                                $input['defaultValue'] = date( 'Y', $timestamp );
                                break;
                        }
                    }
                    break;
                case( $map['fields']['step_11']['gender'] ):
                    $field['defaultValue'] = get_user_meta( $user_id, 'child_8_gender', true );
                    break;
                case( $map['fields']['step_11']['birth_city'] ):
                    $field['defaultValue'] = get_user_meta( $user_id, 'child_8_birth_city', true );
                    break;
                case( $map['fields']['step_11']['birth_country'] ):
                    $field['defaultValue'] = get_user_meta( $user_id, 'child_8_birth_country', true );
                    break;

                // Step 12
                case( $map['fields']['step_12']['first_name'] ):
                    $field['defaultValue'] = get_user_meta( $user_id, 'child_9_first_name', true );
                    break;
                case( $map['fields']['step_12']['last_name'] ):
                    $field['defaultValue'] = get_user_meta( $user_id, 'child_9_last_name', true );
                    break;
                case( $map['fields']['step_12']['birth_date'] ):
                    $timestamp = strtotime( get_user_meta( $user_id, 'child_9_birth_date', true ) );
                    foreach ( $field->inputs as &$input ) {
                        switch ( $input['id'] ) {
                            case( $map['fields']['step_11']['dob']['month'] ):
                                $input['defaultValue'] = date( 'm', $timestamp );
                                break;
                            case( $map['fields']['step_11']['dob']['day'] ):
                                $input['defaultValue'] = date( 'd', $timestamp );
                                break;
                            case( $map['fields']['step_11']['dob']['year'] ):
                                $input['defaultValue'] = date( 'Y', $timestamp );
                                break;
                        }
                    }
                    break;
                case( $map['fields']['step_12']['gender'] ):
                    $field['defaultValue'] = get_user_meta( $user_id, 'child_10_gender', true );
                    break;
                case( $map['fields']['step_12']['birth_city'] ):
                    $field['defaultValue'] = get_user_meta( $user_id, 'child_10_birth_city', true );
                    break;
                case( $map['fields']['step_12']['birth_country'] ):
                    $field['defaultValue'] = get_user_meta( $user_id, 'child_10_birth_country', true );
                    break;

                // Step 13
                case( $map['fields']['step_13']['first_name'] ):
                    $field['defaultValue'] = get_user_meta( $user_id, 'child_10_first_name', true );
                    break;
                case( $map['fields']['step_13']['last_name'] ):
                    $field['defaultValue'] = get_user_meta( $user_id, 'child_10_last_name', true );
                    break;
                case( $map['fields']['step_13']['birth_date'] ):
                    $timestamp = strtotime( get_user_meta( $user_id, 'child_10_birth_date', true ) );
                    foreach ( $field->inputs as &$input ) {
                        switch ( $input['id'] ) {
                            case( $map['fields']['step_13']['dob']['month'] ):
                                $input['defaultValue'] = date( 'm', $timestamp );
                                break;
                            case( $map['fields']['step_13']['dob']['day'] ):
                                $input['defaultValue'] = date( 'd', $timestamp );
                                break;
                            case( $map['fields']['step_13']['dob']['year'] ):
                                $input['defaultValue'] = date( 'Y', $timestamp );
                                break;
                        }
                    }
                    break;
                case( $map['fields']['step_13']['gender'] ):
                    $field['defaultValue'] = get_user_meta( $user_id, 'child_10_gender', true );
                    break;
                case( $map['fields']['step_13']['birth_city'] ):
                    $field['defaultValue'] = get_user_meta( $user_id, 'child_10_birth_city', true );
                    break;
                case( $map['fields']['step_13']['birth_country'] ):
                    $field['defaultValue'] = get_user_meta( $user_id, 'child_10_birth_country', true );
                    break;

                // Step 14
                case( $map['fields']['step_14']['first_name'] ):
                    $field['defaultValue'] = get_user_meta( $user_id, 'child_11_first_name', true );
                    break;
                case( $map['fields']['step_14']['last_name'] ):
                    $field['defaultValue'] = get_user_meta( $user_id, 'child_11_last_name', true );
                    break;
                case( $map['fields']['step_14']['birth_date'] ):
                    $timestamp = strtotime( get_user_meta( $user_id, 'child_11_birth_date', true ) );
                    foreach ( $field->inputs as &$input ) {
                        switch ( $input['id'] ) {
                            case( $map['fields']['step_14']['dob']['month'] ):
                                $input['defaultValue'] = date( 'm', $timestamp );
                                break;
                            case( $map['fields']['step_14']['dob']['day'] ):
                                $input['defaultValue'] = date( 'd', $timestamp );
                                break;
                            case( $map['fields']['step_14']['dob']['year'] ):
                                $input['defaultValue'] = date( 'Y', $timestamp );
                                break;
                        }
                    }
                    break;
                case( $map['fields']['step_14']['gender'] ):
                    $field['defaultValue'] = get_user_meta( $user_id, 'child_11_gender', true );
                    break;
                case( $map['fields']['step_14']['birth_city'] ):
                    $field['defaultValue'] = get_user_meta( $user_id, 'child_11_birth_city', true );
                    break;
                case( $map['fields']['step_14']['birth_country'] ):
                    $field['defaultValue'] = get_user_meta( $user_id, 'child_11_birth_country', true );
                    break;

                //
                //
                // Step 15
                case( $map['fields']['step_15']['first_name'] ):
                    $field['defaultValue'] = get_user_meta( $user_id, 'child_12_first_name', true );
                    break;
                case( $map['fields']['step_15']['last_name'] ):
                    $field['defaultValue'] = get_user_meta( $user_id, 'child_12_last_name', true );
                    break;
                case( $map['fields']['step_15']['birth_date'] ):
                    $timestamp = strtotime( get_user_meta( $user_id, 'child_12_birth_date', true ) );
                    foreach ( $field->inputs as &$input ) {
                        switch ( $input['id'] ) {
                            case( $map['fields']['step_15']['dob']['month'] ):
                                $input['defaultValue'] = date( 'm', $timestamp );
                                break;
                            case( $map['fields']['step_15']['dob']['day'] ):
                                $input['defaultValue'] = date( 'd', $timestamp );
                                break;
                            case( $map['fields']['step_15']['dob']['year'] ):
                                $input['defaultValue'] = date( 'Y', $timestamp );
                                break;
                        }
                    }
                    break;
                case( $map['fields']['step_15']['gender'] ):
                    $field['defaultValue'] = get_user_meta( $user_id, 'child_12_gender', true );
                    break;
                case( $map['fields']['step_15']['birth_city'] ):
                    $field['defaultValue'] = get_user_meta( $user_id, 'child_12_birth_city', true );
                    break;
                case( $map['fields']['step_15']['birth_country'] ):
                    $field['defaultValue'] = get_user_meta( $user_id, 'child_12_birth_country', true );
                    break;

                //
                //
                // Step 16
                case( $map['fields']['step_16']['first_name'] ):
                    $field['defaultValue'] = get_user_meta( $user_id, 'child_13_first_name', true );
                    break;
                case( $map['fields']['step_16']['last_name'] ):
                    $field['defaultValue'] = get_user_meta( $user_id, 'child_13_last_name', true );
                    break;
                case( $map['fields']['step_16']['birth_date'] ):
                    $timestamp = strtotime( get_user_meta( $user_id, 'child_13_birth_date', true ) );
                    foreach ( $field->inputs as &$input ) {
                        switch ( $input['id'] ) {
                            case( $map['fields']['step_16']['dob']['month'] ):
                                $input['defaultValue'] = date( 'm', $timestamp );
                                break;
                            case( $map['fields']['step_16']['dob']['day'] ):
                                $input['defaultValue'] = date( 'd', $timestamp );
                                break;
                            case( $map['fields']['step_16']['dob']['year'] ):
                                $input['defaultValue'] = date( 'Y', $timestamp );
                                break;
                        }
                    }
                    break;
                case( $map['fields']['step_16']['gender'] ):
                    $field['defaultValue'] = get_user_meta( $user_id, 'child_13_gender', true );
                    break;
                case( $map['fields']['step_16']['birth_city'] ):
                    $field['defaultValue'] = get_user_meta( $user_id, 'child_13_birth_city', true );
                    break;
                case( $map['fields']['step_16']['birth_country'] ):
                    $field['defaultValue'] = get_user_meta( $user_id, 'child_13_birth_country', true );
                    break;

                //
                //
                // Step 17
                case( $map['fields']['step_17']['first_name'] ):
                    $field['defaultValue'] = get_user_meta( $user_id, 'child_14_first_name', true );
                    break;
                case( $map['fields']['step_17']['last_name'] ):
                    $field['defaultValue'] = get_user_meta( $user_id, 'child_14_last_name', true );
                    break;
                case( $map['fields']['step_17']['birth_date'] ):
                    $timestamp = strtotime( get_user_meta( $user_id, 'child_14_birth_date', true ) );
                    foreach ( $field->inputs as &$input ) {
                        switch ( $input['id'] ) {
                            case( $map['fields']['step_17']['dob']['month'] ):
                                $input['defaultValue'] = date( 'm', $timestamp );
                                break;
                            case( $map['fields']['step_17']['dob']['day'] ):
                                $input['defaultValue'] = date( 'd', $timestamp );
                                break;
                            case( $map['fields']['step_17']['dob']['year'] ):
                                $input['defaultValue'] = date( 'Y', $timestamp );
                                break;
                        }
                    }
                    break;
                case( $map['fields']['step_17']['gender'] ):
                    $field['defaultValue'] = get_user_meta( $user_id, 'child_14_gender', true );
                    break;
                case( $map['fields']['step_17']['birth_city'] ):
                    $field['defaultValue'] = get_user_meta( $user_id, 'child_14_birth_city', true );
                    break;
                case( $map['fields']['step_17']['birth_country'] ):
                    $field['defaultValue'] = get_user_meta( $user_id, 'child_14_birth_country', true );
                    break;

                //
                //
                // Step 18
                case( $map['fields']['step_18']['first_name'] ):
                    $field['defaultValue'] = get_user_meta( $user_id, 'child_15_first_name', true );
                    break;
                case( $map['fields']['step_18']['last_name'] ):
                    $field['defaultValue'] = get_user_meta( $user_id, 'child_15_last_name', true );
                    break;
                case( $map['fields']['step_18']['birth_date'] ):
                    $timestamp = strtotime( get_user_meta( $user_id, 'child_15_birth_date', true ) );
                    foreach ( $field->inputs as &$input ) {
                        switch ( $input['id'] ) {
                            case( $map['fields']['step_18']['dob']['month'] ):
                                $input['defaultValue'] = date( 'm', $timestamp );
                                break;
                            case( $map['fields']['step_18']['dob']['day'] ):
                                $input['defaultValue'] = date( 'd', $timestamp );
                                break;
                            case( $map['fields']['step_18']['dob']['year'] ):
                                $input['defaultValue'] = date( 'Y', $timestamp );
                                break;
                        }
                    }
                    break;
                case( $map['fields']['step_18']['gender'] ):
                    $field['defaultValue'] = get_user_meta( $user_id, 'child_15_gender', true );
                    break;
                case( $map['fields']['step_18']['birth_city'] ):
                    $field['defaultValue'] = get_user_meta( $user_id, 'child_15_birth_city', true );
                    break;
                case( $map['fields']['step_18']['birth_country'] ):
                    $field['defaultValue'] = get_user_meta( $user_id, 'child_15_birth_country', true );
                    break;

                //
                //
                // Step 19
                case( $map['fields']['step_19']['route'] ):
                    $field['defaultValue'] = get_user_meta( $user_id, 'route', true );
                    break;
                case( $map['fields']['step_19']['street_number'] ):
                    $field['defaultValue'] = get_user_meta( $user_id, 'street_number', true );
                    break;
                case( $map['fields']['step_19']['locality'] ):
                    $field['defaultValue'] = get_user_meta( $user_id, 'locality', true );
                    break;
                case( $map['fields']['step_19']['district'] ):
                    $field['defaultValue'] = get_user_meta( $user_id, 'administrative_area_level_1', true );
                    break;
                case( $map['fields']['step_19']['postal_code'] ):
                    $field['defaultValue'] = get_user_meta( $user_id, 'postal_code', true );
                    break;
                case( $map['fields']['step_19']['country'] ):
                    $field['defaultValue'] = get_user_meta( $user_id, 'country', true );
                    break;
                case( $map['fields']['step_19']['phone'] ):
                    $field['defaultValue'] = get_user_meta( $user_id, 'phone', true );
                    break;
                case( $map['fields']['step_19']['email'] ):
                    $field['defaultValue'] = get_user_meta( $user_id, 'email', true );
                    break;
                case( $map['fields']['step_19']['country_of_residence'] ):
                    $field['defaultValue'] = get_user_meta( $user_id, 'country_of_residence', true );
                    break;
                case( $map['fields']['step_19']['eligibility'] ):
                    $field['defaultValue'] = get_user_meta( $user_id, 'eligibility', true );
                    break;
            }
        }

        return $form;

    }


    /**
     * Profile form update
     * @param $entry
     * @param $form
     */
    public function UpdateForm( $entry, $form )
    {
        if ( is_admin() ) {
            return;
        }

        $map = $this->getMap();

        $user_id = get_current_user_id();

        $no_of_children = rgar( $entry, $map['fields']['step_1']['no_of_children'] );
        $have_children = $no_of_children > 0 ? 'Yes' : 'No';

        //
        //
        // Step 1
        update_user_meta( $user_id, 'have_children'               , $have_children );
        update_user_meta( $user_id, 'married_status'              , rgar( $entry, $map['fields']['step_1']['married_status'] ) );
        update_user_meta( $user_id, 'no_of_children'              , rgar( $entry, $map['fields']['step_1']['no_of_children'] ) );

        //
        //
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

        $result = array();

        // Ready to apply check
        $result['step_2'] = intval( step_check_ready( $map['fields']['step_2']['required'], $entry ) );

        //
        //
        // Step 3
        update_user_meta( $user_id, 'spouse_first_name'           , rgar( $entry, $map['fields']['step_3']['first_name'] ) );
        update_user_meta( $user_id, 'spouse_middle_name'          , rgar( $entry, $map['fields']['step_3']['middle_name'] ) );
        update_user_meta( $user_id, 'spouse_last_name'            , rgar( $entry, $map['fields']['step_3']['last_name'] ) );
        update_user_meta( $user_id, 'spouse_birth_date'           , rgar( $entry, $map['fields']['step_3']['birth_date'] ) );
        update_user_meta( $user_id, 'spouse_gender'               , rgar( $entry, $map['fields']['step_3']['gender'] ) );
        update_user_meta( $user_id, 'spouse_birth_city'           , rgar( $entry, $map['fields']['step_3']['birth_city'] ) );
        update_user_meta( $user_id, 'spouse_birth_country'        , rgar( $entry, $map['fields']['step_3']['birth_country'] ) );
        update_user_meta( $user_id, 'spouse_education_level'      , rgar( $entry, $map['fields']['step_3']['education_level'] ) );
        update_user_meta( $user_id, 'spouse_occupation'           , rgar( $entry, $map['fields']['step_3']['occupation'] ) );
        update_user_meta( $user_id, 'spouse_work_experience'      , rgar( $entry, $map['fields']['step_3']['work_experience'] ) );
        update_user_meta( $user_id, 'spouse_annual_income'        , rgar( $entry, $map['fields']['step_3']['annual_income'] ) );
        update_user_meta( $user_id, 'spouse_english_level'        , rgar( $entry, $map['fields']['step_3']['english_level'] ) );

        // Ready to apply check
        $result['step_3'] = intval( step_check_ready( $map['fields']['step_3']['required'], $entry ) );


        //
        //
        // Step 4
        update_user_meta( $user_id, 'child_1_first_name'          , rgar( $entry, $map['fields']['step_4']['first_name'] ) );
        update_user_meta( $user_id, 'child_1_last_name'           , rgar( $entry, $map['fields']['step_4']['last_name'] ) );
        update_user_meta( $user_id, 'child_1_birth_date'          , rgar( $entry, $map['fields']['step_4']['birth_date'] ) );
        update_user_meta( $user_id, 'child_1_gender'              , rgar( $entry, $map['fields']['step_4']['gender'] ) );
        update_user_meta( $user_id, 'child_1_birth_city'          , rgar( $entry, $map['fields']['step_4']['birth_city'] ) );
        update_user_meta( $user_id, 'child_1_birth_country'       , rgar( $entry, $map['fields']['step_4']['birth_country'] ) );

        // Ready to apply check
        $result['step_4'] = intval( step_check_ready( $map['fields']['step_4']['required'], $entry ) );


        //
        //
        // Step 5
        update_user_meta( $user_id, 'child_2_first_name'          , rgar( $entry, $map['fields']['step_5']['first_name'] ) );
        update_user_meta( $user_id, 'child_2_last_name'           , rgar( $entry, $map['fields']['step_5']['last_name'] ) );
        update_user_meta( $user_id, 'child_2_birth_date'          , rgar( $entry, $map['fields']['step_5']['birth_date'] ) );
        update_user_meta( $user_id, 'child_2_gender'              , rgar( $entry, $map['fields']['step_5']['gender'] ) );
        update_user_meta( $user_id, 'child_2_birth_city'          , rgar( $entry, $map['fields']['step_5']['birth_city'] ) );
        update_user_meta( $user_id, 'child_2_birth_country'       , rgar( $entry, $map['fields']['step_5']['birth_country'] ) );

        // Ready to apply check
        // Ready to apply check
        $result['step_5'] = intval( step_check_ready( $map['fields']['step_5']['required'], $entry ) );


        //
        //
        // Step 6
        update_user_meta( $user_id, 'child_3_first_name'          , rgar( $entry, $map['fields']['step_6']['first_name'] ) );
        update_user_meta( $user_id, 'child_3_last_name'           , rgar( $entry, $map['fields']['step_6']['last_name'] ) );
        update_user_meta( $user_id, 'child_3_birth_date'          , rgar( $entry, $map['fields']['step_6']['birth_date'] ) );
        update_user_meta( $user_id, 'child_3_gender'              , rgar( $entry, $map['fields']['step_6']['gender'] ) );
        update_user_meta( $user_id, 'child_3_birth_city'          , rgar( $entry, $map['fields']['step_6']['birth_city'] ) );
        update_user_meta( $user_id, 'child_3_birth_country'       , rgar( $entry, $map['fields']['step_6']['birth_country'] ) );

        // Ready to apply check
        $result['step_6'] = intval( step_check_ready( $map['fields']['step_6']['required'], $entry ) );


        //
        //
        // Step 7
        update_user_meta( $user_id, 'child_4_first_name'          , rgar( $entry, $map['fields']['step_7']['first_name'] ) );
        update_user_meta( $user_id, 'child_4_last_name'           , rgar( $entry, $map['fields']['step_7']['last_name'] ) );
        update_user_meta( $user_id, 'child_4_birth_date'          , rgar( $entry, $map['fields']['step_7']['birth_date'] ) );
        update_user_meta( $user_id, 'child_4_gender'              , rgar( $entry, $map['fields']['step_7']['gender'] ) );
        update_user_meta( $user_id, 'child_4_birth_city'          , rgar( $entry, $map['fields']['step_7']['birth_city'] ) );
        update_user_meta( $user_id, 'child_4_birth_country'       , rgar( $entry, $map['fields']['step_7']['birth_country'] ) );

        // Ready to apply check
        $result['step_7'] = intval( step_check_ready( $map['fields']['step_7']['required'], $entry ) );


        //
        //
        // Step 8
        update_user_meta( $user_id, 'child_5_first_name'          , rgar( $entry, $map['fields']['step_8']['first_name'] ) );
        update_user_meta( $user_id, 'child_5_last_name'           , rgar( $entry, $map['fields']['step_8']['last_name'] ) );
        update_user_meta( $user_id, 'child_5_birth_date'          , rgar( $entry, $map['fields']['step_8']['birth_date'] ) );
        update_user_meta( $user_id, 'child_5_gender'              , rgar( $entry, $map['fields']['step_8']['gender'] ) );
        update_user_meta( $user_id, 'child_5_birth_city'          , rgar( $entry, $map['fields']['step_8']['birth_city'] ) );
        update_user_meta( $user_id, 'child_5_birth_country'       , rgar( $entry, $map['fields']['step_8']['birth_country'] ) );

        // Ready to apply check
        $result['step_8'] = intval( step_check_ready( $map['fields']['step_8']['required'], $entry ) );


        //
        //
        // Step 9
        update_user_meta( $user_id, 'child_6_first_name'          , rgar( $entry, $map['fields']['step_9']['first_name'] ) );
        update_user_meta( $user_id, 'child_6_last_name'           , rgar( $entry, $map['fields']['step_9']['last_name'] ) );
        update_user_meta( $user_id, 'child_6_birth_date'          , rgar( $entry, $map['fields']['step_9']['birth_date'] ) );
        update_user_meta( $user_id, 'child_6_gender'              , rgar( $entry, $map['fields']['step_9']['gender'] ) );
        update_user_meta( $user_id, 'child_6_birth_city'          , rgar( $entry, $map['fields']['step_9']['birth_city'] ) );
        update_user_meta( $user_id, 'child_6_birth_country'       , rgar( $entry, $map['fields']['step_9']['birth_country'] ) );

        // Ready to apply check
        $result['step_9'] = intval( step_check_ready( $map['fields']['step_9']['required'], $entry ) );


        //
        //
        // Step 10
        update_user_meta( $user_id, 'child_7_first_name'          , rgar( $entry, $map['fields']['step_10']['first_name'] ) );
        update_user_meta( $user_id, 'child_7_last_name'           , rgar( $entry, $map['fields']['step_10']['last_name'] ) );
        update_user_meta( $user_id, 'child_7_birth_date'          , rgar( $entry, $map['fields']['step_10']['birth_date'] ) );
        update_user_meta( $user_id, 'child_7_gender'              , rgar( $entry, $map['fields']['step_10']['gender'] ) );
        update_user_meta( $user_id, 'child_7_birth_city'          , rgar( $entry, $map['fields']['step_10']['birth_city'] ) );
        update_user_meta( $user_id, 'child_7_birth_country'       , rgar( $entry, $map['fields']['step_10']['birth_country'] ) );

        // Ready to apply check
        $result['step_10'] = intval( step_check_ready( $map['fields']['step_10']['required'], $entry ) );


        //
        //
        // Step 11
        update_user_meta( $user_id, 'child_8_first_name'          , rgar( $entry, $map['fields']['step_11']['first_name'] ) );
        update_user_meta( $user_id, 'child_8_last_name'           , rgar( $entry, $map['fields']['step_11']['last_name'] ) );
        update_user_meta( $user_id, 'child_8_birth_date'          , rgar( $entry, $map['fields']['step_11']['birth_date'] ) );
        update_user_meta( $user_id, 'child_8_gender'              , rgar( $entry, $map['fields']['step_11']['gender'] ) );
        update_user_meta( $user_id, 'child_8_birth_city'          , rgar( $entry, $map['fields']['step_11']['birth_city'] ) );
        update_user_meta( $user_id, 'child_8_birth_country'       , rgar( $entry, $map['fields']['step_11']['birth_country'] ) );

        // Ready to apply check
        $result['step_11'] = intval( step_check_ready( $map['fields']['step_11']['required'], $entry ) );


        //
        //
        // Step 12
        update_user_meta( $user_id, 'child_9_first_name'          , rgar( $entry, $map['fields']['step_12']['first_name'] ) );
        update_user_meta( $user_id, 'child_9_last_name'           , rgar( $entry, $map['fields']['step_12']['last_name'] ) );
        update_user_meta( $user_id, 'child_9_birth_date'          , rgar( $entry, $map['fields']['step_12']['birth_date'] ) );
        update_user_meta( $user_id, 'child_9_gender'              , rgar( $entry, $map['fields']['step_12']['gender'] ) );
        update_user_meta( $user_id, 'child_9_birth_city'          , rgar( $entry, $map['fields']['step_12']['birth_city'] ) );
        update_user_meta( $user_id, 'child_9_birth_country'       , rgar( $entry, $map['fields']['step_12']['birth_country'] ) );

        // Ready to apply check
        $result['step_12'] = intval( step_check_ready( $map['fields']['step_12']['required'], $entry ) );


        //
        //
        // Step 13
        update_user_meta( $user_id, 'child_10_first_name'          , rgar( $entry, $map['fields']['step_13']['first_name'] ) );
        update_user_meta( $user_id, 'child_10_last_name'           , rgar( $entry, $map['fields']['step_13']['last_name'] ) );
        update_user_meta( $user_id, 'child_10_birth_date'          , rgar( $entry, $map['fields']['step_13']['birth_date'] ) );
        update_user_meta( $user_id, 'child_10_gender'              , rgar( $entry, $map['fields']['step_13']['gender'] ) );
        update_user_meta( $user_id, 'child_10_birth_city'          , rgar( $entry, $map['fields']['step_13']['birth_city'] ) );
        update_user_meta( $user_id, 'child_10_birth_country'       , rgar( $entry, $map['fields']['step_13']['birth_country'] ) );

        // Ready to apply check
        $result['step_13'] = intval( step_check_ready( $map['fields']['step_13']['required'], $entry ) );


        //
        //
        // Step 14
        update_user_meta( $user_id, 'child_11_first_name'          , rgar( $entry, $map['fields']['step_14']['first_name'] ) );
        update_user_meta( $user_id, 'child_11_last_name'           , rgar( $entry, $map['fields']['step_14']['last_name'] ) );
        update_user_meta( $user_id, 'child_11_birth_date'          , rgar( $entry, $map['fields']['step_14']['birth_date'] ) );
        update_user_meta( $user_id, 'child_11_gender'              , rgar( $entry, $map['fields']['step_14']['gender'] ) );
        update_user_meta( $user_id, 'child_11_birth_city'          , rgar( $entry, $map['fields']['step_14']['birth_city'] ) );
        update_user_meta( $user_id, 'child_11_birth_country'       , rgar( $entry, $map['fields']['step_14']['birth_country'] ) );

        // Ready to apply check
        $result['step_14'] = intval( step_check_ready( $map['fields']['step_14']['required'], $entry ) );


        //
        //
        // Step 15
        update_user_meta( $user_id, 'child_12_first_name'          , rgar( $entry, $map['fields']['step_15']['first_name'] ) );
        update_user_meta( $user_id, 'child_12_last_name'           , rgar( $entry, $map['fields']['step_15']['last_name'] ) );
        update_user_meta( $user_id, 'child_12_birth_date'          , rgar( $entry, $map['fields']['step_15']['birth_date'] ) );
        update_user_meta( $user_id, 'child_12_gender'              , rgar( $entry, $map['fields']['step_15']['gender'] ) );
        update_user_meta( $user_id, 'child_12_birth_city'          , rgar( $entry, $map['fields']['step_15']['birth_city'] ) );
        update_user_meta( $user_id, 'child_12_birth_country'       , rgar( $entry, $map['fields']['step_15']['birth_country'] ) );

        // Ready to apply check
        $result['step_15'] = intval( step_check_ready( $map['fields']['step_15']['required'], $entry ) );


        //
        //
        // Step 16
        update_user_meta( $user_id, 'child_13_first_name'          , rgar( $entry, $map['fields']['step_16']['first_name'] ) );
        update_user_meta( $user_id, 'child_13_last_name'           , rgar( $entry, $map['fields']['step_16']['last_name'] ) );
        update_user_meta( $user_id, 'child_13_birth_date'          , rgar( $entry, $map['fields']['step_16']['birth_date'] ) );
        update_user_meta( $user_id, 'child_13_gender'              , rgar( $entry, $map['fields']['step_16']['gender'] ) );
        update_user_meta( $user_id, 'child_13_birth_city'          , rgar( $entry, $map['fields']['step_16']['birth_city'] ) );
        update_user_meta( $user_id, 'child_13_birth_country'       , rgar( $entry, $map['fields']['step_16']['birth_country'] ) );

        // Ready to apply check
        $result['step_16'] = intval( step_check_ready( $map['fields']['step_16']['required'], $entry ) );


        //
        //
        // Step 17
        update_user_meta( $user_id, 'child_14_first_name'          , rgar( $entry, $map['fields']['step_17']['first_name'] ) );
        update_user_meta( $user_id, 'child_14_last_name'           , rgar( $entry, $map['fields']['step_17']['last_name'] ) );
        update_user_meta( $user_id, 'child_14_birth_date'          , rgar( $entry, $map['fields']['step_17']['birth_date'] ) );
        update_user_meta( $user_id, 'child_14_gender'              , rgar( $entry, $map['fields']['step_17']['gender'] ) );
        update_user_meta( $user_id, 'child_14_birth_city'          , rgar( $entry, $map['fields']['step_17']['birth_city'] ) );
        update_user_meta( $user_id, 'child_14_birth_country'       , rgar( $entry, $map['fields']['step_17']['birth_country'] ) );

        // Ready to apply check
        $result['step_17'] = intval( step_check_ready( $map['fields']['step_17']['required'], $entry ) );

        //
        //
        // Step 18
        update_user_meta( $user_id, 'child_15_first_name'          , rgar( $entry, $map['fields']['step_18']['first_name'] ) );
        update_user_meta( $user_id, 'child_15_last_name'           , rgar( $entry, $map['fields']['step_18']['last_name'] ) );
        update_user_meta( $user_id, 'child_15_birth_date'          , rgar( $entry, $map['fields']['step_18']['birth_date'] ) );
        update_user_meta( $user_id, 'child_15_gender'              , rgar( $entry, $map['fields']['step_18']['gender'] ) );
        update_user_meta( $user_id, 'child_15_birth_city'          , rgar( $entry, $map['fields']['step_18']['birth_city'] ) );
        update_user_meta( $user_id, 'child_15_birth_country'       , rgar( $entry, $map['fields']['step_18']['birth_country'] ) );

        // Ready to apply check
        $result['step_18'] = intval( step_check_ready( $map['fields']['step_18']['required'], $entry ) );


        //
        //
        // Step 19
        update_user_meta( $user_id, 'route'                       , rgar( $entry, $map['fields']['step_19']['route'] ) );
        update_user_meta( $user_id, 'street_number'               , rgar( $entry, $map['fields']['step_19']['street_number'] ) );
        update_user_meta( $user_id, 'locality'                    , rgar( $entry, $map['fields']['step_19']['locality'] ) );
        update_user_meta( $user_id, 'administrative_area_level_1' , rgar( $entry, $map['fields']['step_19']['district'] ) );
        update_user_meta( $user_id, 'postal_code'                 , rgar( $entry, $map['fields']['step_19']['postal_code'] ) );
        update_user_meta( $user_id, 'country'                     , rgar( $entry, $map['fields']['step_19']['country'] ) );
        update_user_meta( $user_id, 'phone'                       , rgar( $entry, $map['fields']['step_19']['phone'] ) );
        update_user_meta( $user_id, 'email'                       , rgar( $entry, $map['fields']['step_19']['email'] ) );
        update_user_meta( $user_id, 'country_of_residence'        , rgar( $entry, $map['fields']['step_19']['country_of_residence'] ) );

        // Ready to apply check
        $result['step_19'] = intval( step_check_ready( $map['fields']['step_19']['required'], $entry ) );


        // Ready to apply collection
        update_user_meta( $user_id, 'ready_to_apply', $result );

    }




}