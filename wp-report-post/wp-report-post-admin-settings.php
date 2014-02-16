<?php

/**
 * @author Alex Raven
 * @company ESITEQ
 * @website http://www.esiteq.com/
 * @email bugrov at gmail.com
 * @created 22.9.2013
 * @version 0.1
 */

if (!defined("ABSPATH"))
{
    die("Access denied");
}
$edit_url = get_admin_url(). "plugin-editor.php";

if ($_POST['action']=="update")
{
    update_option("wp_report_post_placement", $_POST['placement']);
    update_option("wp_report_post_access", $_POST['access']);
    update_option("wp_report_post_linktext", $_POST['linktext']);
    update_option("wp_report_post_icon", $_POST['icon']);
    update_option("wp_report_post_types", $_POST['types']);
    update_option("wp_report_post_email", $_POST['notify_email']);
}

$placement = get_option("wp_report_post_placement", 0);
$access = get_option("wp_report_post_access", 0);
$linktext = get_option("wp_report_post_linktext", "");
$icon = get_option("wp_report_post_icon", 1);
$types = get_option("wp_report_post_types", 0);
$notify_email = get_option("wp_report_post_email", "");
?>

<div class="wrap">
    <div id="icon-options-general" class="icon32">
        <br />
    </div>
    <h2>Report Post Settings</h2>
    <form method="post">
    <?php wp_nonce_field('update-options'); ?>
        <input type="hidden" name="action" value="update" />
        <table class="form-table">
            <tbody>
                <!-- Placement -->
                <tr>
                    <th scope="row">Report link placement</th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span>Placement</span></legend>
                            <label><input type="radio" name="placement" value="0"<?php if ($placement==0) echo ' checked="checked"'; ?> /> <span>Automatic: after the post's title</span></label><br />
                            <label><input type="radio" name="placement" value="1"<?php if ($placement==1) echo ' checked="checked"'; ?> /> <span>Automatic: in the post's footer</span></label><br />
                            <label><input type="radio" name="placement" value="2"<?php if ($placement==2) echo ' checked="checked"'; ?> /> <span>Manual: to use in your templates, pages or posts (can be placed anywhere)</span></label><br /><br />
                            Example of manual usage:<br />
                                <textarea readonly="readonly" rows="4" cols="100"><!-- The button that pulls out the form -->
<input type="button" class="wp-report-post-link" value="Report bad post" />
<!-- The form itself will be inserted here -->
<div class="wp-report-post-body"></div></textarea>
                        </fieldset>
                    </td>
                </tr>
                <!-- Placement -->
                <tr>
                    <th scope="row">Show for</th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span>Show for</span></legend>
                            <label><input type="radio" name="types" value="0"<?php if ($types==0) echo ' checked="checked"'; ?> /> <span>Both Posts and Pages</span></label><br />
                            <label><input type="radio" name="types" value="1"<?php if ($types==1) echo ' checked="checked"'; ?> /> <span>Posts</span></label><br />
                            <label><input type="radio" name="types" value="2"<?php if ($types==2) echo ' checked="checked"'; ?> /> <span>Pages</span></label><br />
                        </fieldset>
                    </td>
                </tr>
                <!-- Access -->
                <tr>
                    <th scope="row">Who can report</th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span>Who can report</span></legend>
                            <label><input type="radio" name="access" value="0"<?php if ($access==0) echo ' checked="checked"'; ?> /> <span>Anyone</span></label><br />
                            <label><input type="radio" name="access" value="1"<?php if ($access==1) echo ' checked="checked"'; ?> /> <span>Only logged in users</span></label><br />
                        </fieldset>
                    </td>
                </tr>
                <!-- Notification Email -->
                <tr valign="top">
                    <th scope="row"><label for="notify_email">Notification Email</label></th>
                    <td><input name="notify_email" type="text" id="notify_email" value="<?php echo $notify_email; ?>" class="regular-text" /></td>
                </tr>

                <tr>
                    <th scope="row" colspan="2"><p>The following settings are valid only for Automatic mode:</p></th>
                </tr>
                <!-- Report link text -->
                <tr valign="top">
                    <th scope="row"><label for="linktext">Report link text</label></th>
                    <td><input name="linktext" type="text" id="linktext" value="<?php echo $linktext; ?>" class="regular-text" /></td>
                </tr>
                <!-- Display icon -->
                <tr valign="top">
                    <th scope="row">Show Icon</th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span>Show Icon</span></legend>
                            <label for="icon"><input name="icon" type="checkbox" id="icon" value="1"<?php if ($icon==1) echo ' checked="checked"'; ?> /> Show icon prior to the link</label>
                        </fieldset>
                    </td>
                </tr>
                <!-- Customize Look & Feel -->
                <tr valign="top">
                    <th scope="row"><label>Customize the Look &amp; Feel</label></th>
                    <td>
                        <a href="<?php echo $edit_url; ?>?file=wp-report-post%2Fwp-report-post-form-template.php&plugin=wp-report-post%2Fwp-report-post.php" class="button" target="_blank">Edit Form template</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo $edit_url; ?>?file=wp-report-post%2Fwp-report-post.css&plugin=wp-report-post%2Fwp-report-post-form-template.php" class="button" target="_blank">Edit Stylesheet</a></td>
                </tr>
                <tr>
                    <th scope="row">&nbsp;</th>
                    <td><p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes" /></p></td>
                </tr>
            </tbody>
        </table>
    </form>
</div>