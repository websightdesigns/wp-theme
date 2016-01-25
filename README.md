[![WebSight Designs](http://www.websightdesigns.com/img/logo.png)](http://www.websightdesigns.com)

# WordPress Theme

WordPress theme with Bootstrap 3 and a sticky footer page layout, meant as a starting point for common web projects.

## Requirements

This web application is intended to be cloned and placed on a web server running current versions of Apache, PHP and MySQL.

## Demo

[http://websightdesigns.com/wordpress/](http://websightdesigns.com/wordpress/)

## Install

To clone this project run the following command in the `/wp-content/themes/` directory:

    git clone https://github.com/websightdesigns/wp-theme.git

Or, to specify the destination directory:

    git clone https://github.com/websightdesigns/wp-theme.git ./destination

## This Theme Ready Base Includes

- Twitter Bootstrap 3.0.3
- jQuery Colorbox 1.5.14
- jQuery Mobile 1.4.5
- jQuery matchHeight 0.5.2
- Font Awesome 4.3.0
- Remote calls to html5shiv.js 3.7.0 and respond.js 1.4.2

## Features

- Displays a navigation menu with `wp_nav_menu()`
- Supports sub-page dropdown menus with [wp_bootstrap_navwalker()](https://github.com/twittem/wp-bootstrap-navwalker)
- Loads JS with `wp_enqueue_script()`
- Loads CSS with `wp_enqueue_style()`
- Sidebar widgets support
- Footer widgets support
- Bootstrap pagination
- Automatically uses unminified styles and scripts over local hosts

## Configuring

- To set up prefixes and the theme name you can replace all instances of `wp-theme`, `wp_theme` and `WordPress Theme` with your own prefix and theme name.

- In `wp-content/themes/wp-theme/header.php` you will want to set the correct values of the meta tags for author, contact, and copyright, and set the variable at the top of the page to set the keywords which appear on every page. Currently the author name is set to John Doe and the contact e-mail address is set to johndoe@domain.com. You will want to update these to correct values based upon your needs, or delete them entirely if you have no need for such meta information to be included in your project.

- In `wp-content/themes/wp-theme/header.php` you will also see the meta tag keywords `permanent,keywords,go,here` which you will want to edit to contain any keywords you wish to appear on every page. Any tags you add to the page or post will also show up as keywords.

- In `wp-content/themes/wp-theme/header.php` you should set the `$global_keywords` variable at the top of the page to set up keywords which appear on every page.

## Contributing

If you'd like to contribute to this project please feel free to submit a pull request.

## Our Website

For more information about webSIGHTdesigns, please visit [websightdesigns.com](http://websightdesigns.com/).
