<?php

declare(strict_types=1);

namespace App\Modules\Courses;

class CourseService
{

    public function __construct(
        private readonly CourseValidator  $courseValidator,
        private readonly CourseRepository $courseRepository
    )
    {
    }

    public function get(int $id): Course
    {
        return $this->courseRepository->get($id);
    }

    public function update(array $data): Course
    {
        $this->courseValidator->validateUpdate($data);
        return $this->courseRepository->update(CourseMapper::mapFrom($data));
    }

    public function softDelete(int $id): bool
    {
        return $this->courseRepository->softDelete($id);

    }

}
