<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain\Exception;

use App\Domain\DomainException;
use InvalidArgumentException;

/**
 * InvalidIdentifier
 *
 * @package App\Domain\Exception
 */
final class InvalidIdentifier extends InvalidArgumentException implements DomainException
{

}
