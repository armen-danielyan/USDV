<?php

function usdv_form_photo() {

    if ( !is_user_logged_in() ) return;
    if ( is_admin() ) return;

    new USDV_Form_Photo();
}
add_action( 'init', 'usdv_form_photo' );


class USDV_Form_Photo extends USDV_Form_Base
{
    /**
     * USDV_Form_Photo constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->setMap( 'map.photo.json' );

        add_filter( 'gform_pre_render_2', array( $this, 'RenderForm' ), 10 );

        add_action( 'gform_after_submission_2', array( $this, 'UpdateForm' ), 10, 2 );

        add_filter( 'gform_confirmation_2', array( $this, 'Conformation' ) );
    }

    /**
     * Upload photos form render
     * @param $form
     * @return mixed
     */
    public function RenderForm( $form )
    {
        $map = $this->getMap();

        foreach( $form['fields'] as &$field ) {

            switch ( $field['id'] ) {

                // Labels
                case( $map['fields']['married_status'] ):
                    $field['defaultValue'] = get_user_meta( get_current_user_id(), 'married_status', true );
                    break;
                case( $map['fields']['number_of_childs'] ):
                    $field['defaultValue'] = get_user_meta( get_current_user_id(), 'no_of_children', true );
                    break;
                case( $map['fields']['my_photo'] ):
                    $field['label'] = (get_user_meta( get_current_user_id(), 'first_name', true ) && get_user_meta( get_current_user_id(), 'last_name', true )) ? get_user_meta( get_current_user_id(), 'first_name', true ) .' '. get_user_meta( get_current_user_id(), 'last_name', true ) : 'My photo';
                    break;
                case( $map['fields']['spouse_photo'] ):
                    $field['label'] = (get_user_meta( get_current_user_id(), 'spouse_first_name', true ) && get_user_meta( get_current_user_id(), 'spouse_last_name', true )) ? get_user_meta( get_current_user_id(), 'spouse_first_name', true ) .' '. get_user_meta( get_current_user_id(), 'spouse_last_name', true ) : 'Spouse photo';
                    break;
                case( $map['fields']['child_1_photo'] ):
                    $field['label'] = (get_user_meta( get_current_user_id(), 'child_1_first_name', true ) ) ? get_user_meta( get_current_user_id(), 'child_1_first_name', true ) : 'Child 1 photo';
                    break;
                case( $map['fields']['child_2_photo'] ):
                    $field['label'] = (get_user_meta( get_current_user_id(), 'child_2_first_name', true ) ) ? get_user_meta( get_current_user_id(), 'child_2_first_name', true ) : 'Child 2 photo';
                    break;
                case( $map['fields']['child_3_photo'] ):
                    $field['label'] = (get_user_meta( get_current_user_id(), 'child_3_first_name', true ) ) ? get_user_meta( get_current_user_id(), 'child_3_first_name', true ) : 'Child 3 photo';
                    break;
                case( $map['fields']['child_4_photo'] ):
                    $field['label'] = (get_user_meta( get_current_user_id(), 'child_4_first_name', true ) ) ? get_user_meta( get_current_user_id(), 'child_4_first_name', true ) : 'Child 4 photo';
                    break;
                case( $map['fields']['child_5_photo'] ):
                    $field['label'] = (get_user_meta( get_current_user_id(), 'child_5_first_name', true ) ) ? get_user_meta( get_current_user_id(), 'child_5_first_name', true ) : 'Child 5 photo';
                    break;
                case( $map['fields']['child_6_photo'] ):
                    $field['label'] = (get_user_meta( get_current_user_id(), 'child_6_first_name', true ) ) ? get_user_meta( get_current_user_id(), 'child_6_first_name', true ) : 'Child 6 photo';
                    break;
                case( $map['fields']['child_7_photo'] ):
                    $field['label'] = (get_user_meta( get_current_user_id(), 'child_7_first_name', true ) ) ? get_user_meta( get_current_user_id(), 'child_7_first_name', true ) : 'Child 7 photo';
                    break;
                case( $map['fields']['child_8_photo'] ):
                    $field['label'] = (get_user_meta( get_current_user_id(), 'child_8_first_name', true ) ) ? get_user_meta( get_current_user_id(), 'child_8_first_name', true ) : 'Child 8 photo';
                    break;
                case( $map['fields']['child_9_photo'] ):
                    $field['label'] = (get_user_meta( get_current_user_id(), 'child_9_first_name', true ) ) ? get_user_meta( get_current_user_id(), 'child_9_first_name', true ) : 'Child 9 photo';
                    break;
                case( $map['fields']['child_10_photo'] ):
                    $field['label'] = (get_user_meta( get_current_user_id(), 'child_10_first_name', true ) ) ? get_user_meta( get_current_user_id(), 'child_10_first_name', true ) : 'Child 10 photo';
                    break;
                case( $map['fields']['child_11_photo'] ):
                    $field['label'] = (get_user_meta( get_current_user_id(), 'child_11_first_name', true ) ) ? get_user_meta( get_current_user_id(), 'child_11_first_name', true ) : 'Child 11 photo';
                    break;
                case( $map['fields']['child_12_photo'] ):
                    $field['label'] = (get_user_meta( get_current_user_id(), 'child_12_first_name', true ) ) ? get_user_meta( get_current_user_id(), 'child_12_first_name', true ) : 'Child 12 photo';
                    break;
                case( $map['fields']['child_13_photo'] ):
                    $field['label'] = (get_user_meta( get_current_user_id(), 'child_13_first_name', true ) ) ? get_user_meta( get_current_user_id(), 'child_13_first_name', true ) : 'Child 13 photo';
                    break;
                case( $map['fields']['child_14_photo'] ):
                    $field['label'] = (get_user_meta( get_current_user_id(), 'child_14_first_name', true ) ) ? get_user_meta( get_current_user_id(), 'child_14_first_name', true ) : 'Child 14 photo';
                    break;
                case( $map['fields']['child_15_photo'] ):
                    $field['label'] = (get_user_meta( get_current_user_id(), 'child_15_first_name', true ) ) ? get_user_meta( get_current_user_id(), 'child_15_first_name', true ) : 'Child 15 photo';
                    break;

                // Previews
                case( $map['fields']['my_preview'] ):
                    $field['content'] = get_user_meta( get_current_user_id(), 'photo_url', true ) ? '<img width="150" height="150" src="'.get_user_meta( get_current_user_id(), 'photo_url', true ).'"/>' : '<img width="150" height="150" src="'.get_template_directory_uri() . '/images/no_image.png'.'" />';
                    break;
                case( $map['fields']['spouse_preview'] ):
                    $field['content'] = get_user_meta( get_current_user_id(), 'spouse_photo_url', true ) ? '<img width="150" height="150" src="'.get_user_meta( get_current_user_id(), 'spouse_photo_url', true ).'"/>' : '<img width="150" height="150" src="'.get_template_directory_uri() . '/images/no_image.png'.'" />';
                    break;
                case( $map['fields']['child_1_preview'] ):
                    $field['content'] = get_user_meta( get_current_user_id(), 'child_1_photo_url', true ) ? '<img width="150" height="150" src="'.get_user_meta( get_current_user_id(), 'child_1_photo_url', true ).'"/>' : '<img width="150" height="150" src="'.get_template_directory_uri() . '/images/no_image.png'.'" />';
                    break;
                case( $map['fields']['child_2_preview'] ):
                    $field['content'] = get_user_meta( get_current_user_id(), 'child_2_photo_url', true ) ? '<img width="150" height="150" src="'.get_user_meta( get_current_user_id(), 'child_2_photo_url', true ).'"/>' : '<img width="150" height="150" src="'.get_template_directory_uri() . '/images/no_image.png'.'" />';
                    break;
                case( $map['fields']['child_3_preview'] ):
                    $field['content'] = get_user_meta( get_current_user_id(), 'child_3_photo_url', true ) ? '<img width="150" height="150" src="'.get_user_meta( get_current_user_id(), 'child_3_photo_url', true ).'"/>' : '<img width="150" height="150" src="'.get_template_directory_uri() . '/images/no_image.png'.'" />';
                    break;
                case( $map['fields']['child_4_preview'] ):
                    $field['content'] = get_user_meta( get_current_user_id(), 'child_4_photo_url', true ) ? '<img width="150" height="150" src="'.get_user_meta( get_current_user_id(), 'child_4_photo_url', true ).'"/>' : '<img width="150" height="150" src="'.get_template_directory_uri() . '/images/no_image.png'.'" />';
                    break;
                case( $map['fields']['child_5_preview'] ):
                    $field['content'] = get_user_meta( get_current_user_id(), 'child_5_photo_url', true ) ? '<img width="150" height="150" src="'.get_user_meta( get_current_user_id(), 'child_5_photo_url', true ).'"/>' : '<img width="150" height="150" src="'.get_template_directory_uri() . '/images/no_image.png'.'" />';
                    break;
                case( $map['fields']['child_6_preview'] ):
                    $field['content'] = get_user_meta( get_current_user_id(), 'child_6_photo_url', true ) ? '<img width="150" height="150" src="'.get_user_meta( get_current_user_id(), 'child_6_photo_url', true ).'"/>' : '<img width="150" height="150" src="'.get_template_directory_uri() . '/images/no_image.png'.'" />';
                    break;
                case( $map['fields']['child_7_preview'] ):
                    $field['content'] = get_user_meta( get_current_user_id(), 'child_7_photo_url', true ) ? '<img width="150" height="150" src="'.get_user_meta( get_current_user_id(), 'child_7_photo_url', true ).'"/>' : '<img width="150" height="150" src="'.get_template_directory_uri() . '/images/no_image.png'.'" />';
                    break;
                case( $map['fields']['child_8_preview'] ):
                    $field['content'] = get_user_meta( get_current_user_id(), 'child_8_photo_url', true ) ? '<img width="150" height="150" src="'.get_user_meta( get_current_user_id(), 'child_8_photo_url', true ).'"/>' : '<img width="150" height="150" src="'.get_template_directory_uri() . '/images/no_image.png'.'" />';
                    break;
                case( $map['fields']['child_9_preview'] ):
                    $field['content'] = get_user_meta( get_current_user_id(), 'child_9_photo_url', true ) ? '<img width="150" height="150" src="'.get_user_meta( get_current_user_id(), 'child_9_photo_url', true ).'"/>' : '<img width="150" height="150" src="'.get_template_directory_uri() . '/images/no_image.png'.'" />';
                    break;
                case( $map['fields']['child_10_preview'] ):
                    $field['content'] = get_user_meta( get_current_user_id(), 'child_10_photo_url', true ) ? '<img width="150" height="150" src="'.get_user_meta( get_current_user_id(), 'child_10_photo_url', true ).'"/>' : '<img width="150" height="150" src="'.get_template_directory_uri() . '/images/no_image.png'.'" />';
                    break;
                case( $map['fields']['child_11_preview'] ):
                    $field['content'] = get_user_meta( get_current_user_id(), 'child_11_photo_url', true ) ? '<img width="150" height="150" src="'.get_user_meta( get_current_user_id(), 'child_11_photo_url', true ).'"/>' : '<img width="150" height="150" src="'.get_template_directory_uri() . '/images/no_image.png'.'" />';
                    break;
                case( $map['fields']['child_12_preview'] ):
                    $field['content'] = get_user_meta( get_current_user_id(), 'child_12_photo_url', true ) ? '<img width="150" height="150" src="'.get_user_meta( get_current_user_id(), 'child_12_photo_url', true ).'"/>' : '<img width="150" height="150" src="'.get_template_directory_uri() . '/images/no_image.png'.'" />';
                    break;
                case( $map['fields']['child_13_preview'] ):
                    $field['content'] = get_user_meta( get_current_user_id(), 'child_13_photo_url', true ) ? '<img width="150" height="150" src="'.get_user_meta( get_current_user_id(), 'child_13_photo_url', true ).'"/>' : '<img width="150" height="150" src="'.get_template_directory_uri() . '/images/no_image.png'.'" />';
                    break;
                case( $map['fields']['child_14_preview'] ):
                    $field['content'] = get_user_meta( get_current_user_id(), 'child_14_photo_url', true ) ? '<img width="150" height="150" src="'.get_user_meta( get_current_user_id(), 'child_14_photo_url', true ).'"/>' : '<img width="150" height="150" src="'.get_template_directory_uri() . '/images/no_image.png'.'" />';
                    break;
                case( $map['fields']['child_15_preview'] ):
                    $field['content'] = get_user_meta( get_current_user_id(), 'child_15_photo_url', true ) ? '<img width="150" height="150" src="'.get_user_meta( get_current_user_id(), 'child_15_photo_url', true ).'"/>' : '<img width="150" height="150" src="'.get_template_directory_uri() . '/images/no_image.png'.'" />';
                    break;
            }
        }

        return $form;
    }

