<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain\Common;

/**
 * Equatable
 *
 * @package App\Domain\Common
 */
interface Equatable
{

    /**
     * Compares this object with another object.
     *
     * @param object $other The object to compare with
     * @return bool Returns true if the objects are equal, false otherwise
     */
    public function equals(object $other): bool;
}
