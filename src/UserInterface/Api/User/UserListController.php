<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\UserInterface\Api\User;

use App\Application\Shared\Pagination;
use App\Application\User\Query\UserList;
use App\Domain\User;
use App\UserInterface\Api\ApiControllerMethods;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * UserListController
 *
 * @package App\UserInterface\Api\User
 */
final class UserListController extends AbstractController
{
    use ApiControllerMethods;

    private const USER_LIST_PARAMS = [
        "rows" => 12,
        "page" => 1,
        "search" => null,
    ];

    #[Route(path: "/api/users", name: "api-users-list")]
    #[IsGranted(User::ROLE_USER)]
    public function handle(UserList $list, Request $request): Response
    {
        $query = $request->query;
        $rows = (int) $query->get('rows', self::USER_LIST_PARAMS['rows']);
        $page = (int) $query->get('page', self::USER_LIST_PARAMS['page']);
        $search = (string) $query->get('search', self::USER_LIST_PARAMS['search']);

        $list->withParam('search', $search);

        $pag = new Pagination($rows, $page, $list->count());

        return $this->apiResponse($list->withPagination($pag));
    }

}
