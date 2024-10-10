<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\UserInterface\Exception;

use App\UserInterface\UserInterfaceException;
use RuntimeException;

/**
 * InvalidInput
 *
 * @package App\UserInterface\Exception
 */
final class InvalidInput extends RuntimeException implements UserInterfaceException
{

}
