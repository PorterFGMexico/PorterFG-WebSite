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
    <div id="side-menu" class="side-menu-with-categories">
        <div class="side-menu-header">
            <SettingsButton
                v-if="settings"
                v-bind:href="settings.href"
                v-bind:label="settings.name"
                v-bind:avatar="settings.avatar"
            />

            <OpenerButton />
        </div>

        <div class="side-menu-categories-wrapper">
            <div class="side-menu-categories">
                <Loader v-if="!items.length" />

                <div class="side-menu-category" v-for="category in items">
                    <h2 class="side-menu-category-title" v-if="category.name != ''" v-text="category.name"></h2>

                    <ul class="side-menu-apps-list">
                        <SideMenuBigApp
                            v-for="(app, appId) in category.apps"
                            v-bind:classes="{'side-menu-app': true, 'active': activeApp === appId}"
                            v-bind:icon="app.icon"
                            v-bind:label="app.name"
                            v-bind:href="app.href"
                            v-bind:target="targetBlankApps.indexOf(appId) !== -1 ? '_blank' : undefined"
                        />
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import OpenerButton from './OpenerButton'
import CloserButton from './CloserButton'
import SettingsButton from './SettingsButton'
import Loader from './Loader'
import SideMenuBigApp from './SideMenuBigApp'

export default {
    name: 'SideMenuWithCategories',
    components: {
        SettingsButton,
        OpenerButton,
        CloserButton,
        Loader,
        SideMenuBigApp,
    },
    data() {
        return {
            items: [],
            activeApp: null,
            targetBlank: false,
            targetBlankApps: [],
            settings: null,
        }
    },
    methods: {
        retrieveApps() {
            this.apps = []
            let that = this

            axios
                .get(OC.generateUrl('/apps/side_menu/nav/items'))
                .then(function(response) {
                    that.items = response.data.items

                    let apps = []

                    for (let category of that.items) {
                        for (let a in category.apps) {
                            apps.push(category.apps[a])
                        }
                    }

                    document.querySelector('body').dispatchEvent(new CustomEvent('side-menu.apps', {
                        detail: {apps: apps},
                    }))
                })
        },

        retrieveActiveApp() {
            let activeAppLink = document.querySelector('#appmenu a.active')
            this.activeApp = activeAppLink ? activeAppLink.parentNode.getAttribute('data-id') : null
        },

        retrieveConfig() {
            let that = this

            axios
                .get(OC.generateUrl('/apps/side_menu/js/config'))
                .then(function(response) {
                    const config = response.data

                    that.targetBlankApps = config['target-blank-apps']
                    that.settings = config['settings']
                })
        },
    },
    mounted() {
        this.retrieveConfig()
        this.retrieveApps()
        this.retrieveActiveApp()
    }
}
</script>
