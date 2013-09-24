<?php

/**
 * @author Alex Raven
 * @company ESITEQ
 * @website http://www.esiteq.com/
 * @email bugrov at gmail.com
 * @created 23.9.2013
 * @version 0.1
 */

require_once realpath(dirname(__FILE__)). "/../../../wp-load.php";
$current_user = wp_get_current_user();
if (!in_array("administrator", $current_user->roles))
{
    die("Access denied");
}

$json = array();
$sql = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}reported_posts WHERE `id`=%d LIMIT 1", $_GET['report_id']);
$report = $wpdb->get_row($sql, ARRAY_A);
$post_id = $report['post_id'];
$sql = $wpdb->prepare("UPDATE {$wpdb->prefix}reported_posts SET `status`=%s WHERE `id`=%d LIMIT 1", $_GET['status'], $_GET['report_id']);
if ($_GET['status']=="unpublished")
{
    $wpdb->query($wpdb->prepare("UPDATE {$wpdb->prefix}posts SET `post_status`=%s WHERE `ID`=%d", "pending", $post_id));
}
$json['success'] = true;
$wpdb->query($sql);
echo json_encode($json);
?>