<?php

declare(strict_types=1);

namespace App\Modules\Students;

class Student
{
    /**
     * @param int|null $id
     * @param string $name
     * @param string $email
     * @param string|null $deletedAt
     * @param string $createdAt
     * @param string|null $updatedAt
     */
    public function __construct(
        private ?int $id,
        private string $name,
        private string $email,
        private ?string $deletedAt,
        private string $createdAt,
        private ?string $updatedAt,
    )
    {
    }

    public function toArray(): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "deletedAt" => $this->deletedAt,
            "createdAt" => $this->createdAt,
            "updatedAt" => $this->updatedAt,
        ];
    }

    public function toSQL(): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "deleted_at" => $this->deletedAt,
            "created_at" => $this->createdAt,
            "updated_at" => $this->updatedAt,
        ];
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string|null
     */
    public function getDeletedAt(): ?string
    {
        return $this->deletedAt;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * @return string|null
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

}
