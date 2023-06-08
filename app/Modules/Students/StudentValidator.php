<?php

declare(strict_types=1);

namespace App\Modules\Students;

use InvalidArgumentException;

class StudentValidator
{
    public function validateUpdate(array $rawData): void
    {
        $validator = validator($rawData, [
            "name" => ['required', 'string'],
            "email" => ['required', 'email'],
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException(json_encode($validator->errors()->all()));
        }
    }
}
