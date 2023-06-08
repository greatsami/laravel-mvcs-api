<?php

declare(strict_types=1);

namespace App\Modules\StudentCourseEnrollments;

class StudentCourseEnrollmentService
{

    public function __construct(
        private readonly StudentCourseEnrollmentValidator  $studentCourseEnrollmentValidator,
        private readonly StudentCourseEnrollmentRepository $studentCourseEnrollmentRepository
    )
    {
    }

    public function get(int $id): StudentCourseEnrollment
    {
        return $this->studentCourseEnrollmentRepository->get($id);
    }

    public function update(array $data): StudentCourseEnrollment
    {
        $data = array_merge($data, ['enrolledByUserId' => auth()->id()]);

        $this->studentCourseEnrollmentValidator->validateUpdate($data);
        return $this->studentCourseEnrollmentRepository->update(StudentCourseEnrollmentMapper::mapFrom($data));
    }

    public function softDelete(int $id): bool
    {
        return $this->studentCourseEnrollmentRepository->softDelete($id);

    }

}
