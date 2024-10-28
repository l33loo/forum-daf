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
 * LicenceController
 *
 * @package App\UserInterface\Web
 */
final class LicenceController extends AbstractController
{


    #[Route(path: "/licence", name: "licence")]
    public function handle(): Response
    {
        return $this->render('licence.html.twig');
    }
}
