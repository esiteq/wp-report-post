<?php

/**
 * 
 * Plugin Name: WP Report Post
 * Plugin URI: http://www.esiteq.com/projects/wordpress-report-post-plugin/
 * Description: Adds functionality to report inappropriate post or page
 * Author: Alex Raven
 * Version: 1.0
 * Author URI: http://www.esiteq.com/
 * 
 */

require_once realpath(dirname(__FILE__)). "/wp-report-post-form-template.php";

function wp_report_post_render_form()
{
    $icon = get_option("wp_report_post_icon", 1);
    $linktext = get_option("wp_report_post_linktext", "");
    $placement = get_option("wp_report_post_placement", 0);
    switch ($placement)
    {
        case 0: $entry = "div.entry-meta"; break;
        case 1: $entry = "div.entry-content"; break;
        default: $entry = "div.wp-report-post-body";
    }
?>
<script type="text/javascript">
 jQuery(document).ready(function($)
 {
 <?php
    if ($placement!=2)
    {
 ?>
    $("<?php echo $entry; ?>").append('<span><a href="#" post-id="<?php the_ID(); ?>" class="wp-report-post-link"><?php if ($icon) { ?><i class="wp-report-post-sign"></i><?php } ?><?php _e($linktext); ?></span></a>');
<?php
    }
?>
    $("<?php echo $entry; ?>").append('<?php wp_report_post_form_template(get_the_ID()); ?>');
    $("#wp-report-post-cancel, #wp-report-post-dismiss").click(function(e)
    {
        var $box = $(".wp-report-post-box");
        $box.slideUp(600);
        e.preventDefault();
    });
    $("#wp-report-post-submit").click(function(e)
    {
        $("#wp-report-post-form input, #wp-report-post-form textarea").removeClass("wp-report-post-error");
        $(".wp-report-post-msg").css("display", "none");
        $.ajax(
        {
            url: "<?php echo plugins_url("wp-report-post-ajax.php", __FILE__); ?>",
            type: "GET",
            data: $("#wp-report-post-form").serialize(),
            dataType: "json"
        }).done(function(data)
        {
            if (data.error)
            {
                $.each(data.errors, function(e)
                {
                    $("#"+e).addClass("wp-report-post-error");
                });
            }
            if (data.success)
            {
                $("#wp-report-post-form").slideUp(600, function()
                {
                    $(".wp-report-post-sent").slideDown(600);    
                });
            }
            if (data.already_reported)
            {
                $(".wp-report-post-msg").css("display", "block");
            }
            console.log(data);
        });
    });
    $(".wp-report-post-link").click(function(e)
    {
        $("#wp-report-post-form input, #wp-report-post-form textarea").removeClass("wp-report-post-error");
        $(".wp-report-post-msg").css("display", "none");
        var post_id = $(this).attr("post-id");
        var $box = $(".wp-report-post-box");
        $box.slideDown(600);
        e.preventDefault();
    });
 });
</script>
<?php
}

function wp_report_post_content($content)
{
    $types = get_option("wp_report_post_types", 0);
    if ($types == 1 && !is_single())
    {
        return $content;
    }
    if ($types == 2 && !is_page())
    {
        return $content;
    }
    if ($types == 0 && !is_singular())
    {
        return $content;
    }
    add_action("wp_footer", "wp_report_post_render_form");
    wp_enqueue_script("wp-report-post-javascript", plugins_url("wp-report-post.js" , __FILE__ ), array("jquery"));
    return $content;
}

function wp_report_post_admin_menu()
{
    add_menu_page("Reported Posts", "Reported Posts", "manage_options", "wp-report-post/wp-report-post-admin.php", "", plugins_url("wp-report-post/img/icon_warning.gif"));
    add_submenu_page("wp-report-post/wp-report-post-admin.php", "Report Post Settings", "Settings", "manage_options", "wp-report-post/wp-report-post-admin-settings.php");
}

function wp_report_post_register_options()
{
    add_option("wp_report_post_placement", 0);
    add_option("wp_report_post_access", 0);
    add_option("wp_report_post_linktext", "Report inappropriate post");
    add_option("wp_report_post_icon", 1);
    add_option("wp_report_post_types", 0);
}

function wp_report_post_activate()
{
    global $wpdb;
    $sql = "CREATE TABLE IF NOT EXISTS `wp_reported_posts` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(12) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `post_id` int(12) NOT NULL,
  `status` enum('new','confirmed','deleted','edited','unpublished') NOT NULL DEFAULT 'new',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_email` (`user_email`,`post_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;";
    $wpdb->query($sql);
}

add_filter("the_content", "wp_report_post_content");
wp_register_style("wp-report-post-css", plugins_url("wp-report-post.css", __FILE__));
wp_enqueue_style("wp-report-post-css");
if (is_admin())
{
    add_action("admin_menu", "wp_report_post_admin_menu");
    add_action("admin_init", "wp_report_post_register_options");
    register_activation_hook(__FILE__, "wp_report_post_activate");
}

?>