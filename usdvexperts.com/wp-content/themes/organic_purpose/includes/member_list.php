<?php
/*************************** LOAD THE BASE CLASS *******************************
 *******************************************************************************
 * The WP_List_Table class isn't automatically available to plugins, so we need
 * to check if it's available and load it if necessary.
 */
if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}


require_once(ABSPATH . 'phpexcel/PHPExcel.php');

/**
 * Create a new list table that extends the core WP_List_Table class.
 * WP_List_Table contains most of the framework for generating the table, but we
 * need to define and override some methods so that our data can be displayed
 * exactly the way we need it to be.
 */
class Registered_Member_List_Table extends WP_List_Table{

    /** ************************************************************************
     * REQUIRED. Set up a constructor that references the parent constructor. We
     * use the parent reference to set some default configs.
     ***************************************************************************/
    function __construct(){
        global $status, $page;

        //Set parent defaults
        parent::__construct(array(
            'singular' => 'member_id',
            'plural' => 'member_ids',
            'ajax' => false
        ));

    }


    /**
     * column_default()
     *
     * For more detailed insight into how columns are handled, take a look at
     * WP_List_Table::single_row_columns()
     *
     * @param array $item A singular item (one full row's worth of data)
     * @param array $column_name The name/slug of the column to be processed
     * @return string Text or HTML to be placed inside the column <td>
     **************************************************************************/
    function column_default($item, $column_name){
        switch ($column_name) {
            case 'name':
            case 'applicant':
            case 'spouse':
            case 'children':
            case 'eligible':
            case 'purpose_of_appliying':
            case 'payment':
            case 'phone':
            case 'registration_date':
                return $item[$column_name];
            default:
                return '';
        }
    }

    /**
     * column_cb()
     *
     * @see WP_List_Table::::single_row_columns()
     * @param array $item A singular item (one full row's worth of data)
     * @return string Text to be placed inside the column <td> (cal title only)
     **/
    function column_cb($item){
        return sprintf(
            '<input type="checkbox" name="%1$s[]" value="%2$s" />',
            /*$1%s*/
            $this->_args['singular'],
            /*$2%s*/
            $item['id']
        );
    }

    protected function _column_blogs( $user, $classes, $data, $primary ) {
        echo '<td class="', $classes, ' has-row-actions" ', $data, '>';
        echo $this->handle_row_actions( $user, 'blogs', $primary );
        echo '</td>';
    }


    /**
     * get_columns()
     *
     * @see WP_List_Table::::single_row_columns()
     * @return array An associative array containing column information: 'slugs'=>'Visible Titles'
     **/
    function get_columns(){
        $columns = array(
            'cb'                   => '<input type="checkbox" />',
            'name'                 => 'Name',
            'applicant'            => 'Applicant',
            'spouse'               => 'Spouse',
            'children'             => 'Children',
            'eligible'             => 'Eligible',
            'purpose_of_appliying' => 'Purpose for applying',
            'payment'              => 'Payment Status',
            'registration_date'    => 'Apply Date'
        );
        return $columns;
    }


    /**
     * get_sortable_columns()
     *
     * @return array An associative array containing all the columns that should be sortable: 'slugs'=>array('data_values',bool)
     **/
    function get_sortable_columns()    {
        $sortable_columns = array(
            'name' => array('name', false),
            'registration_date' => array('registration_date', false)
        );
        return $sortable_columns;
    }





    function extra_tablenav( $which ) {
        if ( $which == "top" ){
            ?>
                333
            <?php
        }
    }





    /**
     * get_bulk_actions()
     *
     * @return array An associative array containing all the bulk actions: 'slugs'=>'Visible Titles'
     **/
    function get_bulk_actions()
    {
        $actions = array(
            'bulk_delete' => 'Delete',
            'bulk_export' => 'Export'
        );
        return $actions;
    }


