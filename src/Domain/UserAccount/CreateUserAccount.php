<?php

namespace App\Domain\UserAccount;

use JsonSerializable;

class CreateUserAccount implements JsonSerializable
{
    private int $nationId;

    private int $languageId;

    private string $name;

    private string $email;

    private string $password;

    public function __construct($nationId, $languageId, $name, $email, $password) {
        $this->nationId = $nationId;
        $this->languageId = $languageId;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public function getNationId(): int {
        return $this->nationId;
    }

    public function getLanguageId(): int {
        return $this->languageId;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function jsonSerialize(): array
    {
        return [
            'nation_id' => $this->nationId,
            'language_id' => $this->languageId,
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password
        ];
    }
}