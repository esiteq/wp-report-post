<?php

/**
 * @author Alex Raven
 * @company ESITEQ
 * @website http://www.esiteq.com/
 * @email bugrov at gmail.com
 * @created 22.9.2013
 * @version 0.2
 */

if (!defined("ABSPATH"))
{
    die("Access denied");
}
define("WP_POSTS_PER_PAGE", 30);
$this_url = get_admin_url(). "admin.php?page=". $_GET['page']; $date_format = get_option("date_format"); $time_format = get_option("time_format");
$p = isset($_GET['p']) ? intval($_GET['p']) : 1; $orderby = "orderby={$_GET[orderby]}&order={$_GET[order]}";

if ($_GET['action']=="delete")
{
    $wpdb->query($wpdb->prepare("DELETE FROM {$wpdb->prefix}reported_posts WHERE `id`=%d LIMIT 1", $_GET['report']));
}
?>
<style type="text/css">
.status-edited {
    background-color:#dff0d8;
}
.status-unpublished {
    background-color:#fcf8e3;
}
.status-new {
    background-color:#fcfcfc;
}
.status-deleted {
    background-color:#f2dede;
}
.column-status {
    text-transform: capitalize;
}
.status-unpublished .post-title {
    text-decoration:line-through;
}
</style>
<div class="wrap">
<div id="icon-edit" class="icon32 icon32-posts-post"><br /></div><h2><?php echo _e("Reported Posts"); ?></h2>

<form id="posts-filter" action="" method="get">

<!--
<p class="search-box">
	<label class="screen-reader-text" for="post-search-input">Search Posts:</label>
	<input type="search" id="post-search-input" name="s" value="">
	<input type="submit" name="" id="search-submit" class="button" value="Search Posts">
</p>
-->
<br />

<table class="wp-list-table widefat fixed posts" cellspacing="0">
	<thead>
	<tr>
		<th scope="col" id="cb" class="manage-column column-cb check-column" style=""><label class="screen-reader-text" for="cb-select-all-1">Select All</label><input id="cb-select-all-1" type="checkbox" /></th>
        <th scope="col" id="title" class="manage-column column-title sortable desc" style=""><a href="#?orderby=title&amp;order=asc"><span>Title</span><span class="sorting-indicator"></span></a></th>
        <th scope="col" id="author" class="manage-column column-author" style="">Reported by</th>
        <th scope="col" id="categories" class="manage-column column-categories" style="">Email</th>
        <th scope="col" id="tags" class="manage-column column-tags" style="">Reason</th>
        <th scope="col" id="date" class="manage-column column-date sortable asc" style=""><a href="#?orderby=date&amp;order=desc"><span>Report date</span><span class="sorting-indicator"></span></a></th>
        <th scope="col" id="status" class="manage-column column-date sortable asc" style=""><a href="#?orderby=date&amp;order=desc"><span>Status</span><span class="sorting-indicator"></span></a></th>
	</tr>
	</thead>

	<tbody id="the-list">
