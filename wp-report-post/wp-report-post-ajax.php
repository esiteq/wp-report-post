<?php

/**
 * @author Alex Raven
 * @company ESITEQ
 * @website http://www.esiteq.com/
 * @email bugrov at gmail.com
 * @created 22.9.2013
 * @version 1.0
 */

require_once realpath(dirname(__FILE__)). "/../../../wp-load.php";

$json = array();
$json['error'] = false;
$json['success'] = false;
$json['errors'] = array();

$name = $_GET['wp_report_post_name'];
$email = $_GET['wp_report_post_email'];
$message = $_GET['wp_report_post_message'];
$post_id = intval($_GET['wp_report_post_id']);
$user_id = intval($_GET['wp_report_post_user_id']);

if (strlen($name) == 0)
{
    $json['errors']['wp_report_post_name'] = true;
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL))
{
    $json['errors']['wp_report_post_email'] = true;    
}
if (strlen($message) < 10)
{
    $json['errors']['wp_report_post_message'] = true;
}
$json['error'] = count($json['errors'])>0;

if (!$json['error'])
{
    $sql = $wpdb->prepare("INSERT INTO {$wpdb->prefix}reported_posts SET `user_id`=%d, `user_name`=%s, `user_email`=%s, `message`=%s, `post_id`=%d", $user_id, $name, $email, $message, $post_id);
    $wpdb->query($sql);
    if ($wpdb->last_error == 0)
    {
        if ($wpdb->insert_id == 0)
        {
            $json['already_reported'] = true;
        }
        else
        {
            $json['success'] = true;
        }
    }
    $json['sql'] = $sql;
}

echo json_encode($json);

?>