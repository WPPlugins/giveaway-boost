=== Giveaway Boost ===
Contributors:      giveawayboost
Requires at least: 4.7
Tested up to:      4.8
Stable tag:        1.0.7
License:           GPLv3
License URI:       http://www.gnu.org/licenses/gpl-3.0.html
Tags:              admin, content types

Giveaway Boost provides a simple way to run a giveaway from your WordPress powered website.

== Description ==

Giveaway Boost allows your audience to enter to win physical products, digital products, or anything else! Get set up in *under five minutes* and start running your first giveaway today. After a visitor enters your giveaway, they receive a special referrer link that they can use to receive more entries for your giveaway.

[Upgrade to Giveaway Boost Pro to unlock more features to create better looking page designs and automatically add giveaway entrants to your email list.](http://go.giveawayboost.com/get-giveawayboost?utm_source=wordpressorg&utm_medium=link&utm_campaign=giveawayboostwporgtop)

= Features =

* Up and running in **less than five minutes**
* Set the number of winners for each giveaway and specify whether it should display
* Set the prize value for each giveaway and specify whether it should display
* Customize the number of entries an individual receives upon successful referral
* Select the end date and time for each giveaway you run
* Optionally use reCAPTCHA to reduce spam entries
* Completely customize your giveaway title and messaging
* Choose from four pre configured color themes or completely customize the colors to your liking
* Quickly and easily select the number of winners for your giveaway with one button press
* Export the names and emails of all giveaway participants as a CSV

= Giveaway Boost Pro Features Improve the Plugin =


* Automatically add giveaway participants to your email service provider - Aweber, MailChimp and ConvertKit support
* Two methods for selecting winners (weighted random choice or most entries win)
* Tracking code support to put your Facebook conversion pixel or other code to track the effectiveness of your giveaway campaigns
* Total of 3 layouts (up from 1 layout) to better customize your giveaway page design
* Background image support to create a better looking giveaway page designs
* Bonus: Includes over 60+ professionally created background image designs for you to use (or upload your own)
* You can also contact our team for plugin support via email

[Upgrade to Giveaway Boost Pro here!](http://go.giveawayboost.com/get-giveawayboost?utm_source=wordpressorg&utm_medium=link&utm_campaign=giveawayboostwporgbot)

== Installation ==

1. Install Giveaway Boost through the WordPress plugin installer (optionally upload it via FTP)
1. Activate the plugin through the "Plugins" menu in WordPress
1. Go to "Giveaway > Settings" to set up your site-wide Giveaway settings
1. Create a new Giveaway using "Giveaway > Add New"
1. If your host has page caching enabled for non-logged in users, ask them to add an exclusion for your Giveaway urls (by default `/giveaway/*/`)

== Frequently Asked Questions ==

= What version of PHP is required? =

Giveaway Boost requires at least PHP 5.4 in order to successfuly run.

= Why doesn't the giveaway page change after users enter? =

Your host is likely caching the Giveaway pages - ask them to add an exclusion for your Giveaway urls (by default `/giveaway/*/`).

== Screenshots ==

1. The "Giveaways > Settings" page allows you to specify sitewide defaults, giveaway urls, and giveaway text
2. The "Giveaways" page shows all created Giveaways, with the number of entries and the date and time at which it ends
3. When creating a Giveaway, specify the number of winners, prize value, entries per referral, and when the giveaway ends
4. You can also choose whether or not Google reCAPTCHA verification is required as well as giveaway messaging given various conditions
5. Design your Giveaway page by selecting one of four pre-configured themes or customizing to your liking
6. View all entries to your giveaway at any time
7. When your contest is over, choose winners automatically
8. Your giveaway goes live as soon as you publish
9. After entry, your participants get a custom share interface with a unique referral link

== Changelog ==

= 1.0.7 =
* After entry, redirect to the giveaway url with the entry token as a query argument (cache circumvention technique)

= 1.0.6 =
* Removed IP address reliance for finding an existing entry for a user - only use cookies by default, or the email address that a user enters

= 1.0.5 =
* Added export entries button to top of the entries table
* Added select winners button to top of the entries table
* After winners have been selected, they appear at the top of the entries table and entries export file

= 1.0.4 =
* Fixed URL path for normalize css file

= 1.0.3 =
* Fixed bug regarding reloading templates bypassing the transient cache
* Improved transient clear for storage data
* Removed erroneous redeclaration of `wp_head` and `wp_footer` when not necessary

= 1.0.2 =
* Added green checkmark to indicate a successful photo upload
* Fixed default template to output ended message and images as appropriate
* Changed rendering to use default wp_head and wp_footer to allow to be hooked into
* Simplified scripting
* Added margin and padding definition for giveaway templates

= 1.0.1 =
* Fixed bug with rewrites not being appropriately set on activation

= 1.0.0 =
* Initial release
