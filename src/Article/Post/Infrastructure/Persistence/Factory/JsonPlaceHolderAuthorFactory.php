<?php

declare(strict_types=1);

namespace App\Article\Post\Infrastructure\Persistence\Factory;

use App\Article\Post\Domain\AuthorAddress;
use App\Article\Post\Domain\AuthorCompany;
use App\Article\Post\Domain\AuthorContact;
use App\Article\Post\Domain\AuthorEmail;
use App\Article\Post\Domain\AuthorFactory;
use App\Article\Post\Domain\AuthorPhone;
use App\Article\Post\Domain\AuthorWebsite;
use App\Article\Post\Domain\DomainAuthor;
use App\Article\Post\Domain\Exception\InvalidAuthorEmailException;
use App\Article\Post\Domain\Exception\InvalidDataException;
use App\Article\Post\Domain\Exception\InvalidWebsiteException;

final class JsonPlaceHolderAuthorFactory implements AuthorFactory
{
    public static function create(): self
    {
        return new self();
    }
    public function __construct()
    {
    }

    private const ADDRESS_KEYS = [
        "street",
        "city",
        "zipcode"
    ];
    private const COMPANY_KEYS = [
        "name"
    ];
    private const KEYS_EXIST = [
        "name",
        "username",
        "email",
        "address",
        "phone",
        "website",
        "company"
    ];

    /**
     * @throws InvalidWebsiteException
     * @throws InvalidDataException
     * @throws InvalidAuthorEmailException
     */
    public function make(array $data): DomainAuthor
    {
        $this->validateData($data);
        return $this->createAuthorWithData($data);
    }

    /**
     * @throws InvalidDataException
     */
    private function validateData(array $data): void
    {
        foreach (self::KEYS_EXIST as $key) {
            if (!key_exists($key, $data)) {
                throw new InvalidDataException("The $key not present in data!!!");
            }
        }
        $this->validateAddressKeyInData(data: (array) $data['address']);
        $this->validateCompanyKeyInData(data: (array) $data['company']);
    }

    /**
     * @throws InvalidWebsiteException
     * @throws InvalidAuthorEmailException
     */
    private function createAuthorWithData(array $data): DomainAuthor
    {
        $authorEmail = new AuthorEmail(
            email: (string)$data["email"]
        );
        $address = (array)$data["address"];
        $authorAddress = new AuthorAddress(
            street: (string)$address["street"],
            city: (string)$address["city"],
            zipcode: (string)$address["zipcode"]
        );
        $authorPhone = new AuthorPhone(
            phone: (string)$data["phone"]
        );
        $website = "http://";
        $website .= (string) $data["website"];
        $authorWebsite = new AuthorWebsite(
            website: $website
        );
        $company = (array)$data["company"];
        $authorCompany = new AuthorCompany(
            name: (string)$company["name"]
        );
        $authorContact = new AuthorContact(
            authorPhone: $authorPhone,
            authorWebsite: $authorWebsite,
            authorCompany: $authorCompany
        );
        return new DomainAuthor(
            name: (string)$data["name"],
            username: (string)$data["username"],
            authorEmail: $authorEmail,
            authorAddress: $authorAddress,
            authorContact: $authorContact
        );
    }

    /**
     * @throws InvalidDataException
     */
    private function validateAddressKeyInData(array $data): void
    {
        foreach (self::ADDRESS_KEYS as $addressKey) {
            if (!array_key_exists($addressKey, $data)) {
                throw new InvalidDataException("The address not present in data!!!");
            }
        }
    }

    /**
     * @throws InvalidDataException
     */
    private function validateCompanyKeyInData(array $data): void
    {
        foreach (self::COMPANY_KEYS as $companyKey) {
            if (!array_key_exists($companyKey, $data)) {
                throw new InvalidDataException("The company not present in data!!!");
            }
        }
    }
}
