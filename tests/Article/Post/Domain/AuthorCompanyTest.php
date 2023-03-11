<?php

declare(strict_types=1);

namespace App\Tests\Article\Post\Domain;

use App\Article\Post\Domain\AuthorCompany;
use PHPUnit\Framework\TestCase;

final class AuthorCompanyTest extends TestCase
{
    /**
     * @test
     * be_of_proper_class
     * @group author_company
     */
    public function itShouldBeOfProperClass(): void
    {
        $sut = new AuthorCompany(
            name: 'ipglobal'
        );
        $this->assertInstanceOf(AuthorCompany::class, $sut);
        $this->assertEquals('ipglobal', $sut->companyName());
    }
}
