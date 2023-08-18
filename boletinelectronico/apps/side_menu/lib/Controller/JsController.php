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
use OCA\Theming\ThemingDefaults;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\JSONResponse;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\IRequest;
use OCP\IUserSession;
use OCP\L10N\IFactory;

class JsController extends Controller
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
    protected $themingDefaults;

    /**
     * @var IFactory
     */
    protected $l10nFactory;

    public function __construct(
        string $appName,
        IRequest $request,
        ConfigProxy $config,
        ThemingDefaults $themingDefaults,
        IFactory $l10nFactory
    ) {
        parent::__construct($appName, $request);

        $this->themingDefaults = $themingDefaults;

        $this->user = OC::$server[IUserSession::class]->getUser();
        $this->config = $config;
        $this->l10nFactory = $l10nFactory;
    }

    /**
     * @NoAdminRequired
     * @NoCSRFRequired
     * @PublicPage
     */
    public function script(): TemplateResponse
    {
        $response = new TemplateResponse(Application::APP_ID, 'js/script', $this->getConfig(), 'blank');
        $response->addHeader('Content-Type', 'text/javascript');

        return $response;
    }

    /**
     * @NoAdminRequired
     * @NoCSRFRequired
     * @PublicPage
     */
    public function config(): JSONResponse
    {
        return new JSONResponse($this->getConfig());
    }

    protected function getConfig(): array
    {
        $topMenuApps = $this->config->getAppValueArray('top-menu-apps', '[]');
        $topSideMenuApps = $this->config->getAppValueArray('top-side-menu-apps', '[]');
        $targetBlankApps = $this->config->getAppValueArray('target-blank-apps', '[]');
        $useAvatar = $this->config->getAppValueBool('use-avatar', '0');
        $isForced = $this->config->getAppValueBool('force', '0');
        $addLogoLink = $this->config->getAppValueBool('add-logo-link', '1');
        $avatar = null;
        $settings = null;

        if ($this->user) {
            $userTopMenuApps = $this->config->getUserValueArray($this->user, 'top-menu-apps', '[]');
            $userTopSideMenuApps = $this->config->getUserValueArray($this->user, 'top-side-menu-apps', '[]');

            if (!empty($userTopMenuApps) && !$isForced) {
                $topMenuApps = $userTopMenuApps;
            }

            if (!empty($userTopSideMenuApps) && !$isForced) {
                $topSideMenuApps = $userTopSideMenuApps;
            }

            $userTargetBlankMode = $this->config->getUserValueInt($this->user, 'target-blank-mode', '1');
            $userTargetBlankApps = $this->config->getUserValueArray($this->user, 'target-blank-apps', '[]');

            if (2 === $userTargetBlankMode && !$isForced) {
                $targetBlankApps = $userTargetBlankApps;
            }

            $isAvatarSet = OC::$server->getAvatarManager()->getAvatar($this->user->getUid())->exists();

            if ($useAvatar && $isAvatarSet) {
                $avatar = OC::$server->getURLGenerator()->linkToRoute('core.avatar.getAvatar', [
                    'userId' => $this->user->getUid(),
                    'size' => 128,
                    'v' => $this->config->getUserValueInt($this->user, 'avatar', 'version', 0),
                ]);
            }

            if ($this->config->getAppValueBool('show-settings', '0')) {
                $settingsNav = OC::$server->getNavigationManager()->getAll('settings');

                if (isset($settingsNav['settings'])) {
                    $settings = [
                        'href' => $settingsNav['settings']['href'],
                        'name' => $settingsNav['settings']['name'],
                        'avatar' => OC::$server->getURLGenerator()->linkToRoute('core.avatar.getAvatar', [
                            'userId' => $this->user->getUid(),
                            'size' => 32,
                            'v' => $this->config->getUserValueInt($this->user, 'avatar', 'version', 0),
                        ]),
                    ];
                }
            }
        }

        $indexUrl = OC::$server->getURLGenerator()->linkTo('', 'index.php');

        return [
            'opener-position' => $this->config->getAppValue('opener-position', 'before'),
            'opener-hover' => $this->config->getAppValueBool('opener-hover', '0'),
            'external-sites-in-top-menu' => $this->config->getAppValueBool('external-sites-in-top-menu', '0'),
            'force-light-icon' => $this->config->getAppValueBool('force-light-icon', '0'),
            'hide-when-no-apps' => $this->config->getAppValueBool('hide-when-no-apps', '0'),
            'loader-enabled' => $this->config->getAppValueBool('loader-enabled', '1'),
            'always-displayed' => $this->config->getAppValueBool('always-displayed', '0'),
            'side-with-categories' => $this->config->getAppValueBool('side-with-categories', '0'),
            'big-menu' => $this->config->getAppValueBool('big-menu', '0'),
            'big-menu-hidden-apps' => $this->config->getAppValueArray('big-menu-hidden-apps', '[]'),
            'avatar' => $avatar,
            'top-menu-apps' => $topMenuApps,
            'top-side-menu-apps' => $topSideMenuApps,
            'target-blank-apps' => $targetBlankApps,
            'settings' => $settings,
            'logo' => $this->themingDefaults->getLogo(),
            'logo-link' => $addLogoLink ? $indexUrl : null,
        ];
    }
}
