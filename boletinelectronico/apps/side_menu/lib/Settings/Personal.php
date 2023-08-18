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
use OCA\SideMenu\Service\ConfigProxy;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\IL10N;
use OCP\ILogger;
use OCP\IUserSession;
use OCP\Settings\ISettings;

class Personal implements ISettings
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
     * @var IUserSession
     */
    private $userSession;

    /**
     * @var AppRepository
     */
    private $appRepository;

    public function __construct(IL10N $l, ILogger $logger, ConfigProxy $config, IUserSession $userSession, AppRepository $appRepository)
    {
        $this->l = $l;
        $this->logger = $logger;
        $this->config = $config;
        $this->userSession = $userSession;
        $this->appRepository = $appRepository;
    }

    /**
     * @return TemplateResponse
     */
    public function getForm()
    {
        $user = $this->userSession->getUser();

        $parameters = [
            'force' => $this->config->getAppValueBool('force', '0'),
            'enabled' => $this->config->getUserValue(
                $user,
                'enabled',
                $this->config->getAppValue('default-enabled', '1')
            ),
            'top-menu-apps' => $this->config->getUserValueArray($user, 'top-menu-apps', '[]'),
            'top-side-menu-apps' => $this->config->getUserValueArray($user, 'top-side-menu-apps', '[]'),
            'target-blank-mode' => $this->config->getUserValue($user, 'target-blank-mode', '1'),
            'target-blank-apps' => $this->config->getUserValueArray($user, 'target-blank-apps', '[]'),
            'apps' => $this->appRepository->getVisibleApps(),
        ];

        return new TemplateResponse(Application::APP_ID, 'settings/personal-form', $parameters, '');
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
