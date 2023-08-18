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
    <div>
        <ul class="side-menu-setting-list">
            <li v-for="item in values" class="side-menu-setting-list-item" v-on:click="showEditForm(item)">
                <span v-text="item.en"></span>
            </li>
        </ul>

        <Actions>
	        <ActionButton @click="showAddForm" icon="icon-add"></ActionButton>
        </Actions>

		<Modal v-if="addForm" @close="hideAddForm">
			<div class="modal__content">
                <div v-for="lang in langs">
                    <span class="lang" v-text="lang"></span>
                    <input type="text" v-model="newValue[lang]" required>
                </div>

                <Actions>
                    <ActionButton @click="saveAdd" icon="icon-checkmark"></ActionButton>
                </Actions>
            </div>
		</Modal>

		<Modal v-if="editForm" @close="hideEditForm">
			<div class="modal__content">
                <div v-for="lang in langs">
                    <span class="lang" v-text="lang"></span>
                    <input type="text" v-model="editValue[lang]" required>
                </div>

                <div class="pull-right">
                    <Actions>
                        <ActionButton @click="removeEdit" icon="icon-delete"></ActionButton>
                    </Actions>
                </div>

                <Actions>
                    <ActionButton @click="saveEdit" icon="icon-checkmark"></ActionButton>
                </Actions>
            </div>
		</Modal>
    </div>
</template>

<style scoped>
    .modal__content {
        width: 200px;
        padding: 10px;
    }

    .modal__content .lang {
        width: 60px;
        display: inline-block;
        padding: 4px;
        box-sizing: border-box;
    }

    .modal__content input[type=text] {
        width: calc(100% - 85px);
        display: inline-block;
        margin: 0;
    }

    .pull-right {
        float: right;
    }
</style>

<script>
import Modal from '@nextcloud/vue/dist/Components/Modal'
import Actions from '@nextcloud/vue/dist/Components/Actions'
import ActionButton from '@nextcloud/vue/dist/Components/ActionButton'

export default {
    name: 'AdminCategoriesCustom',
    components: {
        Modal,
        Actions,
        ActionButton,
    },
    data() {
        return {
            input: null,
            values: [],
            langs: [],
            addForm: false,
            editForm: false,
            newValue: {},
            editValue: {},
        }
    },
    methods: {
        init() {
            this.values = JSON.parse(this.input.value)
            this.langs = JSON.parse(this.input.getAttribute('data-langs'))
        },
        update() {
            this.input.value = JSON.stringify(this.values)
        },
        showAddForm() {
            this.newValue = {id: 'cat' + Math.random().toString().replace('0.', '')}

            this.addForm = true
        },
        showEditForm(value) {
            this.editValue = {id: value.id}

            for (let i of this.langs) {
                this.editValue[i] = typeof value[i] !== 'undefined' ? value[i] : ''
            }

            this.editForm = true
        },
        saveAdd() {
            for (let i of this.langs) {
                if (!this.newValue[i] || /^\s*$/.test(this.newValue[i])) {
                    return
                }
            }

            this.values.push(this.newValue)
            this.update()
            this.hideAddForm()
            this.newValue = {}
        },
        saveEdit() {
            for (let i of this.langs) {
                if (!this.editValue[i] || /^\s*$/.test(this.editValue[i])) {
                    return
                }
            }

            for (let i in this.values) {
                if (this.values[i].id === this.editValue.id) {
                    this.values[i] = this.editValue
                }
            }

            this.update()
            this.hideEditForm()
        },
        removeEdit() {
            for (let i in this.values) {
                if (this.values[i].id === this.editValue.id) {
                    this.values.splice(i, 1);
                }
            }

            this.update()
            this.hideEditForm()
        },
        hideAddForm() {
            this.addForm = false
        },
        hideEditForm() {
            this.editForm = false
        },
    },
    mounted() {
        this.input = document.querySelector('input[name="categories-custom"]')
        this.init()
    }
}
</script>
