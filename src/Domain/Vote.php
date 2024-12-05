<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace App\Domain;

use App\Domain\Vote\VoteId;
use App\Infrastructure\JsonApi\VoteSchema;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use Slick\JSONAPI\Object\SchemaDiscover\Attributes\AsResourceObject;

/**
 * Vote
 *
 * @package App\Domain
 */
#[Entity]
#[Table(name: 'votes')]
#[AsResourceObject(schemaClass: VoteSchema::class)]
class Vote
{
    #[Id]
    #[GeneratedValue(strategy: 'NONE')]
    #[Column(name: 'id', type: 'VoteId')]
    private VoteId $voteId;

    #[ManyToOne(targetEntity: Answer::class, inversedBy: 'votes')]
    private Answer $answer;

    #[ManyToOne(targetEntity: User::class)]
    #[JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private User $user;

    public function __construct(
        Answer $answer,
        User $user,
        #[Column]
        private bool $intention
    ) {
        $this->answer = $answer;
        $this->user = $user;
        $this->voteId = new VoteId();
    }

    public function voteId(): VoteId
    {
        return $this->voteId;
    }

    public function answer(): Answer
    {
        return $this->answer;
    }

    public function user(): User
    {
        return $this->user;
    }

    public function intention(): bool
    {
        return $this->intention;
    }
}