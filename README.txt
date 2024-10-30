=== WP Meeteo ===
Contributors: bkesh
Tags: webinars, online meeting, event booking, scheduling platforms
Requires at least: 4.4.2
Tested up to: 5.6
Stable tag: 1.1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

WP Meeteo displays a listing of upcoming webinars and available services from Meeteo app. Use a shortcode or widget to display required information.

== Description ==

[Meeteo](https://meeteo.io) provides one stop solution for you to handle your online and physical bookings, manage events, plan and conduct webinars and manage your finances.

This plugin helps you to have a brief glance of webinars and services that you have created in [Meeteo web application](https://meeteo.io) in your wordpress dashboard. 

You can showcase the list of upcoming webinars and available services in website for your targetted audience.

Make a good use of shortcodes to display webinars or services in the web page.

You must register to [Meeteo web application](https://meeteo.io) and get application ID in order to user the plugin.


== Installation ==

1. Upload the unzipped folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Go to the settings page under "Meeteo" menu.
4. Enter your APP ID.

== Frequently Asked Questions ==

= How do I get started? =

You need to have account in Meeteo. If you do not have one, create new account and start for free at [Meeteo](https://meeteo.io/pricing). Enter your APP ID in the meeteo settings page. 

= Where can I find my Application ID? =
Login to your Meeto account and navigate to the company profile page. You can find Application ID in this page.

= How to use webinar shortcodes? =
* For showing webinar detail by id. [meeteo_webinar webinar_id=ID_of_the_webinar]. You must provide webinar_id.
* For showing upcoming webinars. [meeteo_upcoming_webinars max=No_of_webinars_to_display]. "max" Parameter is optional. Default value is 5
* For showing services. [meeteo_services max=No_of_services_to_display]. "max" Parameter is optional. Default value is 5
* For Embedding meeteo widget to website. [meeteo_embed type=embed_type url="meeteo_url"]
Available Embed type options:
inline - Loads your Meeteo page directly in your website in an iframe.
You can set width and height of iframe using options "iframe_width" and "iframe_height".
Eg: [meeteo_embed type=embed_type url="meeteo_url" iframe_width=100% iframe_height=600px]
inline_link - Add link on site to launch Meeteo. Opens widget link in new window.
popup_text - Add link on site to launch Meeteo. Opens widget on popup.




= How does this plugin work? =

The plugin fetches the data from meeteo application based on provided application ID and displays in your wordpress dashboard and frontend.


= Can I create/update the webinars/services from wordpress dashboard ? =

Currently, the feature is not available in plugin.


== Screenshots ==
2. Upcoming Webinar Listings.
3. Services Listing.
4. Frontend Display Page.
7. Settings Page.

== Changelog ==

= 1.0.0 - Feb 1st, 2021 =
* Initial Release

= 1.1.1 - Sep 22nd, 2022 =
* updated url for the js and css sources
