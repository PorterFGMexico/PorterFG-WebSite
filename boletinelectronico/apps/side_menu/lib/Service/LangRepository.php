<?php

namespace OCA\SideMenu\Service;

use OCP\IDBConnection;

/**
 * class LangRepository.
 *
 * @author Simon Vieille <simon@deblan.fr>
 */
class LangRepository
{
    /**
     * @var IDBConnection
     */
    protected $db;

    public function __construct(IDBConnection $db)
    {
        $this->db = $db;
    }

    public function getUsedLangs(): array
    {
        $qb = $this->db->getQueryBuilder();

        $qb->select($qb->createFunction('DISTINCT configvalue'))
            ->where('configkey=:configkey and appid=:appid and configvalue<>:configvalue')
            ->setParameters([
                'configkey' => 'lang',
                'appid' => 'core',
                'configvalue' => 'en',
            ])
            ->from('preferences')
        ;

        $stmt = $qb->execute();

        $langs = ['en'];

        foreach ($stmt->fetchAll() as $result) {
            $langs[] = $result['configvalue'];
        }

        return $langs;
    }
}
