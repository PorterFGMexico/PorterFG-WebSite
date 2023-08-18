## [Unreleased]

## 2.5.2
### Fixed
* add check if menu exists before adding event listeners (#210)

## 2.5.1
### Fixed
* fix icon render (#133)

## 2.5.0
### Changed
* upgrade dependencies
### Fixed
* remove duplicated code
* remove unused variables and packages
* replace repeated strings with variables
* add html attributes
* replace var with let
* replace v-html with v-text to prevent xss

## 2.4.3
### Fixed
* fix translations

## 2.4.2
### Fixed
* fix typo
### Changed
* change ci/cd

## 2.4.1
### Fixed
* fix user setting save

## 2.4.0
### Added
* remove focus on opener after click
* add button to set default colors
* add menu hover effect
* add translations
### Fixed
* fix deprecated app.php file
* fix menu with categories header
* fix minor issues
### Changed
* change saving progression
### Removed
* Nextcloud 19 is not supported anymore
* PHP 7.3 is not supported anymore

## 2.3.5
### Fixed
* fix white square (#99)

## 2.3.4
### Fixed
* fix blank line when settings are open (#96)

## 2.3.3
### Added
* hide the scrollbar when mouse is out (menu always displayed)
### Fixed
* fix SQL Exception InvalidFieldNameException (#93)

## 2.3.2
### Fixed
- fix hidden menu

## 2.3.1
### Fixed
- fix #88: does not work with default menu

## 2.3.0
### Added
- fix #82: add an option to keep visible an app in both menus
- fix #83: add custom categories
- add auto-reload when settings are saved

## 2.2.0
### Added
- fix #84: update icons
- fix #85: use Nextcloud colors by default

### Fixed
- fix categories order in large menu

## 2.1.0
### Added
- add compatibility with Nextcloud 23

## 2.0.1
### Fixed
- fix #78: Top menu is broken - invisible apps are shown
- fix #77: Update personal settings - HTTP error 412 (Precondition Failed)
- fix js error on the personal settings page (undefined sortable)

## 2.0.0
### Fixed
- fix #66: removing usage of setInterval
- fix #73: icon background
### Changed
- fix #67: replace jQuery with Vanilla JS
### Removed
- Nextcloud 18 is not supported anymore

## 1.28.0
### Added
- fix #63: add a new side menu with categories

## 1.27.2
### Fixed
- fix #62: hide app notification icon

## 1.27.1
### Fixed
- fix German translation render

## 1.27.0
### Added
- hide personal settings access when settings are forced by the administrator
### Fixed
- improve German translations

## 1.26.0
### Added
- add Czech translation

## 1.25.2
### Fixed
- fix CHANGELOG

## 1.25.1
### Added
- add PHP version as dependency
- add chinese translation
### Fixed
- fix CHANGELOG

## 1.25.0
### Added
- add compatibility with Nextcloud 22
- add CHANGELOG.md (fix #59)
- update app icon

## 1.24.0
### Added
- add option to define the background opacity (fix #53)
- add missing translations

## 1.23.1
### Fixed
- fix but wih dark mode opener option

## 1.23.0
### Added
- add support of dark Theme and Breeze Dark
- add support of Nextcloud 21

## 1.22.2
### Fixed
- fix regression: apps does not open in new tab (fix #55)

## 1.22.1
### Fixed
- fix regression: apps does not open in new tab

## 1.22.0
### Added
- Add option to sort categories (fix #53)
- Update admin UI

## 1.21.0
### Added
- [FEATURE] Logo in the menu links to main page of installation (#51)

## 1.20.1
### Fixed
- Fix translations

## 1.20.0
### Added
- [FEATURE] Ability to remove apps from the Big Menu (#49)

## 1.19.1
### Fixed
- fix #47: setting for list/grid view in files app flashes and dissapears

## 1.19.0
### Added
- add option: the menu is enabled by default for users (fix #46)

## 1.18.0
### Added
- add option to show link to settings (fix #44)
- refactor menus using several components

## 1.17.0
### Added
- compliance with the app checker
- add an action to export the configuration
- add an action to purge the cache

## 1.16.3
### Fixed
- fix links that must be opened in new window (https://help.nextcloud.com/t/external-petit-probleme-concernant-lapplication-external-sites-ou-sites-externes/94884/11)

## 1.16.2
### Fixed
- fix issue with personal settings when global settings are forced

## 1.16.1
### Fixed
- fix #42: add cache to manage failures to access apps.nextcloud.com
- fix #41: side menu was hover apps list

## 1.16.0
### Added
- add an option to force settings to users (fix #38)

## 1.15.0
### Changed
- New name
### Fixed
- Fix #36: always displayed is not expanding

## 1.14.0
### Added
- add an api accessed by components
- add a config proxy in controllers
### Fixed
- fix translations

## 1.13.0
### Added
- add an option to display the avatar instead of the logo (fix #34)

## 1.12.3
### Added
- add a delay before moving elements (fix #33)

## 1.12.2
### Fixed
- fix #30: `Always displayed` menu can not be close using touchscreens

## 1.12.1
### Fixed
- fix typo
- fix translations

## 1.12.0
### Fixed
- fix #30: administrators and users can select what apps must be opened in new tab
- fix typo

## 1.11.0
### Added
- add the option for opening apps in new tab (fix #29)
### Fixed
- fix issue with the header of the always displayed menu

## 1.10.0
### Added
- add images to select the display of the menu
- add live preview
- update translations
- update app info

## 1.9.3
### Fixed
- fix regression with logo display

## 1.9.2
### Added
- add the option “always displayed” which fixes the position of the menu to the left and always displays the application icons (fix #21, fix #2)

## 1.8.6
### Added
- add translations: `fr` and `de`
- improve and publish the `Makefile`
- update documentation

## 1.8.5
### Fixed
- fix #28: menu items invisible after 1.8.4

## 1.8.4
### Fixed
- fix #27: disable side menu on public pages - broken in 1.8.3

## 1.8.3
### Fixed
- fix alphabetic order of apps (#26)

## 1.8.2
### Added
- add icon for closing the big menu (fix #25)
### Fixed
- fix hidden icons in the top menu (fix #23)
- fix missing apps (fix #24)

## 1.8.1
### Fixed
- fix issue with links
- fix missing l10n files

## 1.8.0
### Added
- add a `big menu` display (fix #22)
- add the possibility to choose what apps are displayed in the top menu (fix #22)
- add icon color filter
- add icon opacity filter

## 1.8.0-rc2

## 1.7.0
### Added
- add a loader when the page is unloading
- add compatibility with Nextcloud 19

## 1.6.3
### Fixed
- fix #20: add a shortcut to open and to hide the menu

## 1.6.2
### Fixed
- fix #19: add a cache to limit flashes

## 1.6.1
### Fixed
- fix #19: add a hack to show external sites in the top menu with navigation

## 1.6.0
### Added
- Add a page of personal settings
- Add an option to disable the side menu as user
- Refactoring of javascripts

## 1.5.0
### Added
- add option to force light icons instead of dark icons
### Fixed
- fix #19: add option to keep external sites in the top menu
- fix #16 #17: add dark icons and handle the svg filters

## 1.4.1
### Added
- Rendering  harmonization with browsers
### Fixed
- FIX #15: make menu start after icon

## 1.4.0
### Fixed
- Fix #12: add an option to hide the opener and the panel when there is no application

## 1.3.4
### Fixed
- FIX #14: add option to show only the opener
- FIX #13: add alternate hamburger icon
- FIX #11: remove error in the console

## 1.3.3
### Added
- Add a second background color to create a background gradiant
- Update documentation
### Fixed
- FIX #10: add options to select the size of the icons and the text, or hide them

## 1.3.2
### Fixed
- FIX #9: opener icon not visible with multiple apps_paths

## 1.3.1
### Fixed
- FIX #3: Add an opition the choose the position of the opener (after or before the logo)
- FIX #8: Remove extension of dynamic asset's routes (js, css)

## 1.3.0
### Added
- `main.js` is replaced by a controller and a template
### Fixed
-  FIX #2: add option to open the menu by hovering over opener

## 1.2.4
### Fixed
- FIX #7: Opener icon not visible in Safari

