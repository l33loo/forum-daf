<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain\Common;

use JsonSerializable;
use Stringable;

/**
 * EntityIdentifier
 *
 * @package App\Domain\Common
 */
interface EntityIdentifier extends Stringable, JsonSerializable, Equatable
{

}