    /**
     * Upload photos form update
     *
     * @param $entry
     * @param $form
     *
     * @return void
     */
    public function UpdateForm( $entry, $form )
    {
        $map = $this->getMap();

        foreach( $entry as $item ) {

            if ( !empty( $entry[$map['fields']['my_photo']] )) {
                update_user_meta( get_current_user_id(), 'photo_url', wp_make_link_relative( $entry[$map['fields']['my_photo']] ) );
            }
            if ( !empty( $entry[$map['fields']['spouse_photo']] )) {
                update_user_meta( get_current_user_id(), 'spouse_photo_url', wp_make_link_relative( $entry[$map['fields']['spouse_photo']] ) );
            }
            if ( !empty( $entry[$map['fields']['child_1_photo']] )) {
                update_user_meta( get_current_user_id(), 'child_1_photo_url', wp_make_link_relative( $entry[$map['fields']['child_1_photo']] ) );
            }
            if ( !empty( $entry[$map['fields']['child_2_photo']] )) {
                update_user_meta( get_current_user_id(), 'child_2_photo_url', wp_make_link_relative( $entry[$map['fields']['child_2_photo']] ) );
            }
            if ( !empty( $entry[$map['fields']['child_3_photo']] )) {
                update_user_meta( get_current_user_id(), 'child_3_photo_url', wp_make_link_relative( $entry[$map['fields']['child_3_photo']] ) );
            }
            if ( !empty( $entry[$map['fields']['child_4_photo']] )) {
                update_user_meta( get_current_user_id(), 'child_4_photo_url', wp_make_link_relative( $entry[$map['fields']['child_4_photo']] ) );
            }
            if ( !empty( $entry[$map['fields']['child_5_photo']] )) {
                update_user_meta( get_current_user_id(), 'child_5_photo_url', wp_make_link_relative( $entry[$map['fields']['child_5_photo']] ) );
            }
            if ( !empty( $entry[$map['fields']['child_6_photo']] )) {
                update_user_meta( get_current_user_id(), 'child_6_photo_url', wp_make_link_relative( $entry[$map['fields']['child_6_photo']] ) );
            }
            if ( !empty( $entry[$map['fields']['child_7_photo']] )) {
                update_user_meta( get_current_user_id(), 'child_7_photo_url', wp_make_link_relative( $entry[$map['fields']['child_7_photo']] ) );
            }
            if ( !empty( $entry[$map['fields']['child_8_photo']] )) {
                update_user_meta( get_current_user_id(), 'child_8_photo_url', wp_make_link_relative( $entry[$map['fields']['child_8_photo']] ) );
            }
            if ( !empty( $entry[$map['fields']['child_9_photo']] )) {
                update_user_meta( get_current_user_id(), 'child_9_photo_url', wp_make_link_relative( $entry[$map['fields']['child_9_photo']] ) );
            }
            if ( !empty( $entry[$map['fields']['child_10_photo']] )) {
                update_user_meta( get_current_user_id(), 'child_10_photo_url', wp_make_link_relative( $entry[$map['fields']['child_10_photo']] ) );
            }
            if ( !empty( $entry[$map['fields']['child_11_photo']] )) {
                update_user_meta( get_current_user_id(), 'child_11_photo_url', wp_make_link_relative( $entry[$map['fields']['child_11_photo']] ) );
            }
            if ( !empty( $entry[$map['fields']['child_12_photo']] )) {
                update_user_meta( get_current_user_id(), 'child_12_photo_url', wp_make_link_relative( $entry[$map['fields']['child_12_photo']] ) );
            }
            if ( !empty( $entry[$map['fields']['child_13_photo']] )) {
                update_user_meta( get_current_user_id(), 'child_13_photo_url', wp_make_link_relative( $entry[$map['fields']['child_13_photo']] ) );
            }
            if ( !empty( $entry[$map['fields']['child_14_photo']] )) {
                update_user_meta( get_current_user_id(), 'child_14_photo_url', wp_make_link_relative( $entry[$map['fields']['child_14_photo']] ) );
            }
            if ( !empty( $entry[$map['fields']['child_15_photo']] )) {
                update_user_meta( get_current_user_id(), 'child_15_photo_url', wp_make_link_relative( $entry[$map['fields']['child_15_photo']] ) );
            }
        }
    }

    /**
     * Photos upload form confirmation
     *
     * @param $confirmation
     * @param $form
     * @param $entry
     *
     * @return array
     */
    public function Conformation( $confirmation, $form, $entry )
    {
        $confirmation = array( 'redirect' => $_SERVER['REQUEST_URI'] );
        return $confirmation;
    }
}