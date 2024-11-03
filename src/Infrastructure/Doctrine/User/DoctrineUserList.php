<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\User;

use App\Application\User\Query\Model\UserModel;
use App\Application\User\Query\UserList;
use App\Infrastructure\JsonApi\UserListSchema;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Slick\JSONAPI\Object\SchemaDiscover\Attributes\AsResourceCollection;

/**
 * DoctrineUserList
 *
 * @package App\Infrastructure\Doctrine\User
 */
#[AsResourceCollection(schemaClass: UserListSchema::class)]
final class DoctrineUserList extends UserList
{

    public function __construct(private readonly Connection $connection)
    {
    }

    /**
     * @inheritDoc
     */
    protected function countQuery(): int
    {
        $query = $this->connection->createQueryBuilder()
            ->from('users', "u")
            ->select("count(u.id) AS total");
        $this->addSearchCriteria($query);
        $result = $query->executeQuery();
        return (int) $result->fetchOne();
    }

    /**
     * @inheritDoc
     */
    protected function objects(): Collection
    {
        $data = new ArrayCollection();
        $query = $this->connection->createQueryBuilder()
            ->from('users', "u")
            ->select("u.id AS userId", "u.name", "u.email", "u.banned", "u.ban_reason AS banReason", "u.roles")
            ->setFirstResult($this->pagination()->offset())
            ->setMaxResults($this->pagination()->itemsPerPage());
        $this->addSearchCriteria($query);
        $result = $query->executeQuery();
        while ($row = $result->fetchAssociative()) {
           $data->add(new UserModel($row));
        }
        return $data;
    }

    private function addSearchCriteria(QueryBuilder $builder): void
    {
        $builder->andWhere('u.email LIKE :search')
            ->orWhere('u.name LIKE :search')
            ->setParameter('search', "%{$this->param('search')}%");
    }
}
