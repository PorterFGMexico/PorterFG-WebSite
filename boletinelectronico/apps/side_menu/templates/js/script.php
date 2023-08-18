<?php

$display = 'default';

if ($_['always-displayed']) {
    $display = 'always-displayed';
} elseif ($_['big-menu']) {
    $display = 'big-menu';
} elseif ($_['side-with-categories']) {
    $display = 'side-with-categories';
}

?>

(function() {
    const querySelector = function(selector, element) {
        if (element) {
            return element.querySelector(selector)
        }

        return document.querySelector(selector)
    }

    const querySelectorAll = function(selector, element) {
        if (element) {
            return element.querySelectorAll(selector)
        }

        return document.querySelectorAll(selector)
    }

    const createElement = function(tagName, attributes) {
        const element = document.createElement(tagName)

        if (typeof attributes === 'object') {
            for (let i in attributes) {
                element.setAttribute(i, attributes[i])
            }
        }

        return element
    }

    const sideMenuContainer = createElement('div', {id: 'side-menu-container'})
    const sideMenuOpener = createElement('button', {'class': 'side-menu-opener'})
    const sideMenu = createElement('div', {id: 'side-menu'})

    const body = querySelector('body')
    const html = querySelector('html')
    const nextcloud = querySelector('#nextcloud')

    const isTouchDevice = window.matchMedia("(pointer: coarse)").matches
    const targetBlankApps = <?php echo json_encode($_['target-blank-apps']) ?>

    <?php if ($display === 'big-menu'): ?>
        sideMenu.setAttribute('data-bigmenu', '1')
    <?php elseif ($display === 'side-with-categories'): ?>
        sideMenu.setAttribute('data-sidewithcategories', '1')
    <?php endif; ?>

    querySelector('body').addEventListener('side-menu.apps', (e) => {
        const apps = e.detail.apps;

        <?php if ($_['hide-when-no-apps']): ?>
            const sideMenu = querySelector('#side-menu')

            if (apps.length === 0) {
                sideMenu.classList.remove('open')
                sideMenu.classList.add('hide')
                sideMenuOpener.classList.add('hide')
            } else {
                sideMenu.classList.remove('hide')
                sideMenuOpener.classList.remove('hide')
            }

            <?php if ($display === 'always-displayed'): ?>
                if (apps.length === 0) {
                    html.classList.remove('side-menu-always-displayed')
                } else {
                    html.classList.add('side-menu-always-displayed')
                }
            <?php endif; ?>
        <?php else: ?>
            <?php if ($display === 'always-displayed'): ?>
                if (apps.length === 0) {
                    html.classList.remove('side-menu-always-displayed')
                } else {
                    html.classList.add('side-menu-always-displayed')
                }
            <?php endif; ?>
        <?php endif; ?>
    })

    body.addEventListener('side-menu.ready', () => {
        const sideMenu = querySelector('#side-menu')
        const headerMenuOpener = querySelector('#header .side-menu-opener')
        const sideMenuOpener = querySelectorAll('#side-menu .side-menu-opener')

        if (!headerMenuOpener) {
            return
        }

        sideMenuFocus = () => {
            let a = querySelector('.side-menu-app.active a', sideMenu)

            if (!a) {
                return
            }

            if (a.length === 0) {
                a = querySelector('.side-menu-app:first-child a', sideMenu)
            }

            if (a.length > 0) {
                a.focus()
            }
        }

        <?php if ($_['opener-hover']): ?>
            const sideMenuMouseLeave = () => {
                sideMenu.classList.remove('open')
                sideMenu.removeEventListener('mouseleave', sideMenuMouseLeave)
            }

            const sideMenuMouseEnter = () => {
                sideMenu.addEventListener('mouseleave', sideMenuMouseLeave)
            }

            const sideMenuOpenerMouseEnter = () => {
                sideMenu.classList.add('open')
                sideMenu.addEventListener('mouseenter', sideMenuMouseEnter)

                sideMenuFocus()
            }

            if (!isTouchDevice) {
                <?php if ($_['opener-hover']): ?>
                    headerMenuOpener.addEventListener('mouseenter', sideMenuOpenerMouseEnter)

                    sideMenu.classList.add('hide-opener')
                <?php endif ?>

                sideMenu.addEventListener('mouseleave', sideMenuMouseLeave)
                sideMenu.addEventListener('mouseenter', sideMenuOpenerMouseEnter)
            }
        <?php endif; ?>

        headerMenuOpener.addEventListener('click', () => {
            sideMenu.classList.add('open')

            const a = querySelector('.side-menu-app.active a', sideMenu)

            if (a !== null) {
                a.focus()
            }

            headerMenuOpener.blur()
        })

        for (let opener of sideMenuOpener) {
            opener.addEventListener('click', () => {
                <?php if ($display === 'always-displayed'): ?>
                    sideMenu.classList.toggle('open')
                <?php else: ?>
                    sideMenu.classList.remove('open')
                <?php endif; ?>
            })
        }

        document.addEventListener('keydown', (e) => {
            var key = e.key || e.keyCode

            if ((key === 'o' || key === 79) && e.ctrlKey === true) {
                e.preventDefault()

                sideMenu.classList.toggle('open')
                sideMenuFocus()
            }
        })

        const sideMenuObserver = new MutationObserver((e) => {
            if (body.getAttribute('id') !== 'body-settings') {
                return
            }

            body.classList.toggle('body-settings-side-menu', sideMenu.classList.contains('open'))
        })

        sideMenuObserver.observe(sideMenu, {
            attributes: true,
            attributeFilter: ['class'],
            childList: false,
            characterData: false
        })
    })

    body.appendChild(sideMenuContainer)
    sideMenuContainer.appendChild(sideMenu)

    <?php if ($_['loader-enabled'] === true): ?>
        <?php require_once __DIR__.'/_loaderEnabled.js'; ?>
    <?php endif; ?>

    if (nextcloud) {
        <?php if ($_['opener-position'] === 'before'): ?>
            nextcloud.parentNode.insertBefore(sideMenuOpener, nextcloud)
        <?php else: ?>
            nextcloud.parentNode.insertBefore(sideMenuOpener, nextcloud.nextSibling)
        <?php endif; ?>
    }

    <?php if (!empty($_['top-menu-apps']) || !empty($_['top-side-menu-apps'])): ?>
        const topMenuApps = <?php echo json_encode($_['top-menu-apps']), "\n"; ?>
        const topSideMenuApps = <?php echo json_encode($_['top-side-menu-apps']); ?>

        <?php require_once __DIR__.'/_topMenuApps.js'; ?>
    <?php endif; ?>

    <?php if ($display === 'always-displayed'): ?>
        <?php require_once __DIR__.'/_alwaysDisplayed.js'; ?>
    <?php endif; ?>
})();
