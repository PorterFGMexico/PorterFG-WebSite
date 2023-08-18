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
use OC\App\AppStore\Fetcher\CategoryFetcher;
use OC\URLGenerator;
use OCA\SideMenu\Service\AppRepository;
use OCA\SideMenu\Service\CategoryRepository;
use OCA\SideMenu\Service\ConfigProxy;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\JSONResponse;
use OCP\IRequest;
use OCP\IUserSession;
use OCP\L10N\IFactory;

class NavController extends Controller
{
    /**
     * @var ConfigProxy
     */
    protected $config;

    /**
     * @var AppRepository
     */
    protected $appRepository;

    /**
     * @var IFactory
     */
    protected $l10nFactory;

    /**
     * @var CategoryFetcher
     */
    protected $categoryFetcher;

    /**
     * @var URLGenerator
     */
    protected $router;

    public function __construct(
        string $appName,
        IRequest $request,
        ConfigProxy $config,
        AppRepository $appRepository,
        CategoryRepository $categoryRepository,
        URLGenerator $router,
        IFactory $l10nFactory
    ) {
        parent::__construct($appName, $request);

        $this->config = $config;
        $this->appRepository = $appRepository;
        $this->categoryRepository = $categoryRepository;
        $this->l10nFactory = $l10nFactory;
        $this->router = $router;
    }

    /**
     * @NoAdminRequired
     * @NoCSRFRequired
     * @PublicPage
     *
     * @return JSONResponse
     */
    public function items()
    {
        $user = OC::$server[IUserSession::class]->getUser();
        $items = [];

        if (!$user) {
            return new JSONResponse([
                'items' => $items,
            ]);
        }

        $apps = $this->appRepository->getVisibleApps();
        $categoriesLabels = $this->categoryRepository->getOrderedCategories();
        $hiddenApps = $this->config->getAppValueArray('big-menu-hidden-apps', '[]');
        $isForced = $this->config->getAppValueBool('force', '0');
        $topMenuApps = $this->config->getAppValueArray('top-menu-apps', '[]');
        $userTopMenuApps = $this->config->getUserValueArray($user, 'top-menu-apps', '[]');
        $appsCategories = [];
        $categoriesAppsCount = [];

        if (!$isForced && !empty($userTopMenuApps)) {
            $topMenuApps = $userTopMenuApps;
        }

        foreach ($apps as $app) {
            if (in_array($app['id'], $topMenuApps)) {
                continue;
            }

            if (in_array($app['id'], $hiddenApps)) {
                continue;
            }

            $categories = (array) $app['category'];
            $appsCategories[$app['id']] = [];

            if (empty($categories)) {
                $categories = ['other'];
            }

            foreach ($categories as $category) {
                if (!isset($items[$category])) {
                    $items[$category] = [
                        'name' => $categoriesLabels[$category] ?? $category,
                        'categoryId' => $category,
                        'apps' => [],
                    ];
                }

                if (!isset($categoriesAppsCount[$category])) {
                    $categoriesAppsCount[$category] = 0;
                }

                ++$categoriesAppsCount[$category];

                $appsCategories[$app['id']][] = $category;

                $items[$category]['apps'][$app['id']] = [
                    'name' => $app['name'],
                    'href' => $app['href'],
                    'icon' => $app['icon'],
                ];
            }
        }

        arsort($categoriesAppsCount);

        $keys = array_keys($categoriesAppsCount);

        foreach ($appsCategories as $app => $appCategories) {
            $smallerIndex = count($categoriesAppsCount) - 1;

            foreach ($appCategories as $appCategory) {
                $appKey = array_keys($keys, $appCategory)[0];

                if ($appKey < $smallerIndex) {
                    $smallerIndex = $appKey;
                }
            }

            $category = $keys[$smallerIndex];

            foreach ($items as $itemCategory => $value) {
                if ($itemCategory !== $category && isset($value['apps'][$app])) {
                    unset($items[$itemCategory]['apps'][$app]);

                    if (empty($items[$itemCategory]['apps'])) {
                        unset($items[$itemCategory]);
                    }
                }
            }
        }

        foreach ($items as $category => $value) {
            if (empty($items[$category]['apps'])) {
                unset($items[$category]);
            } else {
                uasort($items[$category]['apps'], function ($a, $b) {
                    return ($a['name'] < $b['name']) ? -1 : 1;
                });
            }
        }

        usort($items, function ($a, $b) use ($categoriesLabels) {
            foreach ($categoriesLabels as $key => $value) {
                if ($a['categoryId'] === 'other') {
                    return -1;
                }

                if ($b['categoryId'] === 'other') {
                    return 1;
                }

                if ($a['categoryId'] === $key) {
                    return -1;
                }

                if ($b['categoryId'] === $key) {
                    return 1;
                }
            }

            return 0;
        });

        return new JSONResponse([
            'items' => $items,
        ]);
    }
}
