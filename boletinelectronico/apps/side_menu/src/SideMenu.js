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
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

import Vue from 'vue'
import SideMenu from './SideMenu.vue'
import SideMenuBig from './SideMenuBig.vue'
import SideMenuWithCategories from './SideMenuWithCategories.vue'

Vue.prototype.OC = OC

const mountSideMenuComponent = () => {
    const sideMenuContainer = document.querySelector('#side-menu')

    if (sideMenuContainer) {
        let component

        if (sideMenuContainer.getAttribute('data-bigmenu')) {
            component = SideMenuBig
        } else if(sideMenuContainer.getAttribute('data-sidewithcategories')) {
            component = SideMenuWithCategories
        } else {
            component = SideMenu
        }

        const View = Vue.extend(component)
        const sideMenu = new View({})

        sideMenu.$mount('#side-menu')

        document.querySelector('body').dispatchEvent(new CustomEvent('side-menu.ready'))
    } else {
        window.setTimeout(mountSideMenuComponent, 50)
    }
}

mountSideMenuComponent()
