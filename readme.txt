=== Orbisius Warning Suppressor ===
Contributors: lordspace,orbisius
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=7APYDVPBCSY9A
Tags: warning,warnings,notice,notices,debug,wp_debug,debugging,error_reporting,e_all,E_WARNING,E_NOTICE
Requires at least: 4.0
Tested up to: 4.8
Stable tag: 1.0.2
Requires PHP: 5.2.4
License: GPLv2 or later

Suppresses 
 warnings in php 7

== Description ==

Suppresses php 7 warnings that show up when a method has different parameters
than the same method in the parent class.

<strong>PHP Warning:  Declaration of ... should be compatible with ...</strong>

Those warnings are useless and fill up your file files.
This is because most of the time you don't control over the 
plugin or theme's code that run on your site.

The plugin only blocks php's E_WARNING and if it contains the incompatible 
declaration warning (in English). Thefore, if the php locale is set to another language
this plugin may not work. If that's the case contact us to let us know how that warning
translates into your language.


= Features =

* Super easy to use just install, activate and forget.

= Usage =
Just add the plugin and activate it.

= Demo =

n/a

= Support =
* Support is handled on our site: <a href="http://orbisius.com/support/" target="_blank" title="[new window]">http://orbisius.com/support/</a>
* Please do NOT use the WordPress forums or other places to seek support.

= Author =

Do you need an amazing plugin created especially for your needs? Contact me.
Svetoslav Marinov (Slavi) | <a href="http://orbisius.com" title="Custom Web Programming, Web Design, e-commerce, e-store, Wordpress Plugin Development, Facebook and Mobile App Development in Niagara Falls, St. Catharines, Ontario, Canada" target="_blank">Custom Web and Mobile Programming by Orbisius.com</a>

== Upgrade Notice ==
n/a

== Screenshots ==
1. WP-CLI output filled with warnings when the plugin is not active
2. WP-CLI output no warnings

== Installation ==

1. Upload the zip package within WP Admin > Plugins > Add
2. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= Why is the plugin name that weird? =
The idea is the plugin to be loaded first so it can install the error handler.

== Changelog ==

= 1.0.2 =
* Added a filter and plugin's settings link may not be shown

= 1.0.1 =
* Fixed some comments in the code.
* Tested with latest WP

= 1.0.0 =
* Initial release
