const alwaysDisplayed = function() {
    const elements = querySelectorAll('*')
    const fixedElements = []

    for (let element of elements) {
        if (typeof element !== 'object') {
            continue
        }

        const position = window.getComputedStyle(element, null).getPropertyValue('position')

        if (position !== 'fixed') {
            continue
        }

        const id = element.getAttribute('id')

        if (id === 'header' || id === 'side-menu' || id === 'side-menu-loader') {
            continue
        }

        if (element.classList.contains('oc-dialog')) {
            continue
        }

        let elementIsInSideMenu = false
        let parent = element.parentNode

        while (parent && !elementIsInSideMenu) {
            try {
                if  (parent.getAttribute('id') === 'side-menu') {
                    elementIsInSideMenu = true
                }
            } catch (e) {
            }

            parent = parent.parentNode
        }

        if (elementIsInSideMenu) {
            continue
        }

        fixedElements.push(element)
    }

    for (let i in fixedElements) {
        const element = fixedElements[i]
        const computedStyle = window.getComputedStyle(element, null)
        const left = computedStyle.getPropertyValue('left')
        const right = computedStyle.getPropertyValue('right')

        if (right !== '0px') {
            const intValue = parseInt(left.replace('px', '')) + 50
            element.style.setProperty('transform', 'translateX(' + intValue.toString() + 'px)')
        }
    }
}

const content = querySelector('#content')

if (content && content.classList.contains('app-settings')) {
    let loaded = false
    const config = {
        attributes: false,
        childList: true,
        subtree: true
    }
    const observer = new MutationObserver(() => {
        if (loaded) {
            return
        }

        const element = content.querySelector('#app-category-your-apps') || content.querySelector('#app-navigation ul')

        if (element) {
            loaded = true

            alwaysDisplayed()
        }
    })

    observer.observe(content, config)
} else {
    window.setTimeout(alwaysDisplayed, 200)
}
