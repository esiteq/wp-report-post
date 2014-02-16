<?php

/**
 * @author Alex Raven
 * @company ESITEQ
 * @website http://www.esiteq.com/
 * @email bugrov at gmail.com
 * @created 21.9.2013
 * @version 0.1
 */

function wp_report_post_form_template($post_id)
{
    global $post, $current_user;
    get_currentuserinfo();
    $access = get_option("wp_report_post_access", 0);
    ob_start();
    if ($access==1 && !is_user_logged_in())
    {
/*
    Message for non-logged in users (if this feature is turned on in Settings)
*/
?>
<div class="wp-report-post-box">
    <div class="wp-report-post-sent" style="display: block;">
        <p><?php _e('You must be <a href="'. wp_login_url(). '">registered and logged in</a> to report inappropriate post.'); ?></p>
        <a class="wp-report-post-button" id="wp-report-post-dismiss"><?php _e("Dismiss"); ?></a>
    </div>
</div>
<?php
    }
    else
    {
/*
    Report form template starts here
*/
?>
<div class="wp-report-post-box">
    <div class="wp-report-post-sent">
        <p><?php _e("Your report has been successfully sent. We will review it soon and contact you back."); ?></p>
        <a class="wp-report-post-button" id="wp-report-post-dismiss"><?php _e("Dismiss"); ?></a>
    </div>
    <form method="post" id="wp-report-post-form" class="wp-report-post-form">
        <input type="hidden" name="action" id="wp-report-post-action" value="wp_report_post_ajax" />
        <input type="hidden" name="wp_report_post_id" id="wp-report-post-id" value="<?php echo $post_id; ?>" />
        <input type="hidden" name="wp_report_post_user_id" id="wp-report-post-user-id" value="<?php echo $current_user->ID; ?>" />
        <div class="wp-report-post-row">
            <div class="wp-report-post-form-left">
                <label for="wp-report-post-name" class="wp-report-post-label-left"><?php _e("Name"); ?> <span class="required">*</span></label> <input id="wp_report_post_name" name="wp_report_post_name" type="text" value="<?php echo $current_user->display_name; ?>" size="12" aria-required="true" />
            </div>
            <div class="wp-report-post-form-left">
                <label for="wp-report-post-email" class="wp-report-post-label-left"><?php _e("Email"); ?> <span class="required">*</span></label> <input id="wp_report_post_email" name="wp_report_post_email" type="text" value="<?php echo $current_user->user_email; ?>" size="12" aria-required="true" />
            </div>
            <div class="clear-both"></div>
        </div>
        <div class="wp-report-post-row">
            <div>
                <label for="wp-report-post-message"><?php _e("Please tell us why do you think this post or page is inappropriate"); ?> <span class="required">*</span></label>
                <textarea id="wp_report_post_message" name="wp_report_post_message" cols="45" rows="5" aria-required="true"></textarea>
            </div>
        </div>
        <div class="wp-report-post-msg"><?php _e("You have already reported this post before."); ?></div>
        <div class="wp-report-post-form-left">
            <a class="wp-report-post-button" id="wp-report-post-submit"><?php _e("Send Report"); ?></a>
        </div>
        <div class="wp-report-post-form-left text-right">
            <a id="wp-report-post-cancel" class="wp-report-post-button"><?php _e("Cancel"); ?></a>
        </div>
        <div class="clear-both"></div>
    </form>
</div>
<?php
/*
    Report form template ends here
*/
    }
    $output = ob_get_contents();
    ob_end_clean();
    echo addslashes(trim(str_replace("\r", "", str_replace("\n", "", $output))));
}

?>