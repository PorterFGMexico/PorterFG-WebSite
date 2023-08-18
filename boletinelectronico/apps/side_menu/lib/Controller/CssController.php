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

namespace OCA\SideMenu\Controller;

use OC;
use OC\User\User;
use OCA\SideMenu\AppInfo\Application;
use OCA\SideMenu\Service\ConfigProxy;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\Response;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\IRequest;
use OCP\IUserSession;
use OCA\Theming\ThemingDefaults;
use OCA\SideMenu\Service\Color;

class CssController extends Controller
{
    /**
     * @var ConfigProxy
     */
    protected $config;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var ThemingDefaults
     */
    protected $theming;

    /**
     * @var Color
     */
    protected $color;

    public function __construct(
        string $appName,
        IRequest $request,
        ConfigProxy $config,
        ThemingDefaults $theming,
        Color $color
    )
    {
        parent::__construct($appName, $request);

        $this->user = OC::$server[IUserSession::class]->getUser();
        $this->config = $config;
        $this->theming = $theming;
        $this->color = $color;
    }

    /**
     * @NoAdminRequired
     * @NoCSRFRequired
     * @PublicPage
     *
     * @return Response
     */
    public function stylesheet()
    {
        $response = new TemplateResponse(Application::APP_ID, 'css/stylesheet', $this->getConfig(), 'blank');
        $response->addHeader('Content-Type', 'text/css');

        return $response;
    }

    protected function getConfig(): array
    {
        $isForced = $this->config->getAppValueBool('force', '0');
        $topMenuApps = $this->config->getAppValueArray('top-menu-apps', '[]');
        $topSideMenuApps = $this->config->getAppValueArray('top-side-menu-apps', '[]');

        $isAccessibilityAppEnabled = $this->config->getAppValueBool('enabled', '0', 'accessibility');
        $isBreezeDarkAppEnabled = $this->config->getAppValueBool('enabled', '0', 'breezedark');
        $isBreezeDarkGlobalEnabled = $this->config->getAppValueBool('theme_enabled', '0', 'breezedark');

        if ($this->user) {
            $userTopMenuApps = $this->config->getUserValueArray($this->user, 'top-menu-apps', '[]');
            $userTopSideMenuApps = $this->config->getUserValueArray($this->user, 'top-side-menu-apps', '[]');

            if (!empty($userTopMenuApps) && !$isForced) {
                $topMenuApps = $userTopMenuApps;
            }

            if (!empty($userTopSideMenuApps) && !$isForced) {
                $topSideMenuApps = $userTopSideMenuApps;
            }

            $isDarkThemeUserEnabled = $this->config->getUserValue($this->user, 'theme', '', 'accessibility') === 'dark';
            $isBreezeDarkUserEnabled = $this->config->getUserValue($this->user, 'theme_enabled', '', 'breezedark');

            $isBreezeDarkUserEnabled = $isBreezeDarkUserEnabled === '1' || ($isBreezeDarkGlobalEnabled && $isBreezeDarkUserEnabled === '');
        } else {
            $isDarkThemeUserEnabled = false;
            $isBreezeDarkUserEnabled = false;
        }

        $isDarkMode = ($isAccessibilityAppEnabled && $isDarkThemeUserEnabled) || ($isBreezeDarkAppEnabled && $isBreezeDarkUserEnabled);

        $primaryColor = $this->theming->getColorPrimary();
        $lightenPrimaryColor = $this->color->adjustBrightness($primaryColor, 0.2);
        $darkenPrimaryColor = $this->color->adjustBrightness($primaryColor, -0.2);
        $darkenPrimaryColor2 = $this->color->adjustBrightness($primaryColor, -0.3);
        $textColor = $this->theming->getTextColorPrimary();

        if ($isDarkMode) {
            $backgroundColor = $this->config->getAppValue('dark-mode-background-color', $darkenPrimaryColor);
            $backgroundColorTo = $this->config->getAppValue('dark-mode-background-color-to', $darkenPrimaryColor);
            $currentAppBackgroundColor = $this->config->getAppValue('dark-mode-current-app-background-color', $darkenPrimaryColor2);
            $loaderColor = $this->config->getAppValue('dark-mode-loader-color', $lightenPrimaryColor);
            $textColor = $this->config->getAppValue('dark-mode-text-color', $textColor);
            $iconInvertFilter = abs($this->config->getAppValueInt('dark-mode-icon-invert-filter', '0')).'%';
            $iconOpacity = abs($this->config->getAppValueInt('dark-mode-icon-opacity', '100') / 100);
            $opener = $this->config->getAppValue('dark-mode-opener', 'side-menu-opener');

            $backgroundOpacity = dechex($this->config->getAppValueInt('dark-mode-background-color-opacity', '100') * 255 / 100);
        } else {
            $backgroundColor = $this->config->getAppValue('background-color', $darkenPrimaryColor);
            $backgroundColorTo = $this->config->getAppValue('background-color-to', $darkenPrimaryColor);
            $currentAppBackgroundColor = $this->config->getAppValue('current-app-background-color', $darkenPrimaryColor2);
            $loaderColor = $this->config->getAppValue('loader-color', $lightenPrimaryColor);
            $textColor = $this->config->getAppValue('text-color', $textColor);
            $iconInvertFilter = abs($this->config->getAppValueInt('icon-invert-filter', '0')).'%';
            $iconOpacity = abs($this->config->getAppValueInt('icon-opacity', '100') / 100);
            $opener = $this->config->getAppValue('opener', 'side-menu-opener');

            $backgroundOpacity = dechex($this->config->getAppValueInt('background-color-opacity', '100') * 255 / 100);
        }

        $backgroundColor .= $backgroundOpacity;
        $backgroundColorTo .= $backgroundOpacity;

        return [
            'vars' => [
                'background-color' => $backgroundColor,
                'background-color-to' => $backgroundColorTo,
                'current-app-background-color' => $currentAppBackgroundColor,
                'loader-color' => $loaderColor,
                'text-color' => $textColor,
                'opener' => $opener,
                'icon-invert-filter' => $iconInvertFilter,
                'icon-opacity' => $iconOpacity,
            ],
            'display-logo' => $this->config->getAppValueBool('display-logo', '1'),
            'opener-only' => $this->config->getAppValueBool('opener-only', '0'),
            'external-sites-in-top-menu' => $this->config->getAppValueBool('external-sites-in-top-menu', '0'),
            'size-icon' => $this->config->getAppValue('size-icon', 'normal'),
            'size-text' => $this->config->getAppValue('size-text', 'normal'),
            'always-displayed' => $this->config->getAppValueBool('always-displayed', '0'),
            'big-menu' => $this->config->getAppValueBool('big-menu', '0'),
            'top-menu-apps' => $topMenuApps,
            'top-side-menu-apps' => $topSideMenuApps,
        ];
    }
}
