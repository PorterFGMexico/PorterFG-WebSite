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
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\DataDownloadResponse;
use OCP\AppFramework\Http\RedirectResponse;
use OCP\AppFramework\Http\Response;
use OCP\IConfig;
use OCP\IRequest;
use OCP\IURLGenerator;

class AdminSettingController extends Controller
{
    /**
     * @var IConfig
     */
    protected $config;

    /**
     * @var IURLGenerator
     */
    protected $urlGenerator;

    public function __construct($appName, IRequest $request, IConfig $config, IURLGenerator $urlGenerator)
    {
        parent::__construct($appName, $request);

        $this->config = $config;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @NoCSRFRequired
     *
     * @return RedirectResponse
     */
    public function removeCache()
    {
        $this->config->setAppValue(Application::APP_ID, 'cache-categories', '[]');

        return new RedirectResponse($this->urlGenerator->linkToRoute('settings.AdminSettings.index', [
            'section' => Application::APP_ID,
        ]).'#more');
    }

    /**
     * @NoCSRFRequired
     *
     * @return Response
     */
    public function exportConfiguration()
    {
        $keys = $this->config->getAppKeys(Application::APP_ID);
        $appConfig = [];
        $excludedKeys = [
            'cache',
            'cache-categories',
        ];

        foreach ($keys as $key) {
            if (in_array($key, $excludedKeys)) {
                continue;
            }

            $appConfig[$key] = $this->config->getAppValue(Application::APP_ID, $key);
        }

        return new DataDownloadResponse(
            json_encode($appConfig, JSON_PRETTY_PRINT),
            'config.json',
            'text/json'
        );
    }
}
