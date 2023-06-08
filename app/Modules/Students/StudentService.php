<?php

declare(strict_types=1);

namespace App\Modules\Students;

class StudentService
{

    public function __construct(
        private readonly StudentValidator  $studentValidator,
        private readonly StudentRepository $studentRepository
    )
    {
    }

    public function get(int $id): Student
    {
        return $this->studentRepository->get($id);
    }

    /**
     * @param int $courseId
     * @return Student[]
     */
    public function getByCourseId(int $courseId): array
    {
        return $this->studentRepository->getByCourseId($courseId);
    }

    public function update(array $data): Student
    {
        $this->studentValidator->validateUpdate($data);
        return $this->studentRepository->update(StudentMapper::mapFrom($data));
    }

    public function softDelete(int $id): bool
    {
        return $this->studentRepository->softDelete($id);

    }

}
