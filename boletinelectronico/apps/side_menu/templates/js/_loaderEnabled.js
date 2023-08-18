let pageLoader = createElement('div', {id: 'side-menu-loader'})
let pageLoaderBar = createElement('div', {id: 'side-menu-loader-bar'})

pageLoader.appendChild(pageLoaderBar)
querySelector('body').appendChild(pageLoader)

let pageLoaderValue = 0

window.addEventListener('beforeunload', () => {
    setInterval(() => {
        pageLoaderBar.style.width = pageLoaderValue.toString() + '%'
        pageLoaderValue = Math.min(pageLoaderValue + .2, 100)
    }, 25)
})
