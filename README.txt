=== Plugin Name ===
Contributors: mkronenfeld
Donate link: https://wp-styles.de
Tags: team plugin wordpress, team member wordpress plugin, team, team members, members profiles, staff, staff directory, staff members, employees, our team, meet the team
Requires at least: 4.7
Tested up to: 4.7.2
Stable tag: 0.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Manage your contact details and team members from your WordPress Backend.

== Description ==

Socializing is an important part of building good relationships. Let your visitors know how they can reach you best.

Business:

* Name
* Images
* Short description
* Phone / Mobile
* E-Mail
* Website
* Address

Team Member:

* Name
* Position
* Images
* Biographical information
* Phone / Mobile
* E-Mail
* Website
* Address

= How to use: Business Shortcode =

You can insert information about for Business with a shortcode into a post or page.
`[wpbe_business id="123"]`

= How to use: Teams =

You can insert information about your Team Members (or Groups) with a Shortcode into a post or page.
`[wpbe_team id="123"]`

**Columns**

Display your team in up to six columns.
`[wpbe_team id="123" columns="3"]`

**Thumbnail Sizes**

Change the Thumbnail Sizes with the size attribute.
`[wpbe_team id="123" size="medium"]`

The shortcode supports the thumbnail sizes *thumbnail*, *medium* (default), *large*, *full* and also custom sizes.

**Example Shortcode**

Team #123, four columns, medium image size
`[wpbe_team id="123" colums="4" size="medium"]`

== Installation ==

1. Upload 'wp-business-essentials' to the '/wp-content/plugins/' directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.


== Frequently Asked Questions ==

= Is the edit link beneath the Team / Business boxes visible for visitors? =

No, you have to be at least an editor to see the edit link.

== Screenshots ==

None.

== Upgrade Notice ==

None.

== Changelog ==

= 0.3 =

* New Widget: Business Address (wpbe_business)

= 0.2 =

* New Custom Post Type: Business (wpbe_business)
* New Shortcode: wpbe_business
* Microdata: schema.org terms for Team Members and Businesses

= 0.1 =
Initial release on WordPress.org. Key new features:

* New Custom Post Type: Team Members (wpbe_team_members)
* New Custom Taxonomy: Team (wpbe_team)
* New Shortcode: wpbe_team
