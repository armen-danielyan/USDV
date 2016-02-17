<?php

function usdv_form_cv() {

    if ( !is_user_logged_in() ) return;
    if ( is_admin() ) return;

    new USDV_Form_CV();
}
add_action( 'init', 'usdv_form_cv' );


class USDV_Form_CV extends USDV_Form_Base
{
    /**
     * USDV_Form_CV constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->setMap( 'map.cv.json' );

        add_filter( 'gform_pre_render_12', array( $this, 'RenderForm' ) );

        add_action( 'gform_after_submission_12', array( $this, 'UpdateForm' ), 10, 2 );

        add_filter( 'gform_confirmation_12', array( $this, 'Confirmation' ), 10, 3 );
    }

    /**
     * CV upload form render
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
                case( $map['fields']['my_cv'] ):
                    $field['label'] = (get_user_meta( get_current_user_id(), 'first_name', true ) && get_user_meta( get_current_user_id(), 'last_name', true )) ? get_user_meta( get_current_user_id(), 'first_name', true ) .' '. get_user_meta( get_current_user_id(), 'last_name', true ) : 'My passport';
                    break;
                case( $map['fields']['spouse_cv'] ):
                    $field['label'] = (get_user_meta( get_current_user_id(), 'spouse_first_name', true ) && get_user_meta( get_current_user_id(), 'spouse_last_name', true )) ? get_user_meta( get_current_user_id(), 'spouse_first_name', true ) .' '. get_user_meta( get_current_user_id(), 'spouse_last_name', true ) : 'Spouse passport';
                    break;
                case( $map['fields']['child_1_cv'] ):
                    $field['label'] = (get_user_meta( get_current_user_id(), 'child_1_first_name', true ) ) ? get_user_meta( get_current_user_id(), 'child_1_first_name', true ) : 'Child 1 CV';
                    break;
                case( $map['fields']['child_2_cv'] ):
                    $field['label'] = (get_user_meta( get_current_user_id(), 'child_2_first_name', true ) ) ? get_user_meta( get_current_user_id(), 'child_2_first_name', true ) : 'Child 2 CV';
                    break;
                case( $map['fields']['child_3_cv'] ):
                    $field['label'] = (get_user_meta( get_current_user_id(), 'child_3_first_name', true ) ) ? get_user_meta( get_current_user_id(), 'child_3_first_name', true ) : 'Child 3 CV';
                    break;
                case( $map['fields']['child_4_cv'] ):
                    $field['label'] = (get_user_meta( get_current_user_id(), 'child_4_first_name', true ) ) ? get_user_meta( get_current_user_id(), 'child_4_first_name', true ) : 'Child 4 CV';
                    break;
                case( $map['fields']['child_5_cv'] ):
                    $field['label'] = (get_user_meta( get_current_user_id(), 'child_5_first_name', true ) ) ? get_user_meta( get_current_user_id(), 'child_5_first_name', true ) : 'Child 5 CV';
                    break;
                case( $map['fields']['child_6_cv'] ):
                    $field['label'] = (get_user_meta( get_current_user_id(), 'child_6_first_name', true ) ) ? get_user_meta( get_current_user_id(), 'child_6_first_name', true ) : 'Child 6 CV';
                    break;
                case( $map['fields']['child_7_cv'] ):
                    $field['label'] = (get_user_meta( get_current_user_id(), 'child_7_first_name', true ) ) ? get_user_meta( get_current_user_id(), 'child_7_first_name', true ) : 'Child 7 CV';
                    break;
                case( $map['fields']['child_8_cv'] ):
                    $field['label'] = (get_user_meta( get_current_user_id(), 'child_8_first_name', true ) ) ? get_user_meta( get_current_user_id(), 'child_8_first_name', true ) : 'Child 8 CV';
                    break;
                case( $map['fields']['child_9_cv'] ):
                    $field['label'] = (get_user_meta( get_current_user_id(), 'child_9_first_name', true ) ) ? get_user_meta( get_current_user_id(), 'child_9_first_name', true ) : 'Child 9 CV';
                    break;
                case( $map['fields']['child_10_cv'] ):
                    $field['label'] = (get_user_meta( get_current_user_id(), 'child_10_first_name', true ) ) ? get_user_meta( get_current_user_id(), 'child_10_first_name', true ) : 'Child 10 CV';
                    break;
                case( $map['fields']['child_11_cv'] ):
                    $field['label'] = (get_user_meta( get_current_user_id(), 'child_11_first_name', true ) ) ? get_user_meta( get_current_user_id(), 'child_11_first_name', true ) : 'Child 11 CV';
                    break;
                case( $map['fields']['child_12_cv'] ):
                    $field['label'] = (get_user_meta( get_current_user_id(), 'child_12_first_name', true ) ) ? get_user_meta( get_current_user_id(), 'child_12_first_name', true ) : 'Child 12 CV';
                    break;
                case( $map['fields']['child_13_cv'] ):
                    $field['label'] = (get_user_meta( get_current_user_id(), 'child_13_first_name', true ) ) ? get_user_meta( get_current_user_id(), 'child_13_first_name', true ) : 'Child 13 CV';
                    break;
                case( $map['fields']['child_14_cv'] ):
                    $field['label'] = (get_user_meta( get_current_user_id(), 'child_14_first_name', true ) ) ? get_user_meta( get_current_user_id(), 'child_14_first_name', true ) : 'Child 14 CV';
                    break;
                case( $map['fields']['child_15_cv'] ):
                    $field['label'] = (get_user_meta( get_current_user_id(), 'child_15_first_name', true ) ) ? get_user_meta( get_current_user_id(), 'child_15_first_name', true ) : 'Child 15 CV';
                    break;

                // Previews
                case( $map['fields']['my_preview'] ):
                    $field['content'] = get_user_meta( get_current_user_id(), 'cv_url', true ) ? '<a href="'.get_user_meta( get_current_user_id(), 'cv_url', true ).'">Download</a>' : '';
                    break;
                case( $map['fields']['spouse_preview'] ):
                    $field['content'] = get_user_meta( get_current_user_id(), 'spouse_cv_url', true )  ? '<a href="'.get_user_meta( get_current_user_id(), 'spouse_cv_url',  true ).'">'.__( 'Download', 'organicthemes' ).'</a>' : '';
                    break;
                case( $map['fields']['child_1_preview'] ):
                    $field['content'] = get_user_meta( get_current_user_id(), 'child_1_cv_url', true ) ? '<a href="'.get_user_meta( get_current_user_id(), 'child_1_cv_url', true ).'">'.__( 'Download', 'organicthemes' ).'</a>' : '';
                    break;
                case( $map['fields']['child_2_preview'] ):
                    $field['content'] = get_user_meta( get_current_user_id(), 'child_2_cv_url', true ) ? '<a href="'.get_user_meta( get_current_user_id(), 'child_2_cv_url', true ).'">'.__( 'Download', 'organicthemes' ).'</a>' : '';
                    break;
                case( $map['fields']['child_3_preview'] ):
                    $field['content'] = get_user_meta( get_current_user_id(), 'child_3_cv_url', true ) ? '<a href="'.get_user_meta( get_current_user_id(), 'child_3_cv_url', true ).'">'.__( 'Download', 'organicthemes' ).'</a>' : '';
                    break;
                case( $map['fields']['child_4_preview'] ):
                    $field['content'] = get_user_meta( get_current_user_id(), 'child_4_cv_url', true ) ? '<a href="'.get_user_meta( get_current_user_id(), 'child_4_cv_url', true ).'">'.__( 'Download', 'organicthemes' ).'</a>' : '';
                    break;
                case( $map['fields']['child_5_preview'] ):
                    $field['content'] = get_user_meta( get_current_user_id(), 'child_5_cv_url', true ) ? '<a href="'.get_user_meta( get_current_user_id(), 'child_5_cv_url', true ).'">'.__( 'Download', 'organicthemes' ).'</a>' : '';
                    break;
                case( $map['fields']['child_6_preview'] ):
                    $field['content'] = get_user_meta( get_current_user_id(), 'child_6_cv_url', true ) ? '<a href="'.get_user_meta( get_current_user_id(), 'child_6_cv_url', true ).'">'.__( 'Download', 'organicthemes' ).'</a>' : '';
                    break;
                case( $map['fields']['child_7_preview'] ):
                    $field['content'] = get_user_meta( get_current_user_id(), 'child_7_cv_url', true ) ? '<a href="'.get_user_meta( get_current_user_id(), 'child_7_cv_url', true ).'">'.__( 'Download', 'organicthemes' ).'</a>' : '';
                    break;
                case( $map['fields']['child_8_preview'] ):
                    $field['content'] = get_user_meta( get_current_user_id(), 'child_8_cv_url', true ) ? '<a href="'.get_user_meta( get_current_user_id(), 'child_8_cv_url', true ).'">'.__( 'Download', 'organicthemes' ).'</a>' : '';
                    break;
                case( $map['fields']['child_9_preview'] ):
                    $field['content'] = get_user_meta( get_current_user_id(), 'child_9_cv_url', true ) ? '<a href="'.get_user_meta( get_current_user_id(), 'child_9_cv_url', true ).'">'.__( 'Download', 'organicthemes' ).'</a>' : '';
                    break;
                case( $map['fields']['child_10_preview'] ):
                    $field['content'] = get_user_meta( get_current_user_id(), 'child_10_cv_url', true ) ? '<a href="'.get_user_meta( get_current_user_id(), 'child_10_cv_url', true ).'">'.__( 'Download', 'organicthemes' ).'</a>' : '';
                    break;
                case( $map['fields']['child_11_preview'] ):
                    $field['content'] = get_user_meta( get_current_user_id(), 'child_11_cv_url', true ) ? '<a href="'.get_user_meta( get_current_user_id(), 'child_11_cv_url', true ).'">'.__( 'Download', 'organicthemes' ).'</a>' : '';
                    break;
                case( $map['fields']['child_12_preview'] ):
                    $field['content'] = get_user_meta( get_current_user_id(), 'child_12_cv_url', true ) ? '<a href="'.get_user_meta( get_current_user_id(), 'child_12_cv_url', true ).'">'.__( 'Download', 'organicthemes' ).'</a>' : '';
                    break;
                case( $map['fields']['child_13_preview'] ):
                    $field['content'] = get_user_meta( get_current_user_id(), 'child_13_cv_url', true ) ? '<a href="'.get_user_meta( get_current_user_id(), 'child_13_cv_url', true ).'">'.__( 'Download', 'organicthemes' ).'</a>' : '';
                    break;
                case( $map['fields']['child_14_preview'] ):
                    $field['content'] = get_user_meta( get_current_user_id(), 'child_14_cv_url', true ) ? '<a href="'.get_user_meta( get_current_user_id(), 'child_14_cv_url', true ).'">'.__( 'Download', 'organicthemes' ).'</a>' : '';
                    break;
                case( $map['fields']['child_15_preview'] ):
                    $field['content'] = get_user_meta( get_current_user_id(), 'child_15_cv_url', true ) ? '<a href="'.get_user_meta( get_current_user_id(), 'child_15_cv_url', true ).'">'.__( 'Download', 'organicthemes' ).'</a>' : '';
                    break;
            }
        }

        return $form;
    }

    /**
     * CV upload form update
     * @param $entry
     * @param $form
     */
    public function UpdateForm( $entry, $form )
    {
        $map = $this->getMap();

        if ( rgar( $entry, $map['fields']['my_cv'] ) )       update_user_meta( get_current_user_id(), 'cv_url'          , rgar( $entry, $map['fields']['my_cv'] ) );
        if ( rgar( $entry, $map['fields']['spouse_cv'] ) )   update_user_meta( get_current_user_id(), 'spouse_cv_url'   , rgar( $entry, $map['fields']['spouse_cv'] ) );
        if ( rgar( $entry, $map['fields']['child_1_cv'] ) )  update_user_meta( get_current_user_id(), 'child_1_cv_url'  , rgar( $entry, $map['fields']['child_1_cv'] ) );
        if ( rgar( $entry, $map['fields']['child_2_cv'] ) )  update_user_meta( get_current_user_id(), 'child_2_cv_url'  , rgar( $entry, $map['fields']['child_2_cv'] ) );
        if ( rgar( $entry, $map['fields']['child_3_cv'] ) )  update_user_meta( get_current_user_id(), 'child_3_cv_url'  , rgar( $entry, $map['fields']['child_3_cv'] ) );
        if ( rgar( $entry, $map['fields']['child_4_cv'] ) )  update_user_meta( get_current_user_id(), 'child_4_cv_url'  , rgar( $entry, $map['fields']['child_4_cv'] ) );
        if ( rgar( $entry, $map['fields']['child_5_cv'] ) )  update_user_meta( get_current_user_id(), 'child_5_cv_url'  , rgar( $entry, $map['fields']['child_5_cv'] ) );
        if ( rgar( $entry, $map['fields']['child_6_cv'] ) )  update_user_meta( get_current_user_id(), 'child_6_cv_url'  , rgar( $entry, $map['fields']['child_6_cv'] ) );
        if ( rgar( $entry, $map['fields']['child_7_cv'] ) )  update_user_meta( get_current_user_id(), 'child_7_cv_url'  , rgar( $entry, $map['fields']['child_7_cv'] ) );
        if ( rgar( $entry, $map['fields']['child_8_cv'] ) )  update_user_meta( get_current_user_id(), 'child_8_cv_url'  , rgar( $entry, $map['fields']['child_8_cv'] ) );
        if ( rgar( $entry, $map['fields']['child_9_cv'] ) )  update_user_meta( get_current_user_id(), 'child_9_cv_url'  , rgar( $entry, $map['fields']['child_9_cv'] ) );
        if ( rgar( $entry, $map['fields']['child_10_cv'] ) ) update_user_meta( get_current_user_id(), 'child_10_cv_url' , rgar( $entry, $map['fields']['child_10_cv'] ) );
        if ( rgar( $entry, $map['fields']['child_11_cv'] ) ) update_user_meta( get_current_user_id(), 'child_11_cv_url' , rgar( $entry, $map['fields']['child_11_cv'] ) );
        if ( rgar( $entry, $map['fields']['child_12_cv'] ) ) update_user_meta( get_current_user_id(), 'child_12_cv_url' , rgar( $entry, $map['fields']['child_12_cv'] ) );
        if ( rgar( $entry, $map['fields']['child_13_cv'] ) ) update_user_meta( get_current_user_id(), 'child_13_cv_url' , rgar( $entry, $map['fields']['child_13_cv'] ) );
        if ( rgar( $entry, $map['fields']['child_14_cv'] ) ) update_user_meta( get_current_user_id(), 'child_14_cv_url' , rgar( $entry, $map['fields']['child_14_cv'] ) );
        if ( rgar( $entry, $map['fields']['child_15_cv'] ) ) update_user_meta( get_current_user_id(), 'child_15_cv_url' , rgar( $entry, $map['fields']['child_15_cv'] ) );
    }

    /**
     * CV upload form confirmation url
     *
     * @param $confirmation
     * @param $form
     * @param $entry
     *
     * @return array
     */
    public function Confirmation( $confirmation, $form, $entry )
    {
        $confirmation = array( 'redirect' => $_SERVER['REQUEST_URI'] );
        return $confirmation;
    }
}