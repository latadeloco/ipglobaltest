<?php

declare(strict_types=1);

namespace App\Tests\Article\Post\Domain;

use App\Article\Post\Domain\AuthorEmail;
use App\Article\Post\Domain\Exception\InvalidAuthorEmailException;
use PHPUnit\Framework\TestCase;

final class AuthorEmailTest extends TestCase
{
    /**
     * @test
     * be_of_proper_class
     * @group author_email
     */
    public function itShouldBeOfProperClass(): void
    {
        $sut = new AuthorEmail(email: 'jesusroblessanchez@gmail.com');
        $this->assertInstanceOf(AuthorEmail::class, $sut);

    }

    /**
     * @test
     * throw_exception_if_email_is_not_valid
     * @group author_email
     */
    public function itShouldThrowExceptionIfEmailIsNotValid(): void
    {
        $this->expectException(InvalidAuthorEmailException::class);
        new AuthorEmail(email: 'mipatatatienepelo');
    }
}
