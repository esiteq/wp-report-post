=== WP Report Post ===

Contributors: Alex Raven
Donate link: http://www.esiteq.com/projects/wordpress-report-post-plugin/ 
Tags: report, inappropriate content 
Requires at least: 2.8 
Tested up to: 3.8.1 
Stable tag: trunk
License: GPL v2

== Description ==

Report Post is a highly customizable plugin that lets your visitors to report posts or pages with inappropriate content. All these reports are displayed as a table in your Administrator section so you can decide what to do next: edit contents, unpublish posts/pages, or just delete these reports. The plugin was designed to work in both automatic and manual modes. In automatic mode, the link to report will be added to post's meta box. In manual mode, you can place the link, button or image anywhere you want in templates.

Features:

* Easy to use - you can simply activate the plugin and it will do the thing
* Highly customizable, including Form Template and CSS
* AJAX based - no page reload will occur
* Can be used in Automatic and Manual modes (to use in templates)
* i18n support
* Works for both Posts and Pages

Plugin demo: http://wp.esiteq.com/wordpress-report-post-plugin-demo/

== Installation ==

1. Upload `wp-report-post` and its contents to to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Reports and settings will appear under Reported posts menu in your Wordpress backend.

== Frequently Asked Questions ==

= I am using custom Wordpress theme and there is no Report link appears on single post/page. =
It happens because your theme uses non-standard layout. Report link is automatically attached after .entry-title + .entry-meta if displayed at top, or after .entry-content if displayed at bottom. If you don't have such markup, use Manual mode (see below).

= I want to use custom link / button / image to display Report form. =
You can place report link / form anywhere on the page. Example markup:

    <!-- The button that pulls out the form -->
    <input type="button" class="wp-report-post-link" value="Report bad post" />
    <!-- The form itself will be inserted here -->
    <div class="wp-report-post-body"></div>   

== Screenshots ==

To see screenshots, visit http://www.esiteq.com/projects/wordpress-report-post-plugin/

== Upgrade Notice ==

= 0.2.4 =
Some bugfixes

= 0.2 =
Numerous bug and security fixes

= 0.1 =
Initial release

== Changelog ==

= 0.2.4 =

Fixed bug with incorrect link to attached image

= 0.2.2 =

Fixed bug with duplicate reports

= 0.2.1 =

Removed engine and encoding from CREATE TABLE query - default values will be used (in case if InnoDB is not supported on your hosting)

= 0.2 =

* Perverted AJAX calls were replaced in a normal Wordpress way
* Added email notifications for reported posts
* Compatible with Wordpress 3.8.x and new themes
* Multiple minor bugfixes

= 0.1 =

* CSS buttons added
* Fixed textarea width