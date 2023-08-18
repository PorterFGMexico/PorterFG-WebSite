<?php

namespace OCA\SideMenu\Service;

use OCP\L10N\IFactory;

/**
 * class AppRepository.
 *
 * @author Simon Vieille <simon@deblan.fr>
 */
class AppRepository
{
    /**
     * @var \OC_App
     */
    protected $ocApp;

    /**
     * @var IFactory
     */
    protected $l10nFactory;

    /**
     * @var ConfigProxy
     */
    protected $config;

    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;

    public function __construct(
        \OC_App $ocApp,
        IFactory $l10nFactory,
        ConfigProxy $config,
        CategoryRepository $categoryRepository
    )
    {
        $this->ocApp = $ocApp;
        $this->l10nFactory = $l10nFactory;
        $this->config = $config;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Retrieves visibles apps.
     *
     * @return array
     */
    public function getVisibleApps()
    {
        $navigation = $this->ocApp->getNavigation();
        $appCategoriesCustom = $this->config->getAppValueArray('apps-categories-custom', '[]');
        $categories = $this->categoryRepository->getOrderedCategories();
        $apps = $this->ocApp->listAllApps();
        $visibleApps = [];

        foreach ($apps as $app) {
            $id = $app['id'];

            foreach ([$app['id'], $app['id'].'_index'] as $id) {
                if (isset($navigation[$id])) {
                    $app['name'] = $this->l10nFactory->get($id)->t($app['name']);
                    $app['href'] = $navigation[$id]['href'];
                    $app['icon'] = $navigation[$id]['icon'];

                    $visibleApps[$id] = $app;
                }
            }
        }

        foreach ($navigation as $app) {
            if ('external_index' === substr($app['id'], 0, 14)) {
                $visibleApps[$app['id']] = [
                    'id' => $app['id'],
                    'name' => $this->l10nFactory->get($app['id'])->t($app['name']),
                    'href' => $app['href'],
                    'icon' => $app['icon'],
                    'category' => [
                        'external_links',
                    ],
                ];
            } elseif ('files' === $app['id']) {
                $visibleApps[$app['id']] = [
                    'id' => $app['id'],
                    'name' => $this->l10nFactory->get($app['id'])->t($app['name']),
                    'href' => $app['href'],
                    'icon' => $app['icon'],
                    'category' => [],
                ];
            }
        }

        foreach ($visibleApps as $id => $app) {
            if (isset($appCategoriesCustom[$id], $categories[$appCategoriesCustom[$id]])) {
                $visibleApps[$id]['category'] = [$appCategoriesCustom[$id]];
            }
        }

        usort($visibleApps, function ($a, $b) {
            return ($a['name'] < $b['name']) ? -1 : 1;
        });

        return $visibleApps;
    }
}
