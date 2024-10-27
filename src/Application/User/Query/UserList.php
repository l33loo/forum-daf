<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Application\User\Query;

use App\Application\PaginatedQuery;
use App\Application\Shared\AbstractPaginatedQuery;
use App\Application\User\Query\Model\UserModel;
use Doctrine\Common\Collections\Collection;

/**
 * UserList
 *
 * @package App\Application\User\Query
 *
 * @extends AbstractPaginatedQuery<string|int, UserModel>
 */
abstract class UserList extends AbstractPaginatedQuery implements PaginatedQuery
{
}