    /**
     * process_bulk_action()
     *
     * @see $this->prepare_items()
     **/
    function process_bulk_action()
    {
        //Bulk Delete when a bulk action is being triggered...
        if ('bulk_delete' === $this->current_action()) {

            if ($ids = $_GET['member_id']) {

                foreach ($ids as $id) {
                    // $wpdb->delete($table, array('id' => $id));
                    wp_delete_user( $id );
                }
                echo "<script language=\"javascript\">window.location.href='" . admin_url('admin.php?page=us-dv-apply-member') . "'</script>";
                exit;
            }
        }
        if ('bulk_export' === $this->current_action()) {
            if ($ids = $_GET['member_id']) {


                $objPHPExcel = new PHPExcel();
                $objPHPExcel->getProperties()->setTitle("Export USDV");

                $cnt = 1;
                foreach ($ids as $id) {
                    $user = get_user_meta($id);
                    $member = get_userdata($id);

                    $registration_date = $member->user_registered > 0 ? date('j M, Y g:i a', strtotime($member->user_registered)) : '';
                    $eligible = $user['DV_eligible'];
                    $payment = $user['payment'];

                    $objPHPExcel->setActiveSheetIndex(0);

                    $objPHPExcel->getActiveSheet()->setCellValue("A".$cnt, $user["middle_name"][0]." ".$user["first_name"][0]." ".$user["last_name"][0]);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
                    $objPHPExcel->getActiveSheet()->getStyle("A".$cnt)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

                    $objPHPExcel->getActiveSheet()->setCellValue("B".$cnt, "Name: " . $user["middle_name"][0] . " " . $user["first_name"][0] . " " . $user["last_name"][0] . "\n" .
                                                            "Birth Country: "   . $user["birth_country"][0] . "\n" .
                                                            "Date of Birth: "   . $user["birth_date"][0] . "\n" .
                                                            "Applicant Age: "   . getAge ( $user["birth_date"][0] ) . "\n" .
                                                            "Gender: "          . $user["gender"][0] . "\n" .
                                                            "Country: "         . $user["country_of_residence"][0] . "\n" .
                                                            "Email: "           . $member->user_email . "\n" .
                                                            "Phone: "           . $user["phone_code"][0] . " " . $user["phone"][0] . "\n" .
                                                            "Education level: " . $user["education_level"][0] . "\n" .
                                                            "Marital Status: "  . $user["married_status"][0] . "\n" .
                                                            "Occupation: "      . $user["occupation"][0] . "\n" .
                                                            "Annual income: "   . $user["annual_income"][0] . "\n" .
                                                            "Work experience: " . $user["work_experience"][0] . "\n" .
                                                            "Been to USA: "     . $user["been_to_usa"][0] . "\n" .
                                                            "English Level: "   . $user["english_level"][0] );
                    $objPHPExcel->getActiveSheet()->getStyle("B".$cnt)->getAlignment()->setWrapText(true);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
                    $objPHPExcel->getActiveSheet()->getStyle("B".$cnt)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

                    $objPHPExcel->getActiveSheet()->setCellValue("C".$cnt, "Name: "            . $user["spouse_middle_name"][0] . " " . $user["spouse_first_name"][0] . " " . $user["spouse_last_name"][0] . "\n" .
                                                            "Birth Country: "   . $user["spouse_birth_country"][0] . "\n" .
                                                            "Date of Birth: "   . $user["spouse_birth_date"][0] . "\n" .
                                                            "Spouse Age: "      . getAge( $user["spouse_birth_date"][0] ) . "\n" .
                                                            "Gender: "          . $user["spouse_gender"][0] . "\n" .
                                                            "Education Level: " . $user["spouse_education_level"][0] . "\n" .
                                                            "Occupation: "      . $user["spouse_occupation"][0]. "\n" .
                                                            "Work experience: " . $user["spouse_work_experience"][0] . "\n" .
                                                            "English Level: "   . $user["spouse_english_level"][0] );
                    $objPHPExcel->getActiveSheet()->getStyle("C".$cnt)->getAlignment()->setWrapText(true);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
                    $objPHPExcel->getActiveSheet()->getStyle("C".$cnt)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

                    $objPHPExcel->getActiveSheet()->setCellValue("D".$cnt, "Have children: "   . $user["have_children"][0] . "\n" .
                                                            "Number of Children: " . $user["no_of_children"][0] );
                    $objPHPExcel->getActiveSheet()->getStyle("D".$cnt)->getAlignment()->setWrapText(true);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
                    $objPHPExcel->getActiveSheet()->getStyle("D".$cnt)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

                    $objPHPExcel->getActiveSheet()->setCellValue("E".$cnt, $eligible && $eligible == 1 ? "Yes" : "No");
                    $objPHPExcel->getActiveSheet()->getStyle("E".$cnt)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

                    $objPHPExcel->getActiveSheet()->setCellValue("F".$cnt, $user["purpose_of_appliying"][0]);
                    $objPHPExcel->getActiveSheet()->getStyle("F".$cnt)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

                    $objPHPExcel->getActiveSheet()->setCellValue("G".$cnt, $payment && $payment == 1 ? "Paid" : "Not Paid");
                    $objPHPExcel->getActiveSheet()->getStyle("G".$cnt)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

                    $objPHPExcel->getActiveSheet()->setCellValue("H".$cnt, $registration_date);
                    $objPHPExcel->getActiveSheet()->getStyle("H".$cnt)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

                    $cnt++;
                }


                $objPHPExcel->getActiveSheet()->setTitle('Export');
                $objPHPExcel->setActiveSheetIndex(0);

                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                // $objWriter->save(str_replace('.php', '.xls', __FILE__));
                $objWriter->save(ABSPATH . 'export/export-'.gmdate('d-M-Y-H-i-s').'.xls');

                return;

                // echo "<script language=\"javascript\">window.location.href='" . admin_url('admin.php?page=us-dv-apply-member') . "'</script>";
                // exit;
            }
        }
    }


