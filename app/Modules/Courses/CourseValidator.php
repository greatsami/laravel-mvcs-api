<?php

declare(strict_types=1);

namespace App\Modules\Courses;

use InvalidArgumentException;

class CourseValidator
{
    public function validateUpdate(array $rawData): void
    {
        $validator = validator($rawData, [
            "name" => ['required', 'string'],
            "capacity" => ['required', 'integer'],
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException(json_encode($validator->errors()->all()));
        }
    }
}
