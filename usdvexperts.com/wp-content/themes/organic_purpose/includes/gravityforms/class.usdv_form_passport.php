<?php

function usdv_form_passport() {

    if ( !is_user_logged_in() ) return;
    if ( is_admin() ) return;

    new USDV_Form_Passport();
}
add_action( 'init', 'usdv_form_passport' );


class USDV_Form_Passport extends USDV_Form_Base
{
    /**
     * USDV_Form_Passport constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->setMap( 'map.passrorts.json' );

        add_filter( 'gform_pre_render_11', array( $this, 'RenderForm' ) );

        add_action( 'gform_after_submission_11', array( $this, 'UpdateForm' ), 10, 2 );

        add_filter( 'gform_confirmation_11', array( $this, 'Confirmation' ), 10, 3 );
    }

    /**
     * Passport upload form render user meta
     * @param $form
     * @return mixed
     */
    public function RenderForm( $form )
    {
        $map = $this->getMap();

        foreach ( $form['fields'] as &$field ) {
            switch ( $field['id'] ) {
                // Labels
                case( $map['fields']['married_status'] ):
                    $field['defaultValue'] = get_user_meta( get_current_user_id(), 'married_status', true );
                    break;
                case( $map['fields']['number_of_childs'] ):
                    $field['defaultValue'] = get_user_meta( get_current_user_id(), 'no_of_children', true );
                    break;
                case( $map['fields']['my_passport'] ):
                    $field['label'] = (get_user_meta( get_current_user_id(), 'first_name', true ) && get_user_meta( get_current_user_id(), 'last_name', true )) ? get_user_meta( get_current_user_id(), 'first_name', true ) .' '. get_user_meta( get_current_user_id(), 'last_name', true ) : 'My passport';
                    break;
                case( $map['fields']['spouse_passport'] ):
                    $field['label'] = (get_user_meta( get_current_user_id(), 'spouse_first_name', true ) && get_user_meta( get_current_user_id(), 'spouse_last_name', true )) ? get_user_meta( get_current_user_id(), 'spouse_first_name', true ) .' '. get_user_meta( get_current_user_id(), 'spouse_last_name', true ) : 'Spouse passport';
                    break;
                case( $map['fields']['child_1_passport'] ):
                    $field['label'] = (get_user_meta( get_current_user_id(), 'child_1_first_name', true ) ) ? get_user_meta( get_current_user_id(), 'child_1_first_name', true ) : 'Child 1 passport';
                    break;
                case( $map['fields']['child_2_passport'] ):
                    $field['label'] = (get_user_meta( get_current_user_id(), 'child_2_first_name', true ) ) ? get_user_meta( get_current_user_id(), 'child_2_first_name', true ) : 'Child 2 passport';
                    break;
                case( $map['fields']['child_3_passport'] ):
                    $field['label'] = (get_user_meta( get_current_user_id(), 'child_3_first_name', true ) ) ? get_user_meta( get_current_user_id(), 'child_3_first_name', true ) : 'Child 3 passport';
                    break;
                case( $map['fields']['child_4_passport'] ):
                    $field['label'] = (get_user_meta( get_current_user_id(), 'child_4_first_name', true ) ) ? get_user_meta( get_current_user_id(), 'child_4_first_name', true ) : 'Child 4 passport';
                    break;
                case( $map['fields']['child_5_passport'] ):
                    $field['label'] = (get_user_meta( get_current_user_id(), 'child_5_first_name', true ) ) ? get_user_meta( get_current_user_id(), 'child_5_first_name', true ) : 'Child 5 passport';
                    break;
                case( $map['fields']['child_6_passport'] ):
                    $field['label'] = (get_user_meta( get_current_user_id(), 'child_6_first_name', true ) ) ? get_user_meta( get_current_user_id(), 'child_6_first_name', true ) : 'Child 5 passport';
                    break;
                case( $map['fields']['child_7_passport'] ):
                    $field['label'] = (get_user_meta( get_current_user_id(), 'child_7_first_name', true ) ) ? get_user_meta( get_current_user_id(), 'child_7_first_name', true ) : 'Child 7 passport';
                    break;
                case( $map['fields']['child_8_passport'] ):
                    $field['label'] = (get_user_meta( get_current_user_id(), 'child_8_first_name', true ) ) ? get_user_meta( get_current_user_id(), 'child_8_first_name', true ) : 'Child 8 passport';
                    break;
                case( $map['fields']['child_9_passport'] ):
                    $field['label'] = (get_user_meta( get_current_user_id(), 'child_9_first_name', true ) ) ? get_user_meta( get_current_user_id(), 'child_9_first_name', true ) : 'Child 9 passport';
                    break;
                case( $map['fields']['child_10_passport'] ):
                    $field['label'] = (get_user_meta( get_current_user_id(), 'child_10_first_name', true ) ) ? get_user_meta( get_current_user_id(), 'child_10_first_name', true ) : 'Child 10 passport';
                    break;
                case( $map['fields']['child_11_passport'] ):
                    $field['label'] = (get_user_meta( get_current_user_id(), 'child_11_first_name', true ) ) ? get_user_meta( get_current_user_id(), 'child_11_first_name', true ) : 'Child 11 passport';
                    break;
                case( $map['fields']['child_12_passport'] ):
                    $field['label'] = (get_user_meta( get_current_user_id(), 'child_12_first_name', true ) ) ? get_user_meta( get_current_user_id(), 'child_12_first_name', true ) : 'Child 12 passport';
                    break;
                case( $map['fields']['child_13_passport'] ):
                    $field['label'] = (get_user_meta( get_current_user_id(), 'child_13_first_name', true ) ) ? get_user_meta( get_current_user_id(), 'child_13_first_name', true ) : 'Child 13 passport';
                    break;
                case( $map['fields']['child_14_passport'] ):
                    $field['label'] = (get_user_meta( get_current_user_id(), 'child_14_first_name', true ) ) ? get_user_meta( get_current_user_id(), 'child_14_first_name', true ) : 'Child 14 passport';
                    break;
                case( $map['fields']['child_15_passport'] ):
                    $field['label'] = (get_user_meta( get_current_user_id(), 'child_15_first_name', true ) ) ? get_user_meta( get_current_user_id(), 'child_15_first_name', true ) : 'Child 15 passport';
                    break;

                // Previews
                case( $map['fields']['my_preview'] ):
                    $field['content'] = get_user_meta( get_current_user_id(), 'passport_url', true ) ? '<img width="150" height="150" src="'.get_user_meta( get_current_user_id(), 'passport_url', true ).'"/>' : '<img width="150" height="150" src="'.get_template_directory_uri() . '/images/no_image.png'.'" />';
                    break;
                case( $map['fields']['spouse_preview'] ):
                    $field['content'] = get_user_meta( get_current_user_id(), 'spouse_passport_url', true ) ? '<img width="150" height="150" src="'.get_user_meta( get_current_user_id(), 'spouse_passport_url', true ).'"/>' : '<img width="150" height="150" src="'.get_template_directory_uri() . '/images/no_image.png'.'" />';
                    break;
                case( $map['fields']['child_1_preview'] ):
                    $field['content'] = get_user_meta( get_current_user_id(), 'child_1_passport_url', true ) ? '<img width="150" height="150" src="'.get_user_meta( get_current_user_id(), 'child_1_passport_url', true ).'"/>' : '<img width="150" height="150" src="'.get_template_directory_uri() . '/images/no_image.png'.'" />';
                    break;
                case( $map['fields']['child_2_preview'] ):
                    $field['content'] = get_user_meta( get_current_user_id(), 'child_2_passport_url', true ) ? '<img width="150" height="150" src="'.get_user_meta( get_current_user_id(), 'child_2_passport_url', true ).'"/>' : '<img width="150" height="150" src="'.get_template_directory_uri() . '/images/no_image.png'.'" />';
                    break;
                case( $map['fields']['child_3_preview'] ):
                    $field['content'] = get_user_meta( get_current_user_id(), 'child_3_passport_url', true ) ? '<img width="150" height="150" src="'.get_user_meta( get_current_user_id(), 'child_3_passport_url', true ).'"/>' : '<img width="150" height="150" src="'.get_template_directory_uri() . '/images/no_image.png'.'" />';
                    break;
                case( $map['fields']['child_4_preview'] ):
                    $field['content'] = get_user_meta( get_current_user_id(), 'child_4_passport_url', true ) ? '<img width="150" height="150" src="'.get_user_meta( get_current_user_id(), 'child_4_passport_url', true ).'"/>' : '<img width="150" height="150" src="'.get_template_directory_uri() . '/images/no_image.png'.'" />';
                    break;
                case( $map['fields']['child_5_preview'] ):
                    $field['content'] = get_user_meta( get_current_user_id(), 'child_5_passport_url', true ) ? '<img width="150" height="150" src="'.get_user_meta( get_current_user_id(), 'child_5_passport_url', true ).'"/>' : '<img width="150" height="150" src="'.get_template_directory_uri() . '/images/no_image.png'.'" />';
                    break;
                case( $map['fields']['child_6_preview'] ):
                    $field['content'] = get_user_meta( get_current_user_id(), 'child_6_passport_url', true ) ? '<img width="150" height="150" src="'.get_user_meta( get_current_user_id(), 'child_6_passport_url', true ).'"/>' : '<img width="150" height="150" src="'.get_template_directory_uri() . '/images/no_image.png'.'" />';
                    break;
                case( $map['fields']['child_7_preview'] ):
                    $field['content'] = get_user_meta( get_current_user_id(), 'child_7_passport_url', true ) ? '<img width="150" height="150" src="'.get_user_meta( get_current_user_id(), 'child_7_passport_url', true ).'"/>' : '<img width="150" height="150" src="'.get_template_directory_uri() . '/images/no_image.png'.'" />';
                    break;
                case( $map['fields']['child_8_preview'] ):
                    $field['content'] = get_user_meta( get_current_user_id(), 'child_8_passport_url', true ) ? '<img width="150" height="150" src="'.get_user_meta( get_current_user_id(), 'child_8_passport_url', true ).'"/>' : '<img width="150" height="150" src="'.get_template_directory_uri() . '/images/no_image.png'.'" />';
                    break;
                case( $map['fields']['child_9_preview'] ):
                    $field['content'] = get_user_meta( get_current_user_id(), 'child_9_passport_url', true ) ? '<img width="150" height="150" src="'.get_user_meta( get_current_user_id(), 'child_9_passport_url', true ).'"/>' : '<img width="150" height="150" src="'.get_template_directory_uri() . '/images/no_image.png'.'" />';
                    break;
                case( $map['fields']['child_10_preview'] ):
                    $field['content'] = get_user_meta( get_current_user_id(), 'child_10_passport_url', true ) ? '<img width="150" height="150" src="'.get_user_meta( get_current_user_id(), 'child_10_passport_url', true ).'"/>' : '<img width="150" height="150" src="'.get_template_directory_uri() . '/images/no_image.png'.'" />';
                    break;
                case( $map['fields']['child_11_preview'] ):
                    $field['content'] = get_user_meta( get_current_user_id(), 'child_11_passport_url', true ) ? '<img width="150" height="150" src="'.get_user_meta( get_current_user_id(), 'child_11_passport_url', true ).'"/>' : '<img width="150" height="150" src="'.get_template_directory_uri() . '/images/no_image.png'.'" />';
                    break;
                case( $map['fields']['child_12_preview'] ):
                    $field['content'] = get_user_meta( get_current_user_id(), 'child_12_passport_url', true ) ? '<img width="150" height="150" src="'.get_user_meta( get_current_user_id(), 'child_12_passport_url', true ).'"/>' : '<img width="150" height="150" src="'.get_template_directory_uri() . '/images/no_image.png'.'" />';
                    break;
                case( $map['fields']['child_13_preview'] ):
                    $field['content'] = get_user_meta( get_current_user_id(), 'child_13_passport_url', true ) ? '<img width="150" height="150" src="'.get_user_meta( get_current_user_id(), 'child_13_passport_url', true ).'"/>' : '<img width="150" height="150" src="'.get_template_directory_uri() . '/images/no_image.png'.'" />';
                    break;
                case( $map['fields']['child_14_preview'] ):
                    $field['content'] = get_user_meta( get_current_user_id(), 'child_14_passport_url', true ) ? '<img width="150" height="150" src="'.get_user_meta( get_current_user_id(), 'child_14_passport_url', true ).'"/>' : '<img width="150" height="150" src="'.get_template_directory_uri() . '/images/no_image.png'.'" />';
                    break;
                case( $map['fields']['child_15_preview'] ):
                    $field['content'] = get_user_meta( get_current_user_id(), 'child_15_passport_url', true ) ? '<img width="150" height="150" src="'.get_user_meta( get_current_user_id(), 'child_15_passport_url', true ).'"/>' : '<img width="150" height="150" src="'.get_template_directory_uri() . '/images/no_image.png'.'" />';
                    break;
            }
        }

        return $form;
    }

