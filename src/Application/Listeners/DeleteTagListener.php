<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Application\Listeners;

use App\Domain\Event\Tag\TagWasRejected;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

/**
 * DeleteTagListener
 *
 * @package App\Application\Listeners
 */
#[AsEventListener(event: TagWasRejected::class, method: 'onTagRejected')]
final readonly class DeleteTagListener
{

}
