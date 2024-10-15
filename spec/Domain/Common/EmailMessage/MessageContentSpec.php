<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Domain\Common\EmailMessage;

use App\Domain\Common\EmailMessage\MessageContent;
use PhpSpec\ObjectBehavior;

/**
 * MessageContentSpec specs
 *
 * @package spec\App\Domain\Common\EmailMessage
 */
class MessageContentSpec extends ObjectBehavior
{

    private $primaryContent;
    private $alternativeContent;

    function let()
    {
        $this->primaryContent = 'content';
        $this->alternativeContent = 'alternative content';
        $this->beConstructedWith($this->primaryContent, $this->alternativeContent);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(MessageContent::class);
    }

    function it_has_a_primary_content()
    {
        $this->primaryContent()->shouldBe($this->primaryContent);
    }

    function it_has_a_alternative_content()
    {
        $this->alternativeContent()->shouldBe($this->alternativeContent);
    }

    function it_can_be_created_with_primary_content_only()
    {
        $this->beConstructedWith($this->primaryContent);
        $this->primaryContent()->shouldBe($this->primaryContent);
        $this->alternativeContent()->shouldBeNull();
    }

}