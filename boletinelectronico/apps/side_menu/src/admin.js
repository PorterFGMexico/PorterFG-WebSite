/**
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

import AdminCategoriesCustom from './AdminCategoriesCustom.vue'
import Vue from 'vue'

Vue.prototype.OC = window.OC
Vue.prototype.OCA = window.OCA

let elements = []

const selector = '#side-menu-message'

const userConfig = (name, value, callbacks) => {
    const url = OC.generateUrl('/apps/side_menu/personalSetting/valueSet')
    const formData = []

    formData.push('name=' + encodeURIComponent(name))
    formData.push('value=' + encodeURIComponent(value))

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: formData.join('&')
    })
    .then(callbacks.success)
    .catch(callbacks.error)
}

const appConfig = (name, value, callbacks) => {
    OCP.AppConfig.setValue('side_menu', name, value, callbacks)
}

const saveSettings = (key) => {
    const element = elements[key]

    if (!element) {
        return
    }

    let value
    let name

    if (element.hasAttribute('data-checkbox')) {
        name = element.getAttribute('data-name')
        value = []

        const inputs = document.querySelectorAll('input[name="' + name + '[]"]:checked')

        for (let input of inputs) {
            value.push(input.value)
        }

        value = JSON.stringify(value)
    } else {
        name = element.getAttribute('name')
        value = element.value
    }

    const size = elements.length

    if (name === 'cache') {
        ++value
    }

    const progress = document.querySelector('#side-menu-save-progress')

    progress.style.width = '40px';
    progress.style.marginLeft = '5px';

    const callbacks = {
        success: () => {
            const percent = parseInt((key + 1) * 100 / size);

            progress.setAttribute('value', percent)

            if (key < size - 1) {
                saveSettings(key + 1)
            } else {
                location.reload()
            }
        },
        error: () => {
            OC.msg.finishedError(selector, t('side_menu', 'Error while saving "' + element + '"'))
        }
    }

    if (element.hasAttribute('data-personal')) {
        userConfig(name, value, callbacks)
    } else {
        appConfig(name, value, callbacks)
    }
}

const elementToggler = (element) => {
    let display = 'none'

    if (window.getComputedStyle(element).display === 'none') {
        display = 'block'
    }

    element.style.display = display
}

const updateAppsCategoriesCustom = () => {
    let values = {}

    for (let item of document.querySelectorAll('.apps-categories-custom')) {
        let app = item.getAttribute('data-app')
        let value = item.value

        if (value) {
            values[app] = value
        }
    }

    document.querySelector('#apps-categories-custom').value = JSON.stringify(values)
}

document.addEventListener('DOMContentLoaded', () => {
    $('*[data-toggle="tooltip"]').tooltip();

    if (document.querySelector('#side-menu-categories-custom')) {
        const View = Vue.extend(AdminCategoriesCustom)
        const adminCategoriesCustom = new View({})

        adminCategoriesCustom.$mount('#side-menu-categories-custom')
    }

    elements = document.querySelectorAll('.side-menu-setting')

    document.querySelector('#side-menu-save').addEventListener('click', (event) => {
        event.preventDefault()
        OC.msg.startSaving(selector)

        saveSettings(0)
    })

    const resets = document.querySelectorAll('.btn-reset')

    for (let btn of resets) {
        btn.addEventListener('click', (event) => {
            const target = event.target
            const values = JSON.parse(target.getAttribute('data-reset'))

            for (let i in values) {
                document.querySelector(`#${i}`).value = values[i]
            }
        })
    }

    const displays = document.querySelectorAll('.side-menu-display')

    for (let display of displays) {
        display.addEventListener('click', (event) => {
            const target = event.target

            for (let d of displays) {
                d.classList.toggle('is-active', d === display)
            }

            document.querySelector('#side-menu-always-displayed').value = target.getAttribute('data-alwaysdiplayed')
            document.querySelector('#side-menu-big-menu').value = target.getAttribute('data-bigmenu')
            document.querySelector('#side-menu-side-with-categories').value = target.getAttribute('data-sidewithcategories')
        })
    }

    for (let item of document.querySelectorAll('.apps-categories-custom')) {
        item.addEventListener('change', (event) => {
            updateAppsCategoriesCustom()
        })
    }

    for (let item of document.querySelectorAll('.side-menu-setting-live')) {
        item.addEventListener('change', (event) => {
            const target = event.target
            const name = target.getAttribute('name')

            let value = target.value
            let id = null

            if (name === 'background-color-opacity') {
                id = '#side-menu-background-color, #side-menu-background-color-to'
            } else if (name === 'dark-mode-background-color-opacity') {
                id = '#side-menu-dark-mode-background-color, #side-menu-dark-mode-background-color-to'
            }

            if (id) {
                document.querySelector(id).dispatchEvent(new CustomEvent('change'))

                return
            }

            if (name === 'opener') {
                const url = OC.generateUrl(`/apps/side_menu/img/${value}.svg`).replace('/index.php', '')

                value = `url(${url})`
            }

            if (name === 'icon-invert-filter' || name === 'icon-opacity') {
                value/=100
            }

            if (['dark-mode-background-color', 'dark-mode-background-color-to'].indexOf(name) > -1) {
                const opacity = parseInt(document.querySelector('#side-menu-dark-mode-background-color-opacity').value * 255 / 100)

                value = [value, opacity.toString(16)].join('')
            } else if (['background-color', 'background-color-to'].indexOf(name) > -1) {
                const opacity = parseInt(document.querySelector('#side-menu-background-color-opacity').value * 255 / 100)

                value = [value, opacity.toString(16)].join('')
            }

            document.documentElement.style.setProperty('--side-menu-' + name, value)
        })
    }

    for (let toggler of document.querySelectorAll('.side-menu-toggler')) {
        toggler.addEventListener('click', (event) => {
            const target = event.target
            const element = document.querySelector(target.getAttribute('data-target'))

            elementToggler(element)
        })
    }

    sortable('#categories-list .side-menu-setting-list', {
        placeholderClass: 'side-menu-setting-list-drop'
    })

    try {
        sortable('#categories-list .side-menu-setting-list')[0].addEventListener('sortstop', (e) => {
            let value = []

            for (let item of document.querySelectorAll('#categories-list .side-menu-setting-list-item')) {
                console.log(item.getAttribute('data-id'))
                value.push(item.getAttribute('data-id'))
            }

            document.querySelector('input[name="categories-order"]').value = JSON.stringify(value)
        })
    } catch (e) {
    }
})
