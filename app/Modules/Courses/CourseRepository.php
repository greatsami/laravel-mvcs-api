<?php

declare(strict_types=1);

namespace App\Modules\Courses;

use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class CourseRepository
{
    private $tableName = "courses";
    private $selectColumns = [
        "courses.id",
        "courses.name",
        "(SELECT COUNT(*) FROM student_course_enrollment WHERE student_course_enrollment.course_id = courses.id AND student_course_enrollment.deleted_at IS NULL)",
        "courses.capacity",
        "courses.deleted_at as deletedAt",
        "courses.created_at as createdAt",
        "courses.updated_at as updatedAt",
    ];

    /**
     * @param int $id
     * @return Course
     */
    public function get(int $id): Course
    {
        $selectColumns = implode(", ", $this->selectColumns);
        $result = json_decode(json_encode(
            DB::selectOne("SELECT {$selectColumns}
                FROM {$this->tableName}
                WHERE id = :id AND deleted_at IS NULL", [
                "id" => $id
            ])
        ), true);

        if ($result === null) {
            throw new InvalidArgumentException("Invalid course Id");
        }

        return CourseMapper::mapFrom($result);

    }

    public function update(Course $course) : Course
    {
        return DB::transaction(function () use ($course) {
            DB::table($this->tableName)->updateOrInsert([
                "id" => $course->getId()
            ], $course->toSQL());

            $id = ($course->getId() === null || $course->getId() === 0)
                ? (int)DB::getPdo()->lastInsertId()
                : $course->getId();

            return $this->get($id);
        });
    }

    public function softDelete(int $id): bool
    {
        $result = DB::table($this->tableName)
            ->where("id", $id)
            ->where("deleted_at", null)
            ->update([
                "deleted_at" => date("Y-m-d H:i:s")
            ]);

        if ($result !== 1) {
            throw new InvalidArgumentException("Invalid course Id");
        }
        return true;
    }

}
