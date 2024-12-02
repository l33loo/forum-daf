<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain\Answer;

use App\Domain\Common\EntityIdentifier;
use App\Domain\Common\EntityIdentifierMethods;

/**
 * AnswerId
 *
 * @package App\Domain\Answer
 */
final class AnswerId implements EntityIdentifier
{
    use EntityIdentifierMethods;
}
