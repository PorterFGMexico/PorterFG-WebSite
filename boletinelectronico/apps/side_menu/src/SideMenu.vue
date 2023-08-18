<!--
@license GNU AGPL version 3 or any later version

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU Affero General Public License as
published by the Free Software Foundation, either version 3 of the
License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License
along with this program. If not, see <http://www.gnu.org/licenses/>.
-->
<template>
    <div id="side-menu">
        <div class="side-menu-header">
            <SettingsButton
                v-if="settings"
                v-bind:href="settings.href"
                v-bind:label="settings.name"
                v-bind:avatar="settings.avatar" />

            <OpenerButton />

            <Logo
                v-if="!avatar && logo" v-bind:classes="{'side-menu-logo': true, 'avatardiv': false}"
                v-bind:image="logo"
                v-bind:link="logoLink"
            />

            <Logo
                v-if="avatar" v-bind:classes="{'side-menu-logo': true, 'avatardiv': true}"
                v-bind:image="avatar"
                v-bind:link="logoLink"
            />
        </div>

        <ul class="side-menu-apps-list">
            <SideMenuApp
                v-for="app in apps"
                v-bind:classes="{'side-menu-app': true, 'active': app.active}"
                v-bind:icon="app.icon"
                v-bind:label="app.name"
                v-bind:href="app.href"
                v-bind:target="targetBlankApps.indexOf(app.id) !== -1 ? '_blank' : undefined"
            />
        </ul>
    </div>
</template>

<script>
import trim from 'trim'
import axios from 'axios'
import OpenerButton from './OpenerButton'
import SettingsButton from './SettingsButton'
import SideMenuApp from './SideMenuApp'
import Logo from './Logo'

export default {
    name: 'SideMenu',
    components: {
        SettingsButton,
        OpenerButton,
        SideMenuApp,
        Logo,
    },
    data() {
        return {
            apps: [],
            logo: null,
            logoLink: null,
            avatar: null,
            forceLightIcon: false,
            targetBlankApps: [],
            settings: null,
        }
    },
    methods: {
        retrieveApps() {
            this.apps = []
            const links = document.querySelectorAll('#appmenu a')
            const menu = document.querySelector('#appmenu')
            let menuIsHidden = true

            if (menu) {
                menuIsHidden = window.getComputedStyle(menu, null).getPropertyValue('display') === 'none'
            }

            for (let element of links) {
                let href = element.getAttribute('href')
                let parent = element.parentNode

                if (!parent) {
                    continue
                }

                let dataId = parent.getAttribute('data-id')
                dataId = dataId !== null ? dataId : ''

                if (!parent.classList.contains('app-top-side-menu') && !parent.classList.contains('app-hidden') && !menuIsHidden) {
                    continue
                }

                if (href !== '#') {
                    let svg = element.querySelector('svg').outerHTML

                    svg = svg
                        .replace(/(height|width)="20"/, '')
                        .replace('id="invertMenuMain', 'id="invertSideMenu')
                        .replace('url(#invertMenuMain', 'url(#invertSideMenu')

                    if (this.forceLightIcon) {
                        svg = svg.replace(/filter="url[^"]+"/, '')
                    }

                    this.apps.push({
                        id: dataId,
                        href: href,
                        name: trim(element.querySelector('span').innerHTML),
                        icon: svg,
                        active: element.classList.contains('active')
                    })
                }
            }

            (function(apps) {
                window.setTimeout(function() {
                    document.querySelector('body').dispatchEvent(new CustomEvent('side-menu.apps', {
                        detail: {apps: apps},
                    }))
                }, 1000)
            })(this.apps)
        },

        retrieveConfig() {
            let that = this

            axios
                .get(OC.generateUrl('/apps/side_menu/js/config'))
                .then(function(response) {
                    const config = response.data

                    that.targetBlankApps = config['target-blank-apps']
                    that.forceLightIcon = config['force-light-icon']
                    that.avatar = config['avatar']
                    that.logo = config['logo']
                    that.logoLink = config['logo-link']
                    that.settings = config['settings']
                })
        },
    },
    mounted() {
        this.retrieveConfig()
        this.retrieveApps()

        const menu = document.querySelector('#appmenu')

        if (menu) {
            const config = {attributes: true, childList: true, subtree: true}
            const observer = new MutationObserver(this.retrieveApps)
            observer.observe(menu, config)
        }
    }
}
</script>
