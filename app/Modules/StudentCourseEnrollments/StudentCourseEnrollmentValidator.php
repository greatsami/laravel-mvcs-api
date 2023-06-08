<?php

declare(strict_types=1);

namespace App\Modules\StudentCourseEnrollments;

use Illuminate\Validation\Rule;
use InvalidArgumentException;

class StudentCourseEnrollmentValidator
{

    public function __construct(private StudentCourseEnrollmentDatabaseValidator $studentCourseEnrollmentDatabaseValidator)
    {
    }

    public function validateUpdate(array $rawData): void
    {
        $validator = validator($rawData, [
            "studentId" => ['required', 'int', Rule::exists('students', 'id')],
            "courseId" => ['required', 'int', Rule::exists('courses', 'id')],
            "enrolledByUserId" => ['required', 'int', Rule::exists('users', 'id')],
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException(json_encode($validator->errors()->all()));
        }

        $this->studentCourseEnrollmentDatabaseValidator->validateUpdate($rawData["courseId"], $rawData["studentId"]);
    }
}
