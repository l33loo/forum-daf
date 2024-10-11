<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\UserInterface\Web;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * HomepageController
 *
 * @package App\UserInterface\Web
 */
final class HomepageController extends AbstractController
{


    #[Route('/', name: 'homepage')]
    public function home(): Response
    {
        return $this->render('homepage.html.twig');
    }
}
