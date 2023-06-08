<?php

declare(strict_types=1);

namespace App\Modules\Students;

use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class StudentRepository
{
    private $tableName = "students";
    private $enrollmentTableName = "student_course_enrollment";
    private $selectColumns = [
        "students.id",
        "students.name",
        "students.email",
        "students.deleted_at as deletedAt",
        "students.created_at as createdAt",
        "students.updated_at as updatedAt",
    ];

    /**
     * @param int $id
     * @return Student
     */
    public function get(int $id): Student
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
            throw new InvalidArgumentException("Invalid student Id");
        }

        return CourseMapper::mapFrom($result);

    }

    public function update(Student $student) : Student
    {
        return DB::transaction(function () use ($student) {
            DB::table($this->tableName)->updateOrInsert([
                "id" => $student->getId()
            ], $student->toSQL());

            $id = ($student->getId() === null || $student->getId() === 0)
                ? (int)DB::getPdo()->lastInsertId()
                : $student->getId();

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
            throw new InvalidArgumentException("Invalid student Id");
        }
        return true;
    }

    public function getByCourseId(int $courseId): array
    {
        $selectColumns = implode(", ", $this->selectColumns);
        $result = json_decode(json_encode(
            DB::select("SELECT {$selectColumns}
                FROM {$this->tableName}
                JOIN {$this->enrollmentTableName} ON {$this->enrollmentTableName}.course_id = :courseId
                WHERE {$this->tableName}.id = {$this->enrollmentTableName}.student_id
                AND {$this->enrollmentTableName}.deleted_at IS NULL
            ", [
                "courseId" => $courseId
            ])
        ), true);

        if (count($result) === 0) {
            return [];
            // throw new InvalidArgumentException("No students Enrolled");
        }

        return array_map(function ($row) {
            return StudentMapper::mapFrom($row);
        }, $result);
    }
}
