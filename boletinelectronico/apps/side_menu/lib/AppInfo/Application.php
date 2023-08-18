<?php

namespace OCA\SideMenu\AppInfo;

use OC;
use OC\Security\CSP\ContentSecurityPolicyNonceManager;
use OC\User\User;
use OCA\SideMenu\Service\AppRepository;
use OCA\SideMenu\Service\CategoryRepository;
use OCA\SideMenu\Service\ConfigProxy;
use OCP\AppFramework\App;
use OCP\AppFramework\Bootstrap\IBootContext;
use OCP\AppFramework\Bootstrap\IBootstrap;
use OCP\AppFramework\Bootstrap\IRegistrationContext;
use OCP\IUserSession;
use OCP\Util;
use Psr\Container\ContainerInterface;

/**
 * class Application.
 *
 * @author Simon Vieille <simon@deblan.fr>
 */
class Application extends App implements IBootstrap
{
    public const APP_ID = 'side_menu';

    public const APP_NAME = 'Custom menu';
    /**
     * @var OC\AllConfig
     */
    protected $config;

    /**
     * @var ContentSecurityPolicyNonceManager
     */
    protected $cspnm;

    /**
     * @var User
     */
    protected $user;

    /**
     * {@inheritdoc}
     */
    public function __construct(array $urlParams = [])
    {
        parent::__construct(self::APP_ID, $urlParams);
    }

    protected function isEnabled(): bool
    {
        $enabled = true;
        $isForced = (bool) $this->config->getAppValue(self::APP_ID, 'force', '0');

        if (null !== $this->user && !$isForced) {
            $enabled = (bool) $this->config->getUserValue(
                $this->user->getUid(),
                self::APP_ID,
                'enabled',
                $this->config->getAppValue(
                    self::APP_ID,
                    'default-enabled',
                    '1'
                )
            );
        }

        return $enabled;
    }

    protected function addAssets()
    {
        Util::addScript(self::APP_ID, 'sideMenu');
        Util::addStyle(self::APP_ID, 'sideMenu');

        $assets = [
            'stylesheet' => [
                'route' => 'side_menu.Css.stylesheet',
                'type' => 'link',
                'route_attr' => 'href',
                'attr' => [
                    'rel' => 'stylesheet',
                ],
            ],
            'script' => [
                'route' => 'side_menu.Js.script',
                'type' => 'script',
                'route_attr' => 'src',
                'attr' => [
                    'nonce' => $this->cspnm->getNonce(),
                ],
            ],
        ];

        $cache = $this->config->getAppValue(self::APP_ID, 'cache', '0');

        foreach ($assets as $value) {
            $route = OC::$server->getURLGenerator()->linkToRoute($value['route'], ['v' => $cache]);
            $value['attr'][$value['route_attr']] = $route;

            Util::addHeader($value['type'], $value['attr'], '');
        }
    }

    public function register(IRegistrationContext $context): void
    {
        $context->registerService('AppRepository', function () {
            return new AppRepository();
        });

        $context->registerService('CategoryRepository', function () {
            return new CategoryRepository();
        });

        $context->registerService('ConfigProxy', function () {
            return new ConfigProxy();
        });
    }

    public function boot(IBootContext $context): void
    {
        $this->config = OC::$server->getConfig();
        $this->cspnm = OC::$server->getContentSecurityPolicyNonceManager();
        $this->user = OC::$server[IUserSession::class]->getUser();

        if (!$this->isEnabled()) {
            return;
        }

        $this->addAssets();
    }
}
