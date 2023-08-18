<?php

namespace OCA\SideMenu\Service;

use OC\User\User;
use OCA\SideMenu\AppInfo\Application;
use OCP\IConfig;

/**
 * class Config.
 *
 * @author Simon Vieille <simon@deblan.fr>
 */
class ConfigProxy
{
    /**
     * @var IConfig
     */
    protected $config;

    public function __construct(IConfig $config)
    {
        $this->config = $config;
    }

    public function getAppValue(string $name, string $default, $appId = null): string
    {
        return (string) $this->config->getAppValue($appId ?? Application::APP_ID, $name, $default);
    }

    public function getUserValue(User $user, string $name, string $default, $appId = null): string
    {
        return (string) $this->config->getUserValue($user->getUid(), $appId ?? Application::APP_ID, $name, $default);
    }

    public function getAppValueBool(string $name, string $default, $appId = null): bool
    {
        return (bool) $this->getAppValue($name, $default, $appId);
    }

    public function getAppValueArray(string $name, string $default, $appId = null): array
    {
        return (array) json_decode($this->getAppValue($name, $default, $appId), true);
    }

    public function getAppValueInt(string $name, string $default, $appId = null): int
    {
        return (int) $this->getAppValue($name, $default, $appId);
    }

    public function getUserValueBool(User $user, string $name, string $default, $appId = null): bool
    {
        return (bool) str_replace(
            ['yes', 'no'],
            ['1', '0'],
            $this->getUserValue($user, $name, $default, $appId)
        );
    }

    public function getUserValueArray(User $user, string $name, string $default, $appId = null): array
    {
        return (array) json_decode($this->getUserValue($user, $name, $default, $appId), true);
    }

    public function getUserValueInt(User $user, string $name, string $default, $appId = null): int
    {
        return (int) $this->getUserValue($user, $name, $default, $appId);
    }
}
