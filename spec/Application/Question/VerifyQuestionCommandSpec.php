<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Application\Question;

use App\Application\Question\VerifyQuestionCommand;
use PhpSpec\ObjectBehavior;

/**
 * VerifyQuestionCommandSpec specs
 *
 * @package spec\App\Application\Question
 */
class VerifyQuestionCommandSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(VerifyQuestionCommand::class);
    }
}