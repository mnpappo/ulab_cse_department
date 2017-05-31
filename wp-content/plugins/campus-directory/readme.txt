=== WordPress Faculty Staff and Student Directory Plugin - Campus Directory ===
Contributors: emarket-design,safiye
Plugin URI: https://emdplugins.com
Author URI: https://emarketdesign.com
Donate link: https://emarketdesign.com/donate-emarket-design/
Requires at least: 4.5
Tested up to: 4.7.4
Stable tag: 1.1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Tags: faculty, faculty directory, staff directory, student, higher education

Campus Directory Higher Education Edition provides search and display capabilities for faculty, staff and student information

== Description ==

Campus Directory Higher Education edition offers extensive search capabilities for academic people supporting faculty, staff, graduate students and undergraduate students. A responsive search form is provided in addition to faculty, staff and student profile pages. Faculty profile pages includes support staff and advisee listings. Student pages may include advisor(s) links. Staff pages may include supported faculty listings.

<strong>Intro Video</strong>

[youtube https://www.youtube.com/watch?v=IitttAiuPwc]

[WordPress Faculty Staff and Student Directory Plugin - Campus Directory Plugin Documentation](https://docs.emdplugins.com/docs/campus-directory-community-documentation/)

<strong>Grid and stacked views for academic people</strong>

Faculty, staff and students can be displayed in grid or stacked view. The archive view can be modified to support single, two column or three column layouts. Although most academic information is supported, you can add custom fields in profiles and display them in the frontend and/or search form offering interesting possibilities.

To display 3 column archive view, add the following code - works in most cases - in your theme's style.css and adjust(height:400px) based on your data
<code>
.emd_person.type-emd_person{width:32.26%;display:inline-block;}
.emd_person.type-emd_person div.emd-person .panel-body{height:400px;}
div.emd-container .well-left,div.emd-container .well-left+div{width:100%}
div.emd-container .segment-block {text-align: center;}
</code>

To display 2 column archive view, add the following code in your theme's style.css and adjust(height:230px) based on your data
<code>
.emd_person.type-emd_person{width:49.2%;display:inline-block;}
.emd_person.type-emd_person div.emd-person .panel-body{height:230px;}
</code>


<strong>Customization through plugin settings<strong>

Campus Directory Higher Education edition is designed to minimize theme related conflicts and offers ability to set page template for profile, archive and taxonomy views without modifying your theme's template files through the plugin settings page. Profile, archive or taxonomy pages can be sidebar on left, right and full-width.

In addition, any field, taxonomy or relationship(support staff-supported faculty, advisor-advisee) can be enabled, disabled (removed from backend and frontend) or hidden from the frontend only from the plugin settings. Search form fields can be enabled or disabled selectively.

The plugin comes with EMD Widget area which can be used to put and display sidebar widgets on plugin's profile, archive and taxonomy pages. The location of the widget area can be adjusted in the plugin settings.

<strong>Security and Spam Protection</strong>

Extensive security features and spam protection are provided out-of-the-box. Emails fields are protected against harvesting. Search form is protected against many types of attacks. If your institution requires the search form access to logged in users only, the frontend login and/or registration forms can be enabled from plugin settings form tab asking users to login/register.

<strong>Easy to use</strong>

You can use the setup assistant to create search form and people grid pages automatically. To recreate missing pages, you can use the button on plugin settings tools tab.

<strong>Shortcodes<strong>

The following is not an exhaustive list:

* Display faculty in a responsive grid. Change faculty keyword to staff, graduate-student, undergraduate-student display others

[people_grid filter="attr::emd_person_type::is::faculty;"]

* Display faculty of an academic area.Change faculty keyword to staff, graduate-student, undergraduate-student display others.

[people_grid filter="attr::emd_person_type::is::faculty;tax::person_area::is::PUT-IN-TAXONOMY-SLUG-HERE;"]

* Display faculty researching on one to many academic topics. Please note that we're separating taxonomy slugs with comma.

[people_grid filter="tax::person_rareas::is::TAX-SLUG1,TAX-SLUG2,TAX-SLUG3;"]

* Display only certain post ids

[people_grid filter="misc::post_id::in::POSTID,POSTID2,POSTID3;"]

* Display advisee of a faculty

[people_grid filter="rel::supervisor::is::FACULTY-POSTID;"] 

* Display list of support staff for a faculty

[people_grid filter="rel::support_staff::is::FACULTY-POSTID;"]

<strong> Campus Directory Pro </strong>

Unified information repository for higher education organizations offering multi-dimensional academic catalog search and management. Campus Directory Pro integrates people, courses, locations and publications.

[WordPress Faculty Staff and Student Directory Plugin - Campus Directory Pro Plugin page](https://emdplugins.com/plugins/campus-directory-professional/)

[ WordPress Faculty Staff and Student Directory Plugin - Campus Directory Pro Demo Site](https://campusdirpro.emdplugins.com/)

= Extensions =
* [EMD CSV Import Export Extension](https://emdplugins.com/plugins/emd-csv-import-export-extension/) for bulk import/export from/to CSV files
* [EMD Advanced Filters and Columns Extension](https://emdplugins.com/plugins/emd-advanced-filters-and-columns-extension/) for finding faculty and staff information faster
* [EMD Active Directory/LDAP Extension](https://emdplugins.com/plugins/emd-active-directory-ldap-extension/) - Import/update all faculty staff and student fields including photos (jpegPhoto and thumbnailPhoto) from Active Directory, OpenLDAP and other LDAP. 

> This plugin's code was generated by [WP App Studio](https://wpappstudio.com) Professional WordPress Design and Development Platform based on the plugin's design. You can fully customize this plugin and others by modifying available designs at https://wpappstudio.com/designs/. You can design plugins using [WP App Studio](https://wpappstudio.com/quick-start/) plugin and sell them by [becoming a SellDev author](https://wpappstudio.com/become-a-selldev-author/) <br>

== Installation ==

The simplest way to install is to click on 'Plugins' then 'Add' and type 'Campus Directory' in the search field.

= Manual Installation Type 1 =

* Login to your website and go to the Plugins section of your admin panel.
* Click the Add New button.
* Under Install Plugins, click the Upload link.
* Select the plugin zip file from your computer then click the Install Now button.
* You should see a message stating that the plugin was installed successfully.
* Click the Activate Plugin link.

= Manual Installation Type 2 =

* You should have access to the server where WordPress is installed. If you don't, see your system administrator.
* Copy the plugin zip file up to your server and unzip it somewhere on the file system.
* Copy the "campus-directory" folder into the /wp-content/plugins directory of your WordPress installation.
* Login to your website and go to the Plugins section of your admin panel.
* Look for "Campus Directory" and click Activate.

== Screenshots ==

1. Faculty, staff and student profile pages
2. Contextually colored faculty, staff, undergraduate and graduate students archive and taxonomy pages
3. Academic people listing in the admin area
4. Extensive templating options are available without modifying theme files in the plugin settings
5. Ajax powered, responsive, customizable search form for faculty, staff and students
6. Search results view. After search query submission the search form fades away.
7. You can limit access to the search form by logged-in users only through plugin settings
8. Easy academic profile creation in the backend
9. [EMD CSV Import Export extension](https://emdplugins.com/plugins/emd-csv-import-export-extension/) provides bulk import/export/sync of academic profiles from CSV files
10. [EMD vCard extension](https://emdplugins.com/plugins/emd-vcard-extension/) allows downloading of academic profile in vCard format
11. Academic profile archives can be displayed in single, two and three column layouts. It shows single column for screen size less than 480px
12. People grid can be customized to display the academic profile segments
13. [Campus Directory Pro](https://emdplugins.com/plugins/campus-directory-professional/) -- Unified information repository for higher education organizations offering multi-dimensional academic catalog search and management -- Most advanced and comprehensive Campus Directory solution ever built for WordPress -- [Click for demo](https://campusdirpro.emdplugins.com/)
== Changelog ==
= 1.1.0 =
* NEW Added support for EMD Active Directory/LDAP extension
* FIXED WP Sessions security vulnerability
= 1.0.0 =
* Initial release
