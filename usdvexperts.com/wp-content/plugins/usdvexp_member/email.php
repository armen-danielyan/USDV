<?php
/*
Plugin Name: Usdvexp Plugin
Description: Custom function plugin for email
Version: 1.0
*/

if ( !function_exists( 'wp_new_user_notification' ) ) {
    function wp_new_user_notification( $user_id, $plaintext_pass = '' ) {

        // set content type to html
        add_filter( 'wp_mail_content_type', 'wpmail_content_type' );

        // user
        $user = new WP_User( $user_id );

        // The blogname option is escaped with esc_html on the way into the database in sanitize_option
        // we want to reverse this for the plain text arena of emails.
        $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

        $message  = sprintf(__('New user registration on your site %s:'), $blogname) . "\r\n\r\n";
        $message .= sprintf(__('Username: %s'), $user->user_login) . "\r\n\r\n";
        $message .= sprintf(__('E-mail: %s'), $user->user_email) . "\r\n";

       // @wp_mail(get_option('admin_email'), sprintf(__('[%s] New User Registration'), $blogname), $message);

        if ( empty($plaintext_pass) )
            return;

        //BUILD USER NOTIFICATION EMAIL

        $subject  = sprintf(__('Registration success on %s:'), $blogname) . "\r\n\r\n";

        //Get e-mail template
        $message_template = file_get_contents(ABSPATH . '/wp-content/plugins/usdvexp_member/email_templates/registration.php');
        //replace placeholders with user-specific content
        $message = str_ireplace('[email]', $user->user_email, $message_template);
        $message = str_ireplace('[password]', $plaintext_pass, $message);
        $message = str_ireplace('[login_url]', get_permalink(979), $message);
        $message = str_ireplace('[user_name]', $user->first_name . ' ' .$user->last_name, $message);
        //Prepare headers for HTML
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        //Send user notification email
        wp_mail($user->user_email, $subject, $message, $headers);


        // remove html content type
        remove_filter ( 'wp_mail_content_type', 'wpmail_content_type' );
    }
}

function wpmail_content_type() {

    return 'text/html';
}