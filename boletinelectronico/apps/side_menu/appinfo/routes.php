<?php

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

return [
    'routes' => [
        ['name' => 'Css#stylesheet', 'url' => '/css/stylesheet', 'verb' => 'GET'],
        ['name' => 'Js#script', 'url' => '/js/script', 'verb' => 'GET'],
        ['name' => 'Js#config', 'url' => '/js/config', 'verb' => 'GET'],
        ['name' => 'Nav#items', 'url' => '/nav/items', 'verb' => 'GET'],
        ['name' => 'PersonalSetting#valueSet', 'url' => '/personalSetting/valueSet', 'verb' => 'POST'],
        ['name' => 'AdminSetting#removeCache', 'url' => '/admin/cache/remove', 'verb' => 'GET'],
        ['name' => 'AdminSetting#exportConfiguration', 'url' => '/admin/config/export', 'verb' => 'GET'],
    ],
];
