<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\UserInterface\Web\User;

use App\Application\Shared\Pagination;
use App\Application\User\Query\UserList;
use App\Domain\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * UserListController
 *
 * @package App\UserInterface\Web\User
 */
final class UserListController extends AbstractController
{


    private const USER_LIST_PARAMS = [
        "rows" => 12,
        "page" => 1,
        "search" => null,
    ];

    #[Route(path: "/users", name: "users")]
    #[IsGranted(User::ROLE_ADMIN)]
    public function handle(UserList $users, Request $request): Response
    {
        $listState = $request->getSession()->get('usersList', self::USER_LIST_PARAMS);
        $listState = [
            'rows' => $request->query->getInt('rows', $listState['rows']),
            'page' => $request->query->getInt('page', $listState['page']),
            'search' => $request->query->get('search', $listState['search']),
        ];


        if ($listState['search']) {
            $users = $users->withParam('search', strip_tags($listState['search']));
        }

        $pagination = new Pagination($listState['rows'], $listState['page'], $users->count());
        $users->withPagination($pagination);

        $request->getSession()->set('usersList', $listState);

        return $this->render('user/list.html.twig', ['users' => $users, 'search' => $listState['search']]);
    }
}
