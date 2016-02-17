<div id="usdv_member_details">

    <h3>US DV Apply Statistic</h3>

<table class="form-table">
    <tbody>
    <tr class="user-first-name-wrap">
        <th><label for="first_name">Eligible</label></th>
        <td>
            <strong>
                <?php
                $eligible = get_user_meta($user_id, 'DV_eligible', true);
                if ( ! $eligible ) {
                    echo 'Not checked';
                } elseif ( $eligible == 1 ) {
                    echo 'Yes';
                } else {
                    echo 'No';
                }
                ?>
            </strong>
        </td>
    </tr>
    <?php if($eligible != 1){ ?>
        <tr class="user-first-name-wrap">
            <th><label for="first_name">Immigrate To</label></th>
            <td>
                <strong>
                    <?php $emmigrate_to = get_user_meta($user_id, 'immigrate_to', true);
                    if ( ! $emmigrate_to ) {
                        echo 'Not set';
                    } else {
                        echo $emmigrate_to;
                    }
                    ?>
                </strong>
            </td>
        </tr>
    <?php }?>

    <tr class="user-first-name-wrap">
        <th><label for="first_name">Payment Status</label></th>
        <td><strong><?php
                $payment = get_user_meta($user_id, 'payment', true);
                echo $payment && $payment == 1 ? 'Paid' : 'Not Paid';
                ?></strong>
        </td>
    </tr>

    </tbody>
</table>

    <?php //echo do_shortcode('[gravityform id="9" title="false" description="false"]'); ?>

</div>