    /**
     * Passport upload form update user meta
     * @param $entry
     * @param $form
     * @return void
     */
    public function UpdateForm( $entry, $form )
    {
        $map = $this->getMap();

        if ( rgar( $entry, $map['fields']['my_passport'] ) )       update_user_meta( get_current_user_id(), 'passport_url'          , rgar( $entry, $map['fields']['my_passport'] ) );
        if ( rgar( $entry, $map['fields']['spouse_passport'] ) )   update_user_meta( get_current_user_id(), 'spouse_passport_url'   , rgar( $entry, $map['fields']['spouse_passport'] ) );
        if ( rgar( $entry, $map['fields']['child_1_passport'] ) )  update_user_meta( get_current_user_id(), 'child_1_passport_url'  , rgar( $entry, $map['fields']['child_1_passport'] ) );
        if ( rgar( $entry, $map['fields']['child_2_passport'] ) )  update_user_meta( get_current_user_id(), 'child_2_passport_url'  , rgar( $entry, $map['fields']['child_2_passport'] ) );
        if ( rgar( $entry, $map['fields']['child_3_passport'] ) )  update_user_meta( get_current_user_id(), 'child_3_passport_url'  , rgar( $entry, $map['fields']['child_3_passport'] ) );
        if ( rgar( $entry, $map['fields']['child_4_passport'] ) )  update_user_meta( get_current_user_id(), 'child_4_passport_url'  , rgar( $entry, $map['fields']['child_4_passport'] ) );
        if ( rgar( $entry, $map['fields']['child_5_passport'] ) )  update_user_meta( get_current_user_id(), 'child_5_passport_url'  , rgar( $entry, $map['fields']['child_5_passport'] ) );
        if ( rgar( $entry, $map['fields']['child_6_passport'] ) )  update_user_meta( get_current_user_id(), 'child_6_passport_url'  , rgar( $entry, $map['fields']['child_6_passport'] ) );
        if ( rgar( $entry, $map['fields']['child_7_passport'] ) )  update_user_meta( get_current_user_id(), 'child_7_passport_url'  , rgar( $entry, $map['fields']['child_7_passport'] ) );
        if ( rgar( $entry, $map['fields']['child_8_passport'] ) )  update_user_meta( get_current_user_id(), 'child_8_passport_url'  , rgar( $entry, $map['fields']['child_8_passport'] ) );
        if ( rgar( $entry, $map['fields']['child_9_passport'] ) )  update_user_meta( get_current_user_id(), 'child_9_passport_url'  , rgar( $entry, $map['fields']['child_9_passport'] ) );
        if ( rgar( $entry, $map['fields']['child_10_passport'] ) ) update_user_meta( get_current_user_id(), 'child_10_passport_url' , rgar( $entry, $map['fields']['child_10_passport'] ) );
        if ( rgar( $entry, $map['fields']['child_11_passport'] ) ) update_user_meta( get_current_user_id(), 'child_11_passport_url' , rgar( $entry, $map['fields']['child_11_passport'] ) );
        if ( rgar( $entry, $map['fields']['child_12_passport'] ) ) update_user_meta( get_current_user_id(), 'child_12_passport_url' , rgar( $entry, $map['fields']['child_12_passport'] ) );
        if ( rgar( $entry, $map['fields']['child_13_passport'] ) ) update_user_meta( get_current_user_id(), 'child_13_passport_url' , rgar( $entry, $map['fields']['child_13_passport'] ) );
        if ( rgar( $entry, $map['fields']['child_14_passport'] ) ) update_user_meta( get_current_user_id(), 'child_14_passport_url' , rgar( $entry, $map['fields']['child_14_passport'] ) );
        if ( rgar( $entry, $map['fields']['child_15_passport'] ) ) update_user_meta( get_current_user_id(), 'child_15_passport_url' , rgar( $entry, $map['fields']['child_15_passport'] ) );
    }

    /**
     * Passport upload form confirmation
     * @param $confirmation
     * @param $form
     * @param $entry
     * @return mixed
     */
    public function Confirmation( $confirmation, $form, $entry )
    {
        $confirmation = array( 'redirect' => $_SERVER['REQUEST_URI'] );
        return $confirmation;
    }
}