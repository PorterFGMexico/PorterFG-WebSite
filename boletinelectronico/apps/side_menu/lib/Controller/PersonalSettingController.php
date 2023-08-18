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

use OCA\SideMenu\AppInfo\Application;
use OCA\SideMenu\Service\ConfigProxy;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\Response;
use OCP\IConfig;
use OCP\IRequest;
use OCP\IUserSession;

class PersonalSettingController extends Controller
{
    /**
     * @var IConfig
     */
    protected $config;

    /**
     * @var ConfigProxy
     */
    protected $configProxy;

    /**
     * @var IUserSession
     */
    protected $userSession;

    public function __construct($appName, IRequest $request, IConfig $config, ConfigProxy $configProxy, IUserSession $userSession)
    {
        parent::__construct($appName, $request);

        $this->config = $config;
        $this->configProxy = $configProxy;
        $this->userSession = $userSession;
    }

    /**
     * @NoAdminRequired
     * @NoCSRFRequired
     *
     * @param mixed $name
     * @param mixed $value
     *
     * @return Response
     */
    public function valueSet($name, $value)
    {
        $doSave = false;
        $user = $this->userSession->getUser();

        if ('enabled' === $name) {
            $doSave = true;

            if (!in_array($value, ['0', '1'])) {
                $value = '1';
            }
        }

        if ('target-blank-mode' === $name) {
            $doSave = true;

            if (!in_array($value, ['1', '2'])) {
                $value = '1';
            }
        }

        if ('target-blank-apps' === $name) {
            $doSave = true;
            $data = json_decode($value, true);

            if (!is_array($data)) {
                $doSave = false;
            } else {
                foreach ($data as $v) {
                    if (!is_string($v)) {
                        $doSave = false;
                    }
                }
            }
        }

        if (in_array($name, ['top-menu-apps', 'top-side-menu-apps'])) {
            $doSave = true;
            $data = json_decode($value, true);

            if (!is_array($data)) {
                $doSave = false;
            } else {
                foreach ($data as $v) {
                    if (!is_string($v)) {
                        $doSave = false;
                    }
                }
            }
        }

        if ($this->configProxy->getAppValueBool('force', '0')) {
            $doSave = false;
        }

        if ($doSave) {
            $this->config->setUserValue($user->getUid(), Application::APP_ID, $name, $value);

            return [
                'name' => $name,
                'value' => $value,
            ];
        }

        return [];
    }
}
