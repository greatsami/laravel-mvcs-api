<?php

declare(strict_types=1);

namespace App\Modules\StudentCourseEnrollments;

use App\Modules\Common\MyHelper;

class StudentCourseEnrollmentMapper
{
    public static function mapFrom(array $data): StudentCourseEnrollment
    {
        return new StudentCourseEnrollment(
            MyHelper::nullStringToInt($data["id"] ?? null),
            $data["studentId"],
            $data["courseId"],
            $data["enrolledByUserId"],
            $data["deletedAt"] ?? null,
            $data["createdAt"] ?? date("Y-m-d H:i:s"),
            $data["updatedAt"] ?? null,
        );
    }

}
