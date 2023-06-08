<?php

declare(strict_types=1);

namespace App\Modules\Courses;

use App\Modules\Common\MyHelper;

class CourseMapper
{
    public static function mapFrom(array $data): Course
    {
        return new Course(
            MyHelper::nullStringToInt($data["id"] ?? null),
            $data["name"],
            $data["totalStudentsEnrolled"] ?? 0,
            $data["capacity"],
            $data["deletedAt"] ?? null,
            $data["createdAt"] ?? date("Y-m-d H:i:s"),
            $data["updatedAt"] ?? null,
        );
    }

}
