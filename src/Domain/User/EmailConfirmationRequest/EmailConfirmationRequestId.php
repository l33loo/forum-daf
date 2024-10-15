<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain\User\EmailConfirmationRequest;

use App\Domain\Common\EntityIdentifier;
use App\Domain\Common\EntityIdentifierMethods;

/**
 * EmailConfirmationRequestId
 *
 * @package App\Domain\User\EmailConfirmationRequest
 */
final class EmailConfirmationRequestId implements EntityIdentifier
{
    use EntityIdentifierMethods;
}
