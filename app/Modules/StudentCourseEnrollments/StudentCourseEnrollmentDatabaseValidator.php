<?php

declare(strict_types=1);

namespace App\Modules\StudentCourseEnrollments;

use App\Modules\Courses\CourseService;
use App\Modules\Students\StudentService;
use InvalidArgumentException;

class StudentCourseEnrollmentDatabaseValidator
{
    public function __construct(
        private CourseService $courseService,
        private StudentService $studentService,
    )
    {
    }

    public function validateUpdate(int $courseId, int $studentId): void
    {
        $course = $this->courseService->get($courseId);

        if ($course->getTotalStudentsEnrolled() >= $course->getCapacity()) {
            throw new InvalidArgumentException("Failed to enroll student. Course enrollment limit {$course->getCapacity()} reached.");
        }

        // no duplicated allowed
        $studentsEnrolled = $this->studentService->getByCourseId($courseId);
        for ($i = 0; $i < count($studentsEnrolled); $i++) {
            if ($studentsEnrolled[$i]->getId() === $studentId) {
                throw new InvalidArgumentException("Failed to enroll student. Student already registered.");
            }
        }


    }
}
