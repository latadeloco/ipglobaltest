<?php

declare(strict_types=1);

namespace App\Tests\Article\Post\Domain;

use App\Article\Post\Domain\AuthorAddress;
use App\Article\Post\Domain\AuthorCompany;
use App\Article\Post\Domain\AuthorContact;
use App\Article\Post\Domain\AuthorEmail;
use App\Article\Post\Domain\AuthorPhone;
use App\Article\Post\Domain\AuthorWebsite;
use App\Article\Post\Domain\DomainAuthor;
use App\Article\Post\Domain\DomainPost;
use Faker\Factory;

final class DomainPostOM
{
    public static function twoPost(): array
    {
        return [
            DomainPost::fromParams(title: 'title_post_one', body: 'body_post_one', domainAuthor: self::createRandomAuthor()),
            DomainPost::fromParams(title: 'title_post_two', body: 'body_post_two', domainAuthor: self::createRandomAuthor()),
        ];
    }

    public static function createRandomAuthor(): DomainAuthor
    {
        $faker = Factory::create();
        $name = $faker->name();
        $username = $faker->userName();
        $authorEmail = new AuthorEmail(email: $faker->email());
        $authorAddress = new AuthorAddress(
            street: $faker->streetAddress(),
            city: $faker->city(),
            zipcode: $faker->countryCode()
        );
        $authorPhone = new AuthorPhone(
            phone: $faker->phoneNumber()
        );
        $authorWebsite = new AuthorWebsite(
            website: $faker->url()
        );
        $authorCompany = new AuthorCompany(
            name: $faker->company()
        );
        $authorContact = new AuthorContact(
            authorPhone: $authorPhone,
            authorWebsite: $authorWebsite,
            authorCompany: $authorCompany
        );
        return new DomainAuthor(
            name: $name,
            username: $username,
            authorEmail: $authorEmail,
            authorAddress: $authorAddress,
            authorContact: $authorContact
        );
    }
}
