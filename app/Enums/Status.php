<?php

	namespace App\Enums;

	enum Status: int
	{
		case INACTIVE = 0;
		case ACTIVE = 1;

		function label(): string
		{
			return static::getLabel($this);
		}

		function getLabel(self $value): string
		{
			return match ($value) {
				Status::INACTIVE => 'Inactive',
				Status::ACTIVE => 'Active'
			};
		}
	}
