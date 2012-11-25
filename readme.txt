=== Skip Identical Revisions ===
Contributors: johnfakorede
Tags: revisions
Requires at least: 2.6.0
Tested up to: 3.4.2
Stable tag: 1.1

Disables saving a post revision if the title, content and excerpt fields are all unmodified.

== Description ==

Disables saving a post revision if the title, content and excerpt fields are all unmodified. This helps prevent database bloat and needless overwriting of important revisions.

No configuration needed, no UI and there are no plugin options to bother with. It can also be installed as a must-use plugin (`mu-plugins` directory).

= Known Issue =
Works best in HTML editor mode or, if in visual editor mode, new content is created from scratch in WordPress. When copying and pasting external content with extensive and poorly-indented HTML markup, underlying TinyMCE formatting can be uneven, so revisions could be saved even when content has not been modified.

= To-dos =
* Add revision-related message to save notification.
* Workaround for visual editor auto-formatting when saving poorly indented, heavily marked-up content.

== Installation ==

1. Download the zip file and upload via FTP or browser:
	* FTP: Unzip/extract and upload the 'skip-identical-revisions' folder to your plugin directory (default: `wp-content/plugins/`).
	* Browser: Upload the zip file via WordPress admin (`Add New > Upload`).
1. Activate the plugin in WordPress admin.
1. Done.

OR: In WordPress admin go to `Plugins > Add New`, search by plugin name, install and activate.

== Changelog ==

= 1.1 - November 24, 2012 =
* Tested up to 3.4.2
* Updated README

= 1.0 - November 9, 2011 =
* Original version
