/* --------------------------------------------------------------------------
 * File        : config.js
 * Version     : 1.0
 * Author      : indonez
 * Author URI  : http://www.indonez.com
 *
 * Indonez Copyright 2019 All Rights Reserved.
 * -------------------------------------------------------------------------- 
 * javascript handle initialization
    1. Iniciopage uikit slideshow 
    2. Active Menu Jquery
    3. Dynamic Breadcrumb Jquery
 * -------------------------------------------------------------------------- */

(function ($) {

    "use strict";

    let themeApp = {
        //----------- 1. Iniciopage uikit slideshow -----------
        theme_InicioSlideshow: function () {
            let slideshow = UIkit.slideshow('.in-slideshow', {
                autoplay: true,
                autoplayInterval: 7000,
                animation: 'fade',
                minHeight: 300,
                maxHeight: 410
            });
        },
        //----------- 2. Active Menu Jquery -----------
        theme_activeMenu: function () {
            let activeClass = $('ul.uk-navbar-nav li a, ul.uk-nav-primary li a')
            activeClass.each(function (index, element) {
                let li = $(element).attr('href');
                let path = window.location.pathname.split("/").pop();
                if (path == '') {
                    path = 'index.php';
                }
                if (path == 'single.php') {
                    path = 'blog.php';
                }
                if (path == li) {
                    $(element).parents('li').addClass("uk-active");
                }
            });
        },
        //----------- 3. Dynamic Breadcrumb Jquery -----------
        theme_dynamicBreadcrumb: function () {
            let breadcrumb = $('.uk-breadcrumb');
            breadcrumb.breadcrumbsGenerator({
                sitemaps: '.uk-navbar-nav',
                index_type: 'index.php'
            });
        },
        // theme init
        theme_init: function () {
            themeApp.theme_InicioSlideshow();
            themeApp.theme_activeMenu();
            themeApp.theme_dynamicBreadcrumb();
        }
    }

    jQuery(document).ready(function ($) {
        themeApp.theme_init();
    });

})(jQuery);