<?php

declare(strict_types=1);

namespace App\Modules\Courses;

class Course
{
    /**
     * @param int|null $id
     * @param string $name
     * @param int $totalStudentsEnrolled
     * @param int $capacity
     * @param string|null $deletedAt
     * @param string $createdAt
     * @param string|null $updatedAt
     */
    public function __construct(
        private ?int $id,
        private string $name,
        private int $totalStudentsEnrolled,
        private int $capacity,
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
            "totalStudentsEnrolled" => $this->totalStudentsEnrolled,
            "capacity" => $this->capacity,
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
            "capacity" => $this->capacity,
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
     * @return int
     */
    public function getCapacity(): int
    {
        return $this->capacity;
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

    /**
     * @return int
     */
    public function getTotalStudentsEnrolled(): int
    {
        return $this->totalStudentsEnrolled;
    }

}