    /**
     * prepare_items();
     *
     **************************************************************************/
    function prepare_items(){
        /**
         * First, lets decide how many records per page to show
         */
        $per_page = 10;

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();

        $this->_column_headers = array($columns, $hidden, $sortable);

        $this->process_bulk_action();

        /**
         * Get Data from cal_results table
         */
        if (isset($_GET['paged'])) {
            $start = $_GET['paged'] * $per_page;
        } else {
            $start = 0;
        }

        if ($members = get_users( 'role=member' )) {

            $data = array();
            foreach ($members as $member) {
              //user data
                $registration_date = $member->user_registered > 0 ? date('j M, Y g:i a', strtotime($member->user_registered)) : '';
                $eligible = get_user_meta($member->ID, 'DV_eligible', true);
                $payment = get_user_meta($member->ID, 'payment', true);

//                $edit_link =  admin_url( 'user-edit.php?user_id='.$member->ID.'#usdv_member_details' );
                $edit_link = 'admin.php?page=edit_data&user_id='.$member->ID.'#usdv_member_details';
                $data[] = array(
                    'id' => $member->ID,
                    'name' => '<strong><a href="' . $edit_link . '">' . get_user_meta( $member->ID, 'middle_name', true ) . ' ' . get_user_meta( $member->ID, 'first_name', true ) . ' ' . get_user_meta( $member->ID, 'last_name', true ) . '</a></strong>',

                    'applicant' =>
                        '<strong>Name: </strong><em>' . get_user_meta( $member->ID, 'middle_name', true ) . ' ' . get_user_meta( $member->ID, 'first_name', true ) . ' ' . get_user_meta( $member->ID, 'last_name', true ) . '</em><br/>'.
                        '<strong>Birth Country: </strong><em>'   . get_user_meta( $member->ID, 'birth_country', true ) . '</em><br/>'.
                        '<strong>Date of Birth: </strong><em>'   . get_user_meta( $member->ID, 'birth_date', true ) . '</em><br/>'.
                        '<strong>Applicant Age: </strong><em>'   . getAge( get_user_meta( $member->ID, 'birth_date', true ) ) . '</em><br/>'.
                        '<strong>Gender: </strong><em>'          . get_user_meta( $member->ID, 'gender', true ) . '</em><br/>'.
                        '<strong>Country: </strong><em>'         . get_user_meta( $member->ID, 'country_of_residence', true ) . '</em><br/>'.
                        '<strong>Email: </strong><em>'           . $member->user_email . '</em><br/>'.
                        '<strong>Phone: </strong><em>'           . get_user_meta( $member->ID, 'phone_code', true) . ' ' . get_user_meta( $member->ID, 'phone', true ) . '</em><br/>'.
                        '<strong>Education level: </strong><em>' . get_user_meta( $member->ID, 'education_level', true ) . '</em><br/>'.
                        '<strong>Marital Status: </strong><em>'  . get_user_meta( $member->ID, 'married_status', true ) . '</em><br/>'.
                        '<strong>Occupation: </strong><em>'      . get_user_meta( $member->ID, 'occupation', true ) . '</em><br/>'.
                        '<strong>Annual income: </strong><em>'   . get_user_meta( $member->ID, 'annual_income', true ) . '</em><br/>'.
                        '<strong>Work experience: </strong><em>' . get_user_meta( $member->ID, 'work_experience', true ) . '</em><br/>'.
                        '<strong>Been to USA: </strong><em>'     . get_user_meta( $member->ID, 'been_to_usa', true ) . '</em><br/>'.
                        '<strong>English Level: </strong><em>'   . get_user_meta( $member->ID, 'english_level', true ) . '</em><br/>',

                    'spouse' =>
                        '<strong>Name: </strong><em>'            . get_user_meta( $member->ID, 'spouse_middle_name', true ) . ' ' . get_user_meta( $member->ID, 'spouse_first_name', true ) . ' ' . get_user_meta( $member->ID, 'spouse_last_name', true ) . '</em><br/>'.
                        '<strong>Birth Country: </strong><em>'   . get_user_meta( $member->ID, 'spouse_birth_country', true ) . '</em><br/>'.
                        '<strong>Date of Birth: </strong><em>'   . get_user_meta( $member->ID, 'spouse_birth_date', true ) . '</em><br/>'.
                        '<strong>Spouse Age: </strong><em>'      . getAge( get_user_meta( $member->ID, 'spouse_birth_date', true ) ) . '</em><br/>'.
                        '<strong>Gender: </strong><em>'          . get_user_meta( $member->ID, 'spouse_gender', true ) . '</em><br/>'.
                        '<strong>Education Level: </strong><em>' . get_user_meta( $member->ID, 'spouse_education_level', true ) . '</em><br/>'.
                        '<strong>Occupation: </strong><em>'      . get_user_meta( $member->ID, 'spouse_occupation', true ) . '</em><br/>'.
                        '<strong>Work experience: </strong><em>' . get_user_meta( $member->ID, 'spouse_work_experience', true ) . '</em><br/>'.
                        '<strong>English Level: </strong><em>'   . get_user_meta( $member->ID, 'spouse_english_level', true ) . '</em><br/>',

                    'children' =>
                        '<strong>Have children: </strong><em>'   . get_user_meta( $member->ID, 'have_children', true ) . '</em><br/>'.
                        '<strong>Number of Children: </strong><em>' . get_user_meta( $member->ID, 'no_of_children', true ) . '</em><br/>',

                    'eligible' => $eligible && $eligible == 1 ? 'Yes' : 'No',
                    'purpose_of_appliying' => get_user_meta( $member->ID, 'purpose_of_appliying', true ),
                    'payment' => $payment && $payment == 1 ? 'Paid' : 'Not Paid',
                    'registration_date' => $registration_date
                );
            }
        }

        function usort_reorder($a, $b)
        {
            $orderby = (!empty($_REQUEST['orderby'])) ? $_REQUEST['orderby'] : 'registration_date'; //If no sort, default to title
            $order = (!empty($_REQUEST['order'])) ? $_REQUEST['order'] : 'desc'; //If no order, default to asc
            $result = strcmp($a[$orderby], $b[$orderby]); //Determine sort order
            return ($order === 'asc') ? $result : -$result; //Send final sort direction to usort
        }

        if (!empty($data)) {
            usort($data, 'usort_reorder');
        }

        $current_page = $this->get_pagenum();

        $totalUsers = get_users( 'role=member&count_total=true' );
        $total_items = count($totalUsers);

        /**
         * The WP_List_Table class does not handle pagination for us, so we need
         * to ensure that the data is trimmed to only the current page. We can use
         * array_slice() to
         */

        /**
         * REQUIRED. Now we can add our *sorted* data to the items property, where
         * it can be used by the rest of the class.
         */
        $this->items = $data;

        /**
         * REQUIRED. We also have to register our pagination options & calculations.
         */
        $this->set_pagination_args(array(
            'total_items' => $total_items,
            'per_page' => $per_page,
            'total_pages' => ceil($total_items / $per_page)
        ));
    }

    protected function handle_row_actions( $user, $column_name, $primary ) {
        if ( $primary !== $column_name ) {
            return '';
        }

//        $edit_link = esc_url( add_query_arg( 'wp_http_referer', urlencode( wp_unslash( $_SERVER['REQUEST_URI'] ) ), get_edit_user_link( $user->ID ) ) );

//        $edit_link =  admin_url( 'user-edit.php?user_id='.$user['id'].'#usdv_member_details' );
        $edit_link = 'admin.php?page=edit_data&user_id='.$user['id'].'#usdv_member_details';

        $actions = array();
        $actions['edit'] = '<a href="' . $edit_link . '">' . __( 'View Details' ) . '</a>';

        $actions = apply_filters( 'ms_user_row_actions', $actions, $user );
        return $this->row_actions( $actions );
    }

}