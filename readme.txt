=== Skip Identical Revisions ===
Contributors: johnfakorede
Tags: revisions
Requires at least: 2.6.0
Tested up to: 3.2.1
Stable tag: trunk

Disables saving a post revision if the title, content and excerpt fields are all unmodified.

== Description ==

Disables saving a post revision if the title, content and excerpt fields are all unmodified. No configuration needed, no UI and there are no plugin options to bother with.

The plugin also works in the `mu-plugins` directory.

= Known Issue =
Works best in HTML editor mode or, if in visual editor mode, new content is created from scratch in WordPress. When copying and pasting external content with extensive and poorly-indented HTML markup, underlying TinyMCE formatting can be uneven, so revisions could be saved even when content has not been modified.

= To-dos =
* Add revision-related message to save notification.
* Workaround for visual editor auto-formatting when saving poorly indented, fully marked-up content.

== Installation ==

1. Download the zip file and extract the contents.
1. Upload the 'skip-identical-revisions' folder to your plugin directory (default: `wp-content/plugins/`).
1. Activate the plugin in WordPress admin.
1. Done.

OR: In WordPress admin go to `Plugins > Add New` and search by plugin name.

== Changelog ==

= 1.0 - November 9, 2011 =
* Original version