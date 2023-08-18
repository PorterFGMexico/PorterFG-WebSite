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

namespace OCA\SideMenu\Settings;

use OCA\SideMenu\AppInfo\Application;
use OCA\SideMenu\Service\AppRepository;
use OCA\SideMenu\Service\CategoryRepository;
use OCA\SideMenu\Service\ConfigProxy;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\IL10N;
use OCP\ILogger;
use OCP\Settings\ISettings;
use OCA\Theming\ThemingDefaults;
use OCA\SideMenu\Service\Color;
use OCA\SideMenu\Service\LangRepository;

class Admin implements ISettings
{
    /**
     * @var IL10N
     */
    private $l;

    /**
     * @var ILogger
     */
    private $logger;

    /**
     * @var ConfigProxy
     */
    private $config;

    /**
     * @var AppRepository
     */
    private $appRepository;

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * @var ThemingDefaults
     */
    protected $theming;

    /**
     * @var Color
     */
    protected $color;

    /**
     * @var LangRepository
     */
    protected $langRepository;

    public function __construct(
        IL10N $l,
        ILogger $logger,
        ConfigProxy $config,
        AppRepository $appRepository,
        CategoryRepository $categoryRepository,
        ThemingDefaults $theming,
        Color $color,
        LangRepository $langRepository
    ) {
        $this->l = $l;
        $this->logger = $logger;
        $this->config = $config;
        $this->appRepository = $appRepository;
        $this->categoryRepository = $categoryRepository;
        $this->theming = $theming;
        $this->color = $color;
        $this->langRepository = $langRepository;
    }

    /**
     * @return TemplateResponse
     */
    public function getForm()
    {
        $primaryColor = $this->theming->getColorPrimary();
        $lightenPrimaryColor = $this->color->adjustBrightness($primaryColor, 0.2);
        $darkenPrimaryColor = $this->color->adjustBrightness($primaryColor, -0.2);
        $darkenPrimaryColor2 = $this->color->adjustBrightness($primaryColor, -0.3);
        $textColor = $this->theming->getTextColorPrimary();

        $backgroundColor = $this->config->getAppValue('background-color', $darkenPrimaryColor);
        $backgroundColorTo = $this->config->getAppValue('background-color-to', $darkenPrimaryColor);

        $darkModeBackgroundColor = $this->config->getAppValue('dark-mode-background-color', $darkenPrimaryColor);
        $darkModeBackgroundColorTo = $this->config->getAppValue('dark-mode-background-color-to', $darkenPrimaryColor);

        $parameters = [
            'defaults' => [
                'background-color' => $darkenPrimaryColor,
                'background-color-to' => $darkenPrimaryColor,
                'current-app-background-color' => $darkenPrimaryColor2,
                'text-color' => $textColor,
                'loader-color' => $lightenPrimaryColor,
                'dark-mode-background-color' => $darkenPrimaryColor,
                'dark-mode-background-color-to' => $darkenPrimaryColor,
                'dark-mode-current-app-background-color' => $darkenPrimaryColor2,
                'dark-mode-text-color' => $textColor,
                'dark-mode-loader-color' => $textColor,
            ],
            'background-color' => $backgroundColor,
            'background-color-to' => $backgroundColorTo,
            'background-color-opacity' => $this->config->getAppValueInt('background-color-opacity', '100'),
            'current-app-background-color' => $this->config->getAppValue('current-app-background-color', $darkenPrimaryColor2),
            'loader-color' => $this->config->getAppValue('loader-color', $lightenPrimaryColor),
            'icon-invert-filter' => $this->config->getAppValueInt('icon-invert-filter', '0'),
            'icon-opacity' => $this->config->getAppValueInt('icon-opacity', '100'),
            'text-color' => $this->config->getAppValue('text-color', $textColor),
            'dark-mode-background-color' => $darkModeBackgroundColor,
            'dark-mode-background-color-to' => $darkModeBackgroundColorTo,
            'dark-mode-background-color-opacity' => $this->config->getAppValueInt('dark-mode-background-color-opacity', '100'),
            'dark-mode-current-app-background-color' => $this->config->getAppValue('dark-mode-current-app-background-color', $darkenPrimaryColor2),
            'dark-mode-loader-color' => $this->config->getAppValue('dark-mode-loader-color', $textColor),
            'dark-mode-icon-invert-filter' => $this->config->getAppValueInt('dark-mode-icon-invert-filter', '0'),
            'dark-mode-icon-opacity' => $this->config->getAppValueInt('dark-mode-icon-opacity', '100'),
            'dark-mode-text-color' => $this->config->getAppValue('dark-mode-text-color', $textColor),
            'dark-mode-opener' => $this->config->getAppValue('dark-mode-opener', 'side-menu-opener'),
            'opener' => $this->config->getAppValue('opener', 'side-menu-opener'),
            'loader-enabled' => $this->config->getAppValue('loader-enabled', '1'),
            'cache' => $this->config->getAppValue('cache', '0'),
            'always-displayed' => $this->config->getAppValue('always-displayed', '0'),
            'big-menu' => $this->config->getAppValue('big-menu', '0'),
            'side-with-categories' => $this->config->getAppValue('side-with-categories', '0'),
            'big-menu-hidden-apps' => $this->config->getAppValueArray('big-menu-hidden-apps', '[]'),
            'display-logo' => $this->config->getAppValue('display-logo', '1'),
            'add-logo-link' => $this->config->getAppValue('add-logo-link', '1'),
            'use-avatar' => $this->config->getAppValue('use-avatar', '0'),
            'opener-position' => $this->config->getAppValue('opener-position', 'before'),
            'opener-hover' => $this->config->getAppValue('opener-hover', '0'),
            'opener-only' => $this->config->getAppValue('opener-only', '0'),
            'show-settings' => $this->config->getAppValue('show-settings', '0'),
            'hide-when-no-apps' => $this->config->getAppValue('hide-when-no-apps', '0'),
            'size-icon' => $this->config->getAppValue('size-icon', 'normal'),
            'size-text' => $this->config->getAppValue('size-text', 'normal'),
            'force' => $this->config->getAppValue('force', '0'),
            'target-blank-apps' => $this->config->getAppValueArray('target-blank-apps', '[]'),
            'top-menu-apps' => $this->config->getAppValueArray('top-menu-apps', '[]'),
            'top-side-menu-apps' => $this->config->getAppValueArray('top-side-menu-apps', '[]'),
            'default-enabled' => $this->config->getAppValue('default-enabled', '1'),
            'apps' => $this->appRepository->getVisibleApps(),
            'apps-categories-custom' => $this->config->getAppValueArray('apps-categories-custom', '[]'),
            'categories-order-type' => $this->config->getAppValue('categories-order-type', 'default'),
            'categories-order' => $this->config->getAppValueArray('categories-order', '[]'),
            'categories-custom' => $this->config->getAppValueArray('categories-custom', '[]'),
            'categories' => $this->categoryRepository->getOrderedCategories(),
            'langs' => $this->langRepository->getUsedLangs(),
        ];

        return new TemplateResponse(Application::APP_ID, 'settings/admin-form', $parameters, '');
    }

    /**
     * @return string the section ID, e.g. 'sharing'
     */
    public function getSection()
    {
        return Application::APP_ID;
    }

    /**
     * @return int whether the form should be rather on the top or bottom of
     *             the admin section. The forms are arranged in ascending order of the
     *             priority values. It is required to return a value between 0 and 100.
     *
     * E.g.: 70
     */
    public function getPriority()
    {
        return 70;
    }
}
