=== Simple post listing ===

Contributors: sgcoskey
Donate link: http://boolesrings.org
Tags: posts, list
Requires at least: 3.0
Tested up to: 3.3.2
Stable tag: 0.2

Use the [postlist] shortcode to show a list of posts.

== Description ==

This is another simple plugin to show a list of posts from your blog.
Use the `[postlist]` shortcode on any post or page.

The shortcode supports several options:

* **category**: If defined, show posts only from this category.
Specify the category using its slug identifier.  If you provide
multiple comma-seperated category slugs then they will all be
included.

* **tag**: If defined, show posts only from this tag.  Specify the tag
using its slug identifier.  If you provide multiple comma-seperated
tag slugs then they will all be included.

* **style**: One of *list* (default) or *post*.  If it
is *list*, then the list style is indented and bulleted.  If it is *post* 
then the title is promoted to `<h2 class="upcoming-entry-title">` and
the list style is plain.

* **text**: One of *none* (default), *excerpt*, *excerpt-formatted*,
or *normal*.  If it is *excerpt*, then the post excerpt is shown, similar
to search results.  If it is *normal* then the full post (up to
the `[more]` tag) is shown.

* **more_text**: Specify the text to append onto truncated excerpts.
Defaults to ` ...`.

* **null_text**: If no results are returned, shows this text.
Defaults to `(none)`.

* **class_name**: If defined, adds this class name to the generated `<ul>`
element.  Useful for custom styling.

* **show_date**: If defined, the post date will precede the post title.

* **date_format**: If showing the date, this php date format will be
used.  The default is the Date Format value from the General Settings
page.  I recommend `"F j, Y"`, which displays as "May 12, 2012".

* **q**: Arbitrary &-separated arguments to add to the query.  See the
[WP_Query](http://codex.wordpress.org/Class_Reference/WP_Query/#Parameters)
page for available syntax.  For example, to show only three posts and
you want to show them in ascending instead of descending order, you would
write `[postlist q="posts_per_page=3&order=ASC"]`.

The output can then be further formatted using CSS.  We recommend the
plugin [Improved Simpler
CSS](http://wordpress.org/extend/plugins/imporved-simpler-css/) for
quickly styling your post list (and your site)!

This plugin can also be easily made into a widget by placing the shortcode
into a text widget, and activating the [Shortcodes in
sidebar](http://wordpress.org/extend/plugins/shortcodes-in-sidebar/)
plugin.

Report bugs, give feedback, or fork this plugin on
[GitHub](http://github.com/scoskey/Simple-post-listing-wordpress-plugin).

== Installation ==

Nothing unusual here!

== Changelog ==

`0.2` Added the **more_text* option, and improved the *excerpt*
display.

`0.1` Changed the **category_name** option name to just **category**.
Please update your site accordingly!  The old option name will be
supported for a few more months.

Added the **tag**, **show_date** and **date_format* options.

If you choose `text=excerpt` and a post has its excerpt field set, then any shortcodes in the excerpt will be evaluated.

`0.0` initial release