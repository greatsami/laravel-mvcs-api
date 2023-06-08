<?php

declare(strict_types=1);

namespace App\Modules\StudentCourseEnrollments;

use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class StudentCourseEnrollmentRepository
{
    private $tableName = "student_course_enrollment";
    private $selectColumns = [
        "student_course_enrollment.id",
        "student_course_enrollment.student_id as studentId",
        "student_course_enrollment.course_id as courseId",
        "student_course_enrollment.enrolled_by_user_id as enrolledByUserId",
        "student_course_enrollment.deleted_at as deletedAt",
        "student_course_enrollment.created_at as createdAt",
        "student_course_enrollment.updated_at as updatedAt",
    ];

    /**
     * @param int $id
     * @return StudentCourseEnrollment
     */
    public function get(int $id): StudentCourseEnrollment
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
            throw new InvalidArgumentException("Invalid student course enrollment Id");
        }

        return StudentCourseEnrollmentMapper::mapFrom($result);

    }

    public function update(StudentCourseEnrollment $course) : StudentCourseEnrollment
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
            throw new InvalidArgumentException("Invalid student course enrollment Id");
        }
        return true;
    }

}
