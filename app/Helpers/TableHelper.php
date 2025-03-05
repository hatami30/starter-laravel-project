<?php

namespace App\Helpers;

use App\Constants\TableConstants;

class TableHelper
{
    public static function getColumnsForTable(string $tableName): array
    {
        $columns = [
            'users' => TableConstants::USER_TABLE_COLUMNS,
            'roles_and_permissions' => TableConstants::ROLE_AND_PERMISSION_TABLE_COLUMNS,
            'divisions' => TableConstants::DIVISION_TABLE_COLUMNS,
            'risks' => TableConstants::RISK_TABLE_COLUMNS,
        ];

        return $columns[$tableName] ?? [];
    }
}
