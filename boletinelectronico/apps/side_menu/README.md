🤙 Nextcloud app / Custom menu 🎨
===============================

Allows you to modify the position of the main menu by creating a panel on the left of the interface or with a big menu on the top.
You can also add and sort custom categories, define apps that must be displayed in the top menu, etc. Fully customisable.

This application is rather suitable for instances that activate a lot of applications.

You can customize colors depending of the theme (Dark theme and Breeze Dark). Comptatible with AppOrder.

* [Installation and upgrade](#installation-and-upgrade)
* [How to contribute?](#how-to-contribute)
* [Support](#support)
* [Screenshots](https://gitnet.fr/deblan/side_menu/src/branch/master/screenshots/)

You like this app and you want to support me? ☕ [Buy me a coffee](https://www.buymeacoffee.com/deblan) or [Donate with liberapay](https://liberapay.com/deblan)

[![Build Status](https://ci.gitnet.fr/api/badges/deblan/side_menu/status.svg)](https://ci.gitnet.fr/deblan/side_menu)

Requirements
------------

* PHP >= 7.4
* App `theming` enabled

Installation and upgrade
------------------------

Custom menu is available from the app store.

```
$ cd /path/to/nextcloud
$ php occ app:install side_menu
```

If you want to install it from source, go to https://gitnet.fr/deblan/side_menu/releases and copy the link to the last release (side_menu_vX.Y.Z.tar.gz). Then:

```
$ cd /path/to/nextcloud/apps
$ curl -sS https://gitnet.fr/attachments/xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx | tar xvfz -
```

Administrators can edit many settings using the administration page.

Users can disable the menu using the page of personal settings.

Use the shortcut `Ctrl`+`o` to open and to hide the side menu. Use `tab` to navigate.

How to contribute?
------------------

You can report a bug or request a feature by opening an issue: https://gitnet.fr/deblan/side_menu/issues

If you are a developer:

* fork the repository
* install an instance of Nextcloud
* go to `apps/` and clone your repository
* go to `apps/side_menu` and run `npm install`

Build javascripts using `make npm-build` (or `make npm-watch` to build them in real time).

Then commit and create a pull request.

Support
-------

You can join the official room on Matrix: [#custommenu:neutralnetwork.org](https://matrix.to/#/#custommenu:neutralnetwork.org).
