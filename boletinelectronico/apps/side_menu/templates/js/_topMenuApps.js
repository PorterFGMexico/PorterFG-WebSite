let menuCache = null

const breakpointMobileWidth = 1024
const usePercentualAppMenuLimit = 0.8
const minAppsDesktop = 8

const handleMenuClick = (e, icon) => {
    let element = e.target

    while (element.tagName !== 'LI') {
        element = element.parentNode
    }

    const a = querySelector('a', element)

    if (a.getAttribute('target') !== '_blank' && e.which === 1 && !e.ctrlKey && !e.metaKey) {
        for (let tag of ['svg', 'div']) {
            let el = querySelector(tag, element)

            if (el) {
                el.remove()
            }
        }

        const loader = createElement('div', {'class': icon})

        a.insertBefore(loader, querySelector('span', a))
    }
}

const updateTopMenu = function() {
    const isMobile = window.innerWidth < breakpointMobileWidth
    const menu = querySelector('#appmenu')
    const moreApps = querySelector('#more-apps')
    const navigation = querySelector('#navigation')
    const navigationApps = querySelector('#apps ul')

    let apps = querySelectorAll('li', menu)
    let lastShownApp = null
    let appShown = []

    if ((menu.innerHTML + menu.nextSibling.innerHTML) === menuCache) {
        return
    }

    let navigationAppsHtml = ''

    for (let app of apps) {
        const dataId = app.getAttribute('data-id')

        if (dataId === null) {
            continue
        }

        if (topMenuApps.indexOf(dataId) === -1 && topSideMenuApps.indexOf(dataId) === -1) {
            app.classList.add('hidden')
            app.classList.add('app-hidden')
        } else {
            app.classList.remove('hidden')
            app.classList.add('app-external-site')

            if (topSideMenuApps.indexOf(dataId) !== -1) {
                app.classList.add('app-top-side-menu')
            }

            appShown.push(app)

            navigationAppsHtml = navigationAppsHtml + app.outerHTML
        }

        if (targetBlankApps.indexOf(dataId) !== -1) {
            querySelector('a', app).setAttribute('target', '_blank')
        }
    }

    navigationApps.innerHTML = navigationAppsHtml

    const rightHeaderWidth = querySelector('.header-right').offsetWidth
    const headerWidth = querySelector('header').offsetWidth

    let availableWidth = headerWidth

    availableWidth -= nextcloud.offsetWidth
    availableWidth -= querySelector('#header .side-menu-opener').offsetWidth
    availableWidth -= rightHeaderWidth > 230 ? rightHeaderWidth : 230
    availableWidth *= isMobile ? usePercentualAppMenuLimit : 1

    let appCount = Math.floor(availableWidth / querySelector('#appmenu li:not(.hidden)').offsetWidth)

    if (isMobile && appCount > minAppsDesktop) {
        appCount = minAppsDesktop
    } else if (!isMobile && appCount < minAppsDesktop) {
        appCount = minAppsDesktop
    }

    menu.style.opacity = 1

    if (appShown.length - 1 - appCount >= 1) {
        appCount--
    }

    for (let item of querySelectorAll('a', moreApps)) {
        item.classList.remove('active')
    }

    let k = 0
    let notInHeader = 0

    for (let app of appShown) {
        const name = app.getAttribute('data-id')
        const li = querySelector('#apps li[data-id=' + name + '].app-external-site')

        if (k < appCount && appCount > 0) {
            app.classList.remove('hidden')
            li.classList.add('in-header')

            lastShownApp = app
        } else {
            app.classList.add('hidden')
            li.classList.remove('in-header')

            notInHeader++

            const a = querySelector('a', app)

            if (appCount > 0 && a.classList.contains('active')) {
                lastShownApp.classList.add('hidden')
                app.classList.remove('hidden')
                notInHeader++

                li.classList.add('in-header')
            }
        }

        k++
    }

    // Hack for:
    // - https://github.com/nextcloud/server/blob/master/core/src/components/MainMenu.js#L97-L119
    // - https://github.com/nextcloud/server/blob/master/core/src/components/MainMenu.js#L97-L119
    jQuery(menu).undelegate('li:not(#more-apps) > a', 'click')
    jQuery(navigation).undelegate('a', 'click')

    const confs = [
        {
            items: querySelectorAll('#navigation li'),
            icon: 'icon-loading-small'
        },
        {
            items: querySelectorAll('li:not(#more-apps)', menu),
            icon: OCA.Theming && OCA.Theming.inverted ? 'icon-loading-small' : 'icon-loading-small-dark'
        },
    ]

    for (let conf of confs) {
        for (let item of conf.items) {
            item.addEventListener('click', (e) => {
                handleMenuClick(e, conf.icon)
            })
        }
    }

    for (let app of querySelectorAll('#apps li.app-external-site')) {
        const appId = app.getAttribute('data-id')

        if (app.classList.contains('in-header')) {
            for (let defs of querySelectorAll('svg defs', app)) {
                defs.remove()
            }
        } else {
            const svg = querySelector('svg', app)

            if (querySelectorAll('svg defs', app).length > 0) {
                continue
            }

            const defs = `
                <defs>
                    <filter id="invertMenuMore-${appId}">
                        <feColorMatrix in="SourceGraphic" type="matrix" values="-1 0 0 0 1 0 -1 0 0 1 0 0 -1 0 1 0 0 0 1 0"></feColorMatrix>
                    </filter>
                </defs>`

            svg.innerHTML = defs + svg.innerHTML

            for (let image of querySelectorAll('image', svg)) {
                image.setAttribute('filter', `url(#invertMenuMore-${appId})`)
            }

            svg.innerHTML = svg.innerHTML.replace(/fecolormatrix/g, 'feColorMatrix')
        }
    }

    if (notInHeader === 0) {
        moreApps.style.display = 'none'
        navigation.style.display = 'none'
    } else {
        moreApps.style.display = 'flex'
    }

    menuCache = menu.innerHTML + menu.nextSibling.innerHTML
}

for (let i = 0; i < 4000; i+= 100) {
    setTimeout(updateTopMenu, i)
}

let resizeTimeout = null;

window.addEventListener('resize', () => {
    if (resizeTimeout !== null) {
        clearTimeout(resizeTimeout)
    }

    resizeTimeout = setTimeout(updateTopMenu, 100)
})
