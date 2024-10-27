<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Application;

use ArrayAccess;
use Countable;
use IteratorAggregate;

/**
 * Query
 *
 * @package App\Application
 * @template TKey of int|string
 * @template TValue of mixed
 * @extends IteratorAggregate<TKey,TValue>
 * @extends ArrayAccess<TKey,TValue>
 */
interface Query extends Countable, IteratorAggregate, ArrayAccess
{
    /**
     * Returns the first object in the result set
     *
     * @return mixed
     * @phpstan-return TValue
     */
    public function getFirst(): mixed;

    /**
     * Returns an array with the objects in the result set
     *
     * @return array<TValue>
     * @phpstan-return list<TValue>
     */
    public function toArray(): array;

    /**
     * Adds a parameter to the query.
     *
     * SHOULD reset the query as parameters are used to perform query variations and filters.
     *
     * @param string $name
     * @param mixed $value
     * @return Query<TKey, TValue>
     */
    public function withParam(string $name, mixed $value): self;

    /**
     * Removes a parameter from the query.
     *
     * @param string $name
     * @return Query<TKey, TValue>
     */
    public function withoutParam(string $name): self;

    /**
     * Retrieves the parameter with provided name, or the default value
     *
     * @param string $name
     * @param mixed|null $default
     * @return mixed
     */
    public function param(string $name, mixed $default = null): mixed;

    /**
     * List of the params used in the query
     *
     * @return array<string, mixed>
     */
    public function params(): array;
}
