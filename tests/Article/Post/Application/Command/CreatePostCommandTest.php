<?php

declare(strict_types=1);

namespace App\Tests\Article\Post\Application\Command;

use App\Article\Post\Application\Command\CreatePostCommand;
use PHPUnit\Framework\TestCase;

final class CreatePostCommandTest extends TestCase
{
    /**
     * @test
     * be_of_proper_class
     * @group create_post_command
     */
    public function itShouldBeOfProperClass(): void
    {
        $sut = new CreatePostCommand();
        $this->assertInstanceOf(CreatePostCommand::class, $sut);
    }
}
