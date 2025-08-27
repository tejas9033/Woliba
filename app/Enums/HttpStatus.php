<?php

namespace App\Enums;

enum HttpStatus: int
{
    case OK = 200;
    case CREATED = 201;
    case UNAUTHORIZED = 401;
    case ACCESS_DENIED = 403;
    case NOT_FOUND = 404;

    function label(): string
    {
        return static::getLabel($this);
    }

    function getLabel(self $value): string
    {
        return match ($value) {
            HttpStatus::OK => 'Success',
            HttpStatus::CREATED => 'Go Ahead..!',
            HttpStatus::UNAUTHORIZED => 'Unauthorized Access.',
            HttpStatus::ACCESS_DENIED => 'Access Denied.',
            HttpStatus::NOT_FOUND => 'Page Not Found.',
        };
    }
}
