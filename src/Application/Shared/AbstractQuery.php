<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Application\Shared;

use App\Application\Query;
use Doctrine\Common\Collections\Collection;
use Traversable;

/**
 * AbstractQuery
 *
 * @package App\Application\Shared
 *
 * @template TKey of int|string
 * @template TValue of mixed
 * @implements Query<TKey, TValue>
 */
abstract class AbstractQuery implements Query
{

    /** @var Collection<TKey, TValue>|null */
    protected ?Collection $objects = null;

    /** @var array<string, mixed>  */
    protected array $parameters = [];

    /**
     * Performs the query
     *
     * @return Collection<TKey, TValue>
     */
    abstract protected function objects(): Collection;

    /**
     * @inheritDoc
     */
    public function getIterator(): Traversable
    {
        return $this->loadedObjects();
    }

    /**
     * @inheritDoc
     */
    public function offsetExists(mixed $offset): bool
    {
        return $this->loadedObjects()->offsetExists($offset);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->loadedObjects()->offsetGet($offset);
    }

    /**
     * @inheritDoc
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->loadedObjects()->offsetSet($offset, $value);
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset(mixed $offset): void
    {
        $this->loadedObjects()->offsetUnset($offset);
    }

    /**
     * @inheritDoc
     */
    public function count(): int
    {
        return $this->loadedObjects()->count();
    }

    /**
     * @inheritDoc
     */
    public function getFirst(): ?object
    {
        $first = $this->loadedObjects()->first();
        return $first === false ? null : $first;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return $this->loadedObjects()->getValues();
    }

    /**
     * @inheritDoc
     * @return AbstractQuery<TKey, TValue>
     */
    public function withParam(string $name, mixed $value): self
    {
        $this->parameters[$name] = $value;
        $this->objects = null;
        return $this;
    }

    /**
     * @inheritDoc
     * @return AbstractQuery<TKey, TValue>
     */
    public function withoutParam(string $name): self
    {
        if (!array_key_exists($name, $this->parameters)) {
            return $this;
        }

        $newParameterSet = [];
        foreach ($this->parameters as $key => $value) {
            if ($key === $name) {
                continue;
            }
            $newParameterSet[$key] = $value;
        }

        $this->parameters = $newParameterSet;
        $this->objects = null;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function param(string $name, mixed $default = null): mixed
    {
        if (array_key_exists($name, $this->parameters)) {
            return $this->parameters[$name];
        }

        return $default;
    }

    /**
     * @inheritDoc
     */
    public function params(): array
    {
        return $this->parameters;
    }

    private function loadedObjects(): Collection
    {
        if (null === $this->objects) {
            $this->objects = $this->objects();
        }
        return $this->objects;
    }
}