<?php
$start = ($p-1) * WP_POSTS_PER_PAGE;
$sql = $wpdb->prepare("SELECT COUNT(*) AS total FROM {$wpdb->prefix}reported_posts LEFT JOIN {$wpdb->prefix}posts ON {$wpdb->prefix}reported_posts.post_id={$wpdb->prefix}posts.ID ORDER BY `dt` DESC", 0);
$total = $wpdb->get_row($sql)->total;
$pages = ceil($total / WP_POSTS_PER_PAGE);
$sql = str_replace("COUNT(*) AS total", "*", $sql). " LIMIT {$start},". WP_POSTS_PER_PAGE;
$posts = $wpdb->get_results($sql);
if (count($posts) == 0)
{
?>
        <tr class="type-post format-standard hentry alternate iedit status-posted">
            <td colspan="7" class="post-title">No posts reported yet!</td>
        </tr>
<?php
}
foreach ($posts as $post)
{
    $the_id = $post->ID;
    $the_title = $post->post_title;
?>
        <tr id="rep-<?php echo $post->id; ?>" class="post-<?php echo $the_id; ?> type-post format-standard hentry category-uncategorized alternate iedit author-self status-<?php echo $post->status; ?>" valign="top">
            <th scope="row" class="check-column">
                <label class="screen-reader-text" for="cb-select-<?php echo $the_id; ?>"><?php echo $the_title; ?></label>
				<input id="cb-select-<?php echo $the_id; ?>" type="checkbox" name="post[]" value="<?php echo $the_id; ?>" />
				<div class="locked-indicator"></div>
            </th>
			<td class="post-title page-title column-title"><strong><a class="row-title" target="_blank" href="<?php echo $post->guid; ?>" title="View Post"><?php echo $post->post_title; ?></a></strong>
            <div class="row-actions">
                <a class="the-post-link" status="edited" href="<?php echo get_admin_url(); ?>post.php?post=<?php echo $the_id; ?>&action=edit" report-id="<?php echo $post->id; ?>" target="_blank">Edit Post</a> | <a class="the-post-link" status="unpublished" report-id="<?php echo $post->id; ?>" href="<?php echo "{$this_url}&{$orderby}&p={$p}&post={$post->ID}&action=unpublish"; ?>">Unpublish Post</a> | <a href="<?php echo "{$this_url}&{$orderby}&p={$p}&report={$post->id}&action=delete"; ?>">Delete Report</a> | <a href="#" class="the-post-link" status="new" report-id="<?php echo $post->id; ?>">Change Status to New</a>
            </div>
            </td>
            <td class="author column-author"><a href="<?php echo get_admin_url(); ?>user-edit.php?user_id=<?php echo $post->user_id; ?>" target="_blank"><?php echo $post->user_name; ?></a></td>
			<td class="categories column-categories"><a href="mailto:<?php echo $post->user_email; ?>" target="_blank"><?php echo $post->user_email; ?></a></td>
            <td class="tags column-tags"><?php echo $post->message; ?></td>
			<td class="date column-date"><abbr><?php echo $post->dt; ?></abbr></td>
			<td class="column-status"><?php echo $post->status; ?></td>
        </tr>
<?php
}
if ($p>1) { $prev = $p-1; } else { $prev = 1; }
if ($p<$pages) { $next = $p+1; } else { $next = $pages; }
?>
    </tbody>
</table>

<div class="tablenav bottom">
    <div class="tablenav-pages">
        <span class="displaying-num"><?php echo $total; ?> items</span>
        <span class="pagination-links">
            <a class="first-page disabled" title="Go to the first page" href="<?php echo "{$this_url}&{$orderby}&p=1"; ?>">&laquo;</a>
            <a class="prev-page disabled" title="Go to the previous page" href="<?php echo "{$this_url}&{$orderby}&p={$prev}"; ?>">&lsaquo;</a>
            <span class="paging-input"><?php echo $p; ?> of <span class="total-pages"><?php echo $pages; ?></span></span>
            <a class="next-page disabled" title="Go to the next page" href="<?php echo "{$this_url}&{$orderby}&p={$next}"; ?>">&rsaquo;</a>
            <a class="last-page disabled" title="Go to the last page" href="<?php echo "{$this_url}&{$orderby}&p={$pages}"; ?>">&raquo;</a></span>
    </div>
    <br class="clear" />
</div>

</form>

<div id="ajax-response"></div>
<br class="clear" />
</div>
<script type="text/javascript">
jQuery(document).ready(function($)
{
    $(".change-status").on("change", function(e)
    {
        var id = $(this).attr("report-id");
        var val = $(this).val();
    });
    $(".the-post-link").click(function(e)
    {
        var status = $(this).attr("status");
        var report_id = $(this).attr("report-id");
        $("#rep-"+report_id).removeClass("status-new");
        $("#rep-"+report_id).removeClass("status-unpublished");
        $("#rep-"+report_id).removeClass("status-edited");
        $("#rep-"+report_id).addClass("status-"+status);
        $.post( "<?php echo admin_url( "admin-ajax.php" ); ?>", { status: status, report_id: report_id, action: "wp_report_post_admin_ajax" }, function(data)
        {
            // done
        }, "json" );
        if (status!="edited")
        {
            e.preventDefault();
        }        
    });
});
</script>