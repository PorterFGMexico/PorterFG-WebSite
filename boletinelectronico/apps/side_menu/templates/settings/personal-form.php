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
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

vendor_script('side_menu', 'html5sortable.min');
script('side_menu', 'admin');
style('side_menu', 'admin');

$choicesYesNo = [
    'No' => '0',
    'Yes' => '1',
];


$labelShowHideApps = 'Show and hide the list of applications';
?>
<div id="side-menu-section">
    <?php if ($_['force']): ?>
        <div class="section">
            <h2>
                <?php p($l->t('Menu')); ?>
            </h2>

            <p>
                <em><?php echo $l->t('You do not have permission to change the settings.'); ?></em>
            </p>
        </div>
    <?php else: ?>
        <div class="section">
            <h2>
                <?php p($l->t('Menu')); ?>
            </h2>

            <p>
                <em><?php echo $l->t('Use the shortcut <span class="keyboard-key">Ctrl</span>+<span class="keyboard-key">o</span> to open and to hide the side menu. Use <span class="keyboard-key">tab</span> to navigate.'); ?></em>
            </p>

            <div class="side-menu-setting-table">
                <div class="side-menu-setting-row">
                    <div class="side-menu-setting-label">
                        <?php p($l->t('Enable the custom menu')); ?>
                    </div>
                    <div class="side-menu-setting-form">
                        <select id="side-menu-enabled" name="enabled" class="side-menu-setting" data-personal>
                            <?php foreach ($choicesYesNo as $label => $value): ?>
                                <option value="<?php echo $value ?>" <?php if ($value === $_['enabled']): ?>selected<?php endif; ?>>
                                    <?php echo $l->t($label); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="side-menu-setting-table">
                <div class="side-menu-setting-row">
                    <div class="side-menu-setting-label">
                        <?php p($l->t('Open apps in new tab')); ?>
                    </div>
                    <div class="side-menu-setting-form">
                        <?php $choices = [
                            'Use the global setting' => '1',
                            'Use my selection' => '2',
                        ]; ?>

                        <select id="side-menu-loader-enabled" name="target-blank-mode" class="side-menu-setting" data-personal>
                            <?php foreach ($choices as $label => $value): ?>
                                <option value="<?php echo $value ?>" <?php if ($value === $_['target-blank-mode']): ?>selected<?php endif; ?>>
                                    <?php echo $l->t($label);  ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <p>
                            <a class="side-menu-toggler" data-target="#target-blank-apps" href="#_">
                                🖱️ <?php p($l->t($labelShowHideApps)); ?>
                            </a>
                        </p>

                        <div class="side-menu-setting" data-name="target-blank-apps" id="target-blank-apps" data-personal data-checkbox style="display: none">
                            <ul class="side-menu-setting-list">
                                <?php foreach ($_['apps'] as $app): ?>
                                    <li class="side-menu-setting-list-item">
                                        <input
                                            type="checkbox"
                                            name="target-blank-apps[]"
                                            value="<?php echo $app['id'] ?>"
                                            id="target-blank-app-<?php echo $app['id'] ?>"
                                            <?php if (in_array($app['id'], $_['target-blank-apps'])): ?>checked<?php endif; ?>
                                        />

                                        <label for="target-blank-app-<?php echo $app['id'] ?>">
                                            <?php echo p($l->t($app['name'])); ?>
                                        </label>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="section">
            <h2>
                <?php p($l->t('Top menu')); ?>
            </h2>

            <div class="side-menu-setting-table">
                <div class="side-menu-setting-row">
                    <div class="side-menu-setting-label">
                        <?php p($l->t('Apps only visible in the top menu')); ?>
                        <p>
                            <em>
                                <?php p($l->t('If there is no selection then the global configuration is applied.')); ?>
                            </em>
                        </p>
                    </div>
                    <div class="side-menu-setting-form">
                        <p>
                            <a class="side-menu-toggler" data-target="#top-menu-apps" href="#_">
                                🖱️ <?php p($l->t($labelShowHideApps)); ?>
                            </a>
                        </p>

                        <div class="side-menu-setting" data-name="top-menu-apps" data-checkbox data-personal id="top-menu-apps" style="display: none">
                            <ul class="side-menu-setting-list">
                                <?php foreach ($_['apps'] as $app): ?>
                                    <li class="side-menu-setting-list-item">
                                        <input
                                            type="checkbox"
                                            name="top-menu-apps[]"
                                            value="<?php echo $app['id'] ?>"
                                            id="top-menu-app-<?php echo $app['id'] ?>"
                                            <?php if (in_array($app['id'], $_['top-menu-apps'])): ?>checked<?php endif; ?>
                                        />

                                        <label for="top-menu-app-<?php echo $app['id'] ?>">
                                            <?php echo $app['name'] ?>
                                        </label>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="side-menu-setting-table">
                <div class="side-menu-setting-row">
                    <div class="side-menu-setting-label">
                        <?php p($l->t('Apps visible in the top and side menus')); ?>
                        <p>
                            <em>
                                <?php p($l->t('If there is no selection then the global configuration is applied.')); ?>
                            </em>
                        </p>
                    </div>
                    <div class="side-menu-setting-form">
                        <p>
                            <a class="side-menu-toggler" data-target="#top-side-menu-apps" href="#_">
                                🖱️ <?php p($l->t($labelShowHideApps)); ?>
                            </a>
                        </p>

                        <div class="side-menu-setting" data-name="top-side-menu-apps" data-checkbox data-personal id="top-side-menu-apps" style="display: none">
                            <ul class="side-menu-setting-list">
                                <?php foreach ($_['apps'] as $app): ?>
                                    <li class="side-menu-setting-list-item">
                                        <input
                                            type="checkbox"
                                            name="top-side-menu-apps[]"
                                            value="<?php echo $app['id'] ?>"
                                            id="top-side-menu-app-<?php echo $app['id'] ?>"
                                            <?php if (in_array($app['id'], $_['top-side-menu-apps'])): ?>checked<?php endif; ?>
                                        />

                                        <label for="top-side-menu-app-<?php echo $app['id'] ?>">
                                            <?php echo $app['name'] ?>
                                        </label>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif ?>

    <div class="section">
        <?php if (!$_['force']): ?>
            <button id="side-menu-save" class="btn btn-info">
                <?php p($l->t('Save')); ?>
                <progress max="100" value="0" id="side-menu-save-progress"></progress>
            </button>

            <span id="side-menu-message" class="msg"></span>

            <div style="height: 30px"></div>
        <?php endif ?>

        <div>
            <span for="side-menu-opener">
                <?php p($l->t('You like this app and you want to support me?')); ?>

                <a style="margin-left: 10px" target="_blank" href="https://www.buymeacoffee.com/deblan" rel="noopener">
                    <button>
                        <?php p($l->t('Buy me a coffee ☕')); ?>
                    </button>
                </a>
            </span>
        </div>
    </div>
</div>
