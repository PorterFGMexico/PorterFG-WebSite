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

use OCP\IURLGenerator;
use OCP\IConfig;
use OCA\SideMenu\AppInfo\Application;

vendor_script('side_menu', 'html5sortable.min');
script('side_menu', 'admin');
style('side_menu', 'admin');

$urlGenerator = \OC::$server[IURLGenerator::class];
$cacheSize = floor(mb_strlen(\OC::$server[IConfig::class]->getAppValue(Application::APP_ID, 'cache-categories', ''), '8bit') / 1024);

$choicesYesNo = [
    'No' => '0',
    'Yes' => '1',
];

$choicesSizes = [
    'Hidden' => 'hidden',
    'Small' => 'small',
    'Normal' => 'normal',
    'Big' => 'big',
];

$labelShowHideApps = 'Show and hide the list of applications';
$labelReset = 'Reset to default';
?>
<div id="side-menu-section">
    <div class="section">
        <h2>
            <?php p($l->t('Colors')); ?>

            <small><span class="info"><?php p($l->t('Live preview')); ?></span></small>
        </h2>

        <div class="side-menu-setting-table">
            <div class="side-menu-setting-row">
                <div class="side-menu-setting-label side-menu-setting-label-short">
                    <?php p($l->t('Background color')); ?>
                </div>
                <div class="side-menu-setting-form side-menu-setting-form-long">
                    <input
                        id="side-menu-background-color"
                        name="background-color"
                        type="color"
                        class="side-menu-setting side-menu-setting-live"
                        value="<?php print_unescaped($_['background-color']); ?>">
                    <input
                        id="side-menu-background-color-to"
                        name="background-color-to"
                        type="color"
                        class="side-menu-setting side-menu-setting-live"
                        value="<?php print_unescaped($_['background-color-to']); ?>">

                        <div class="theme-undo icon icon-history btn-reset" data-toggle="tooltip" data-original-title="<?php echo p($l->t($labelReset)); ?>" data-reset="<?php echo htmlentities(json_encode([
                            'side-menu-background-color' => $_['defaults']['background-color'],
                            'side-menu-background-color-to' => $_['defaults']['background-color-to'],
                        ])) ?>"></div>
                    <div>
                        <em>
                            <?php p($l->t('Transparent')); ?>
                        </em>

                        <input
                            type="range"
                            min="0" max="100"
                            id="side-menu-background-color-opacity"
                            name="background-color-opacity"
                            class="side-menu-setting side-menu-setting-live"
                            value="<?php echo $_['background-color-opacity'] ?>"
                        >

                        <em>
                            <?php p($l->t('Opaque')); ?>
                        </em>
                    </div>
                </div>

            </div>
        </div>

        <div class="side-menu-setting-table">
            <div class="side-menu-setting-row">
                <div class="side-menu-setting-label side-menu-setting-label-short">
                    <?php p($l->t('Background color of current app')); ?>
                </div>
                <div class="side-menu-setting-form side-menu-setting-form-long">
                    <input
                        id="side-menu-current-app-background-color"
                        name="current-app-background-color"
                        type="color"
                        class="side-menu-setting side-menu-setting-live"
                        value="<?php print_unescaped($_['current-app-background-color']); ?>">

                    <div class="theme-undo icon icon-history btn-reset" data-toggle="tooltip" data-original-title="<?php echo p($l->t($labelReset)); ?>" data-reset="<?php echo htmlentities(json_encode([
                        'side-menu-current-app-background-color' => $_['defaults']['current-app-background-color'],
                    ])) ?>"></div>
                </div>
            </div>
        </div>

        <div class="side-menu-setting-table">
            <div class="side-menu-setting-row">
                <div class="side-menu-setting-label side-menu-setting-label-short">
                    <?php p($l->t('Text color')); ?>
                </div>
                <div class="side-menu-setting-form side-menu-setting-form-long">
                    <input
                        id="side-menu-text-color"
                        name="text-color"
                        type="color"
                        class="side-menu-setting side-menu-setting-live"
                        value="<?php print_unescaped($_['text-color']); ?>">

                    <div class="theme-undo icon icon-history btn-reset" data-toggle="tooltip" data-original-title="<?php echo p($l->t($labelReset)); ?>" data-reset="<?php echo htmlentities(json_encode([
                        'side-menu-text-color' => $_['defaults']['text-color'],
                    ])) ?>"></div>
                </div>
            </div>
        </div>

        <div class="side-menu-setting-table">
            <div class="side-menu-setting-row">
                <div class="side-menu-setting-label side-menu-setting-label-short">
                    <?php p($l->t('Loader')); ?>
                </div>
                <div class="side-menu-setting-form side-menu-setting-form-long">
                    <input
                        id="side-menu-loader-color"
                        name="loader-color"
                        type="color"
                        class="side-menu-setting"
                        value="<?php print_unescaped($_['loader-color']); ?>">

                    <div class="theme-undo icon icon-history btn-reset" data-toggle="tooltip" data-original-title="<?php echo p($l->t($labelReset)); ?>" data-reset="<?php echo htmlentities(json_encode([
                        'side-menu-loader-color' => $_['defaults']['loader-color'],
                    ])) ?>"></div>
                </div>
            </div>
        </div>

        <div class="side-menu-setting-table">
            <div class="side-menu-setting-row">
                <div class="side-menu-setting-label side-menu-setting-label-short">
                    <?php p($l->t('Icon')); ?>
                </div>
                <div class="side-menu-setting-form side-menu-setting-form-long">
                    <div>
                        <em>
                            <?php p($l->t('Same color')); ?>
                        </em>

                        <input
                            type="range"
                            min="0" max="100"
                            id="side-menu-icon-invert-filter"
                            name="icon-invert-filter"
                            class="side-menu-setting side-menu-setting-live"
                            value="<?php echo $_['icon-invert-filter'] ?>"
                        >

                        <em>
                            <?php p($l->t('Opposite color')); ?>
                        </em>
                    </div>

                    <div>
                        <em>
                            <?php p($l->t('Transparent')); ?>
                        </em>

                        <input
                            type="range"
                            min="0" max="100"
                            id="side-menu-icon-opacity"
                            name="icon-opacity"
                            class="side-menu-setting side-menu-setting-live"
                            value="<?php echo $_['icon-opacity'] ?>"
                        >

                        <em>
                            <?php p($l->t('Opaque')); ?>
                        </em>
                    </div>
                </div>
            </div>
        </div>

        <div class="side-menu-setting-table">
            <?php
                $choices = [
                    'Default' => 'side-menu-opener',
                    'Default (dark)' => 'side-menu-opener-dark',
                    'Hamburger' => 'side-menu-opener-hamburger',
                    'Hamburger (dark)' => 'side-menu-opener-hamburger-dark',
                    'Hamburger 2' => 'side-menu-opener-hamburger-2',
                    'Hamburger 2 (dark)' => 'side-menu-opener-hamburger-2-dark',
                ];
            ?>
            <div class="side-menu-setting-row">
                <div class="side-menu-setting-label side-menu-setting-label-short">
                    <?php p($l->t('Icon')); ?>
                </div>
                <div class="side-menu-setting-form side-menu-setting-form-long">
                    <select id="side-menu-opener" name="opener" class="side-menu-setting side-menu-setting-live">
                        <?php foreach ($choices as $label => $value): ?>
                            <option value="<?php echo $value ?>" <?php if ($value === $_['opener']): ?>selected<?php endif; ?>>
                                <?php echo $l->t($label);  ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>

        <h2>
            <?php p($l->t('Dark mode colors')); ?>
        </h2>

        <p>
            <?php echo $l->t('This parameters are used when Dark theme or Breeze Dark Theme are enabled.'); ?>
        </p>

        <div class="side-menu-setting-table">
            <div class="side-menu-setting-row">
                <div class="side-menu-setting-label side-menu-setting-label-short">
                    <?php p($l->t('Background color')); ?>
                </div>
                <div class="side-menu-setting-form side-menu-setting-form-long">
                    <input
                        id="side-menu-dark-mode-background-color"
                        name="dark-mode-background-color"
                        type="color"
                        class="side-menu-setting"
                        value="<?php print_unescaped($_['dark-mode-background-color']); ?>">
                    <input
                        id="side-menu-dark-mode-background-color-to"
                        name="dark-mode-background-color-to"
                        type="color"
                        class="side-menu-setting"
                        value="<?php print_unescaped($_['dark-mode-background-color-to']); ?>">

                    <div class="theme-undo icon icon-history btn-reset" data-toggle="tooltip" data-original-title="<?php echo p($l->t($labelReset)); ?>" data-reset="<?php echo htmlentities(json_encode([
                        'side-menu-dark-mode-background-color' => $_['defaults']['dark-mode-background-color'],
                        'side-menu-dark-mode-background-color-to' => $_['defaults']['dark-mode-background-color-to'],
                    ])) ?>"></div>

                    <div>
                        <em>
                            <?php p($l->t('Transparent')); ?>
                        </em>

                        <input
                            type="range"
                            min="0" max="100"
                            id="side-menu-dark-mode-background-color-opacity"
                            name="dark-mode-background-color-opacity"
                            class="side-menu-setting side-menu-setting-live"
                            value="<?php echo $_['dark-mode-background-color-opacity'] ?>"
                        >

                        <em>
                            <?php p($l->t('Opaque')); ?>
                        </em>
                    </div>
                </div>
            </div>
        </div>

        <div class="side-menu-setting-table">
            <div class="side-menu-setting-row">
                <div class="side-menu-setting-label side-menu-setting-label-short">
                    <?php p($l->t('Background color of current app')); ?>
                </div>
                <div class="side-menu-setting-form side-menu-setting-form-long">
                    <input
                        id="side-menu-dark-mode-current-app-background-color"
                        name="dark-mode-current-app-background-color"
                        type="color"
                        class="side-menu-setting"
                        value="<?php print_unescaped($_['dark-mode-current-app-background-color']); ?>">

                    <div class="theme-undo icon icon-history btn-reset" data-toggle="tooltip" data-original-title="<?php echo p($l->t($labelReset)); ?>" data-reset="<?php echo htmlentities(json_encode([
                        'side-menu-dark-mode-current-app-background-color' => $_['defaults']['dark-mode-current-app-background-color'],
                    ])) ?>"></div>
                </div>
            </div>
        </div>

        <div class="side-menu-setting-table">
            <div class="side-menu-setting-row">
                <div class="side-menu-setting-label side-menu-setting-label-short">
                    <?php p($l->t('Text color')); ?>
                </div>
                <div class="side-menu-setting-form side-menu-setting-form-long">
                    <input
                        id="side-menu-dark-mode-text-color"
                        name="dark-mode-text-color"
                        type="color"
                        class="side-menu-setting"
                        value="<?php print_unescaped($_['dark-mode-text-color']); ?>">

                    <div class="theme-undo icon icon-history btn-reset" data-toggle="tooltip" data-original-title="<?php echo p($l->t($labelReset)); ?>" data-reset="<?php echo htmlentities(json_encode([
                        'side-menu-dark-mode-text-color' => $_['defaults']['dark-mode-text-color'],
                    ])) ?>"></div>
                </div>
            </div>
        </div>

        <div class="side-menu-setting-table">
            <div class="side-menu-setting-row">
                <div class="side-menu-setting-label side-menu-setting-label-short">
                    <?php p($l->t('Loader')); ?>
                </div>
                <div class="side-menu-setting-form side-menu-setting-form-long">
                    <input
                        id="side-menu-dark-mode-loader-color"
                        name="dark-mode-loader-color"
                        type="color"
                        class="side-menu-setting"
                        value="<?php print_unescaped($_['dark-mode-loader-color']); ?>">

                    <div class="theme-undo icon icon-history btn-reset" data-toggle="tooltip" data-original-title="<?php echo p($l->t($labelReset)); ?>" data-reset="<?php echo htmlentities(json_encode([
                        'side-menu-dark-mode-loader-color' => $_['defaults']['dark-mode-loader-color'],
                    ])) ?>"></div>
                </div>
            </div>
        </div>

        <div class="side-menu-setting-table">
            <div class="side-menu-setting-row">
                <div class="side-menu-setting-label side-menu-setting-label-short">
                    <?php p($l->t('Icon')); ?>
                </div>
                <div class="side-menu-setting-form side-menu-setting-form-long">
                    <div>
                        <em>
                            <?php p($l->t('Same color')); ?>
                        </em>

                        <input
                            type="range"
                            min="0" max="100"
                            name="dark-mode-icon-invert-filter"
                            class="side-menu-setting"
                            value="<?php echo $_['dark-mode-icon-invert-filter'] ?>"
                        >

                        <em>
                            <?php p($l->t('Opposite color')); ?>
                        </em>
                    </div>

                    <div>
                        <em>
                            <?php p($l->t('Transparent')); ?>
                        </em>

                        <input
                            type="range"
                            min="0" max="100"
                            name="dark-mode-icon-opacity"
                            class="side-menu-setting"
                            value="<?php echo $_['dark-mode-icon-opacity'] ?>"
                        >

                        <em>
                            <?php p($l->t('Opaque')); ?>
                        </em>
                    </div>
                </div>
            </div>
        </div>

        <div class="side-menu-setting-table">
            <?php
                $choices = [
                    'Default' => 'side-menu-opener',
                    'Default (dark)' => 'side-menu-opener-dark',
                    'Hamburger' => 'side-menu-opener-hamburger',
                    'Hamburger (dark)' => 'side-menu-opener-hamburger-dark',
                    'Hamburger 2' => 'side-menu-opener-hamburger-2',
                    'Hamburger 2 (dark)' => 'side-menu-opener-hamburger-2-dark',
                ];
            ?>
            <div class="side-menu-setting-row">
                <div class="side-menu-setting-label side-menu-setting-label-short">
                    <?php p($l->t('Icon')); ?>
                </div>
                <div class="side-menu-setting-form side-menu-setting-form-long">
                    <select name="dark-mode-opener" class="side-menu-setting">
                        <?php foreach ($choices as $label => $value): ?>
                            <option value="<?php echo $value ?>" <?php if ($value === $_['dark-mode-opener']): ?>selected<?php endif; ?>>
                                <?php echo $l->t($label);  ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="section">
        <h2>
            <?php p($l->t('Opener')); ?>
        </h2>

        <div class="side-menu-setting-table">
            <div class="side-menu-setting-row">
                <?php
                    $choices = [
                        'Before the logo' => 'before',
                        'After the logo' => 'after',
                    ];
                ?>
                <div class="side-menu-setting-label">
                    <?php p($l->t('Position')); ?>
                </div>
                <div class="side-menu-setting-form">
                    <select id="side-menu-opener-position" name="opener-position" class="side-menu-setting">
                        <?php foreach ($choices as $label => $value): ?>
                            <option value="<?php echo $value ?>" <?php if ($value === $_['opener-position']): ?>selected<?php endif; ?>>
                                <?php echo $l->t($label);  ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="side-menu-setting-row">
                <div class="side-menu-setting-label">
                    <?php p($l->t('Show only the opener (hidden logo)')); ?>
                </div>
                <div class="side-menu-setting-form">
                    <select id="side-menu-opener-only" name="opener-only" class="side-menu-setting">
                        <?php foreach ($choicesYesNo as $label => $value): ?>
                            <option value="<?php echo $value ?>" <?php if ($value === $_['opener-only']): ?>selected<?php endif; ?>>
                                <?php echo $l->t($label);  ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="side-menu-setting-row">
                <div class="side-menu-setting-label">
                    <?php p($l->t('Do not display the side menu and the opener if there is no application (eg: public pages).')); ?>
                </div>
                <div class="side-menu-setting-form">
                    <select id="side-menu-hide-when-no-apps" name="hide-when-no-apps" class="side-menu-setting">
                        <?php foreach ($choicesYesNo as $label => $value): ?>
                            <option value="<?php echo $value ?>" <?php if ($value === $_['hide-when-no-apps']): ?>selected<?php endif; ?>>
                                <?php echo $l->t($label);  ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="section">
        <h2>
            <?php p($l->t('Panel')); ?>
        </h2>

        <?php
            $displays = [
                'default' => !$_['always-displayed'] && !$_['big-menu'] && !$_['side-with-categories'],
                'always-displayed' => $_['always-displayed'] && !$_['big-menu'] && !$_['side-with-categories'],
                'side-with-categories' => $_['side-with-categories'] && !$_['always-displayed'] && !$_['big-menu'],
                'big-menu' => $_['big-menu'] && !$_['always-displayed'] && !$_['side-with-categories'],
            ];
        ?>

        <div>
            <label>
                <?php p($l->t('Default')); ?>
            </label>
        </div>
        <p>
            <img
                class="side-menu-display <?php echo $displays['default'] ? 'is-active' : '' ?>"
                data-alwaysdiplayed="0"
                data-bigmenu="0"
                data-sidewithcategories="0"
                src="<?php print_unescaped(image_path('side_menu', 'admin/layout-default.svg')); ?>" alt="<?php p($l->t('Default')); ?>">
        </p>

        <div>
            <label>
                <?php p($l->t('With categories')); ?>
            </label>
        </div>
        <p><em><?php echo $l->t('This menu is not compatible with AppOrder.'); ?></em></p>
        <p>
            <img
                class="side-menu-display <?php echo $displays['side-with-categories'] ? 'is-active' : '' ?>"
                data-alwaysdiplayed="0"
                data-bigmenu="0"
                data-sidewithcategories="1"
                src="<?php print_unescaped(image_path('side_menu', 'admin/layout-side-with-categories.svg')); ?>" alt="<?php p($l->t('With categories')); ?>">
        </p>

        <div>
            <label for="side-menu-opener">
                <?php p($l->t('Big menu')); ?>
            </label>
        </div>
        <p><em><?php echo $l->t('This menu is not compatible with AppOrder.'); ?></em></p>
        <p>
            <img
                class="side-menu-display <?php echo $displays['big-menu'] ? 'is-active' : '' ?>"
                data-alwaysdiplayed="0"
                data-bigmenu="1"
                data-sidewithcategories="0"
                src="<?php print_unescaped(image_path('side_menu', 'admin/layout-big-menu.svg')); ?>" alt="<?php p($l->t('Big menu')); ?>">
        </p>

        <div>
            <label for="side-menu-opener">
                <?php p($l->t('Always displayed')); ?>
            </label>
        </div>
        <p><em><?php p($l->t('Not compatible with touch screens.')); ?></em></p>
        <p>
            <img
                class="side-menu-display <?php echo $displays['always-displayed'] ? 'is-active' : '' ?>"
                data-alwaysdiplayed="1"
                data-bigmenu="0"
                data-sidewithcategories="0"
                src="<?php print_unescaped(image_path('side_menu', 'admin/layout-always-displayed.svg')); ?>" alt="<?php p($l->t('Always displayed')); ?>">
        </p>

        <input
            type="hidden"
            class="side-menu-setting"
            name="always-displayed"
            id="side-menu-always-displayed"
            value="<?php echo (int) $_['always-displayed'] ?>"
        >
        <input
            type="hidden"
            class="side-menu-setting"
            name="big-menu"
            id="side-menu-big-menu"
            value="<?php echo (int) $_['big-menu'] ?>"
        >
        <input
            type="hidden"
            class="side-menu-setting"
            name="side-with-categories"
            id="side-menu-side-with-categories"
            value="<?php echo (int) $_['side-with-categories'] ?>"
        >
        <br>


        <div class="side-menu-setting-table">
            <div class="side-menu-setting-row">
                <div class="side-menu-setting-label">
                    <?php p($l->t('Open the menu when the mouse is hover the opener (automatically disabled on touch screens)')); ?>

                    <br>
                    <em><?php p($l->t('This is the automatic behavior when the menu is always displayed.')); ?></em>
                </div>
                <div class="side-menu-setting-form">
                    <select id="side-menu-opener-hover" name="opener-hover" class="side-menu-setting">
                        <?php foreach ($choicesYesNo as $label => $value): ?>
                            <option value="<?php echo $value ?>" <?php if ($value === $_['opener-hover']): ?>selected<?php endif; ?>>
                                <?php echo $l->t($label);  ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="side-menu-setting-row">
                <div class="side-menu-setting-label">
                    <?php p($l->t('Display the logo')); ?>
                    <br>
                    <em>
                        <?php echo $l->t('This feature is not compatible with the <code>big menu</code> display.'); ?>
                        <br>
                        <?php p($l->t('The logo will be hidden when the menu is always displayed.')); ?>
                    </em>
                </div>
                <div class="side-menu-setting-form">
                    <select id="side-menu-display-logo" name="display-logo" class="side-menu-setting">
                        <?php foreach ($choicesYesNo as $label => $value): ?>
                            <option value="<?php echo $value ?>" <?php if ($value === $_['display-logo']): ?>selected<?php endif; ?>>
                                <?php echo $l->t($label);  ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="side-menu-setting-row">
                <div class="side-menu-setting-label">
                    <?php p($l->t('Use the avatar instead of the logo')); ?>
                </div>
                <div class="side-menu-setting-form">
                    <select id="side-menu-use-avatar" name="use-avatar" class="side-menu-setting">
                        <?php foreach ($choicesYesNo as $label => $value): ?>
                            <option value="<?php echo $value ?>" <?php if ($value === $_['use-avatar']): ?>selected<?php endif; ?>>
                                <?php echo $l->t($label);  ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="side-menu-setting-row">
                <div class="side-menu-setting-label">
                    <?php p($l->t('The logo is a link to the default app')); ?>
                </div>
                <div class="side-menu-setting-form">
                    <select id="side-menu-add-logo-link" name="add-logo-link" class="side-menu-setting">
                        <?php foreach ($choicesYesNo as $label => $value): ?>
                            <option value="<?php echo $value ?>" <?php if ($value === $_['add-logo-link']): ?>selected<?php endif; ?>>
                                <?php echo $l->t($label);  ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="side-menu-setting-row">
                <div class="side-menu-setting-label">
                    <?php p($l->t('Apps that should not be displayed in the menu')); ?>
                    <br>
                    <em><?php echo $l->t('This feature is only compatible with the <code>big menu</code> display.'); ?></em>
                </div>
                <div class="side-menu-setting-form">
                    <a class="side-menu-toggler" data-target="#big-menu-hidden-apps" href="#_">
                        🖱️ <?php p($l->t($labelShowHideApps)); ?>
                    </a>

                    <div class="side-menu-setting" data-name="big-menu-hidden-apps" id="big-menu-hidden-apps" data-checkbox style="display: none">
                        <ul class="side-menu-setting-list">
                            <?php foreach ($_['apps'] as $app): ?>
                                <li class="side-menu-setting-list-item">
                                    <input
                                        type="checkbox"
                                        name="big-menu-hidden-apps[]"
                                        value="<?php echo $app['id'] ?>"
                                        id="big-menu-hidden-app-<?php echo $app['id'] ?>"
                                        <?php if (in_array($app['id'], $_['big-menu-hidden-apps'])): ?>checked<?php endif; ?>
                                    />

                                    <label for="big-menu-hidden-app-<?php echo $app['id'] ?>">
                                        <?php echo p($l->t($app['name'])); ?>
                                    </label>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="side-menu-setting-row">
                <div class="side-menu-setting-label">
                    <?php p($l->t('Show the link to settings')); ?>
                </div>
                <div class="side-menu-setting-form">
                    <select id="side-menu-show-settings" name="show-settings" class="side-menu-setting">
                        <?php foreach ($choicesYesNo as $label => $value): ?>
                            <option value="<?php echo $value ?>" <?php if ($value === $_['show-settings']): ?>selected<?php endif; ?>>
                                <?php echo $l->t($label);  ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="side-menu-setting-row">
                <div class="side-menu-setting-label">
                    <?php p($l->t('Icons and texts')); ?>
                </div>
                <div class="side-menu-setting-form">
                    <select id="side-menu-size-icon" name="size-icon" class="side-menu-setting">
                        <?php foreach ($choicesSizes as $label => $value): ?>
                            <option value="<?php echo $value ?>" <?php if ($value === $_['size-icon']): ?>selected<?php endif; ?>>
                                <?php echo $l->t($label.' icon');  ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <select id="side-menu-size-text" name="size-text" class="side-menu-setting">
                        <?php foreach ($choicesSizes as $label => $value): ?>
                            <option value="<?php echo $value ?>" <?php if ($value === $_['size-text']): ?>selected<?php endif; ?>>
                                <?php echo $l->t($label.' text'); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="side-menu-setting-row">
                <div class="side-menu-setting-label">
                    <?php p($l->t('Open apps in new tab')); ?>
                </div>
                <div class="side-menu-setting-form">
                    <a class="side-menu-toggler" data-target="#target-blank-apps" href="#_">
                        🖱️ <?php p($l->t($labelShowHideApps)); ?>
                    </a>

                    <div class="side-menu-setting" data-name="target-blank-apps" id="target-blank-apps" data-checkbox style="display: none">
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

            <div class="side-menu-setting-row">
                <div class="side-menu-setting-label">
                    <?php p($l->t('Loader enabled')); ?>
                </div>
                <div class="side-menu-setting-form">
                    <select id="side-menu-loader-enabled" name="loader-enabled" class="side-menu-setting">
                        <?php foreach ($choicesYesNo as $label => $value): ?>
                            <option value="<?php echo $value ?>" <?php if ($value === $_['loader-enabled']): ?>selected<?php endif; ?>>
                                <?php echo $l->t($label);  ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
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
                </div>
                <div class="side-menu-setting-form">
                    <a class="side-menu-toggler" data-target="#top-menu-apps" href="#_">
                        🖱️ <?php p($l->t($labelShowHideApps)); ?>
                    </a>

                    <div class="side-menu-setting" data-name="top-menu-apps" id="top-menu-apps" data-checkbox style="display: none">
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
                                        <?php echo p($l->t($app['name'])); ?>
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
                </div>
                <div class="side-menu-setting-form">
                    <a class="side-menu-toggler" data-target="#top-side-menu-apps" href="#_">
                        🖱️ <?php p($l->t($labelShowHideApps)); ?>
                    </a>

                    <div class="side-menu-setting" data-name="top-side-menu-apps" id="top-side-menu-apps" data-checkbox style="display: none">
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
            <?php p($l->t('Categories')); ?>
        </h2>

        <div class="side-menu-setting-table">
            <div class="side-menu-setting-row">
                <?php
                    $choices = [
                        'Name' => 'default',
                        'Customed' => 'custom',
                    ];
                ?>
                <div class="side-menu-setting-label">
                    <?php p($l->t('Order by')); ?>
                </div>
                <div class="side-menu-setting-form">
                    <select id="side-menu-categories-order-type" name="categories-order-type" class="side-menu-setting">
                        <?php foreach ($choices as $label => $value): ?>
                            <option value="<?php echo $value ?>" <?php if ($value === $_['categories-order-type']): ?>selected<?php endif; ?>>
                                <?php echo $l->t($label);  ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="side-menu-setting-row">
                <div class="side-menu-setting-label">
                    <?php p($l->t('Custom categories')); ?>
                </div>
                <div class="side-menu-setting-form">
                    <input type="hidden" name="categories-custom" class="side-menu-setting" data-langs="<?php echo htmlentities(json_encode($langs)) ?>" value="<?php echo htmlentities(json_encode($_['categories-custom'])) ?>">

                    <div id="side-menu-categories-custom">
                    </div>
                </div>
            </div>

            <div class="side-menu-setting-row">
                <div class="side-menu-setting-label">
                    <?php p($l->t('Customize application categories')); ?>
                </div>
                <div class="side-menu-setting-form">
                    <a class="side-menu-toggler" data-target="#apps-categories-custom-list" href="#_">
                        🖱️ <?php p($l->t($labelShowHideApps)); ?>
                    </a>

                    <div id="apps-categories-custom-list" style="display: none">
                        <ul class="side-menu-setting-list">
                            <?php foreach ($_['apps'] as $app): ?>
                                <li class="side-menu-setting-list-item">
                                    <label for="apps-categories-custom-<?php echo $app['id'] ?>">
                                        <?php echo p($l->t($app['name'])); ?>
                                    </label>

                                    <br>

                                    <select data-app="<?php echo $app['id'] ?>" class="apps-categories-custom">
                                        <option value=""></option>

                                        <?php foreach ($_['categories'] as $id => $category): ?>
                                            <?php if ($category): ?>
                                                <option
                                                    value="<?php echo $id ?>"
                                                    <?php if (($_['apps-categories-custom'][$app['id']] ?? '') === $id): ?>
                                                        selected
                                                    <?php endif; ?>
                                                ><?php echo $category ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <input type="hidden" class="side-menu-setting" id="apps-categories-custom" name="apps-categories-custom" value="<?php echo htmlentities(json_encode($_['apps-categories-custom'])) ?>">
                </div>
            </div>

            <div class="side-menu-setting-row">
                <div class="side-menu-setting-label">
                    <?php p($l->t('Customize sorting')); ?>
                </div>
                <div class="side-menu-setting-form">
                    <a class="side-menu-toggler" data-target="#categories-list" href="#_">
                        🖱️ <?php p($l->t('Show and hide the list of categories')); ?>
                    </a>

                    <div id="categories-list" style="display: none">
                        <ul class="side-menu-setting-list">
                            <?php foreach ($_['categories'] as $key => $label): ?>
                                <li data-id="<?php echo $key; ?>" class="side-menu-setting-list-item">
                                    <span class="arrow">
                                        ⇅
                                    </span>

                                    <?php echo $label ? $l->t($label) : $l->t('Others'); ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <input type="hidden" value='<?php echo json_encode(array_keys($_['categories'])) ?>' name="categories-order" class="side-menu-setting">
                </div>
            </div>
        </div>
    </div>

    <div class="section">
        <h2>
            <?php p($l->t('Tips')); ?>
        </h2>

        <p>
            <em><?php echo $l->t('Use the shortcut <span class="keyboard-key">Ctrl</span>+<span class="keyboard-key">o</span> to open and to hide the side menu. Use <span class="keyboard-key">tab</span> to navigate.'); ?></em>
        </p>
    </div>

    <div class="section">
        <div class="side-menu-setting-table">
            <div class="side-menu-setting-row">
                <div class="side-menu-setting-label">
                    <?php p($l->t('The menu is enabled by default for users')); ?>
                    <br>
                    <em><?php p($l->t('Except when the configuration is forced.')); ?></em>
                </div>
                <div class="side-menu-setting-form">
                    <select id="side-menu-default-enabled" name="default-enabled" class="side-menu-setting">
                        <?php foreach ($choicesYesNo as $label => $value): ?>
                            <option value="<?php echo $value ?>" <?php if ($value === $_['default-enabled']): ?>selected<?php endif; ?>>
                                <?php echo $l->t($label);  ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="side-menu-setting-row">
                <div class="side-menu-setting-label">
                    <?php p($l->t('Force this configuration to users')); ?>
                </div>
                <div class="side-menu-setting-form">
                    <select id="side-menu-force" name="force" class="side-menu-setting">
                        <?php foreach ($choicesYesNo as $label => $value): ?>
                            <option value="<?php echo $value ?>" <?php if ($value === $_['force']): ?>selected<?php endif; ?>>
                                <?php echo $l->t($label);  ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>

        <input type="hidden" id="side-menu-cache" name="cache" value="<?php print_unescaped($_['cache']); ?>" class="side-menu-setting">
    </div>

    <div class="section" id="more">
        <button id="side-menu-save" class="btn btn-info">
            <?php p($l->t('Save')); ?>
            <progress max="100" value="0" id="side-menu-save-progress"></progress>
        </button>

        <a href="<?php echo $urlGenerator->linkToRoute('side_menu.AdminSetting.exportConfiguration') ?>" target="_blank" rel="noopener">
            <button class="btn btn-primary" >
                <?php p($l->t('Export the configuration')); ?>
            </button>
        </a>

        <a href="<?php echo $urlGenerator->linkToRoute('side_menu.AdminSetting.removeCache') ?>">
            <button class="btn btn-primary" >
                <?php p($l->t('Purge the cache')); ?> (<?php echo $cacheSize ?> Kb)
            </button>
        </a>

        <div style="height: 30px"></div>

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
