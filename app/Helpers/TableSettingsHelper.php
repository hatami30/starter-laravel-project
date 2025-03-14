<?php

namespace App\Helpers;

use App\Models\TableSettings;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;

class TableSettingsHelper
{
  public static function getTableSettingsForModel(string $modelClass)
  {
    $modelInstance = app($modelClass);
    $tableName = $modelInstance->getTable();

    return TableSettings::where('user_id', auth()->id())
      ->where('model_name', $modelClass)
      ->where('table_name', $tableName)
      ->first();
  }

  public static function getLimit(
    Request $request,
    $savedSettings = null,
    array $availableLimits = [10, 25, 50, 100],
    int $defaultLimit = 10
  ): int {
    $limit = $request->get('limit', $savedSettings?->limit ?? $defaultLimit);
    return in_array((int) $limit, $availableLimits) ? (int) $limit : $defaultLimit;
  }

  public static function getColumnsForTable(string $modelClass, array $allColumns): array
  {
    $tableSettings = self::getTableSettingsForModel($modelClass);

    $visibleColumns = $tableSettings && !empty($tableSettings->visible_columns)
      ? json_decode($tableSettings->visible_columns, true)
      : $allColumns;

    return [$allColumns, $visibleColumns];
  }

  public static function getVisibleColumns(string $tableName, string $modelClass): array
  {
    $allColumns = TableHelper::getColumnsForTable($tableName);

    $tableSettings = self::getTableSettingsForModel($modelClass);

    return $tableSettings && !empty($tableSettings->visible_columns)
      ? json_decode($tableSettings->visible_columns, true)
      : $allColumns;
  }

  public static function saveTableSettings(
    Request $request,
    string $modelClass,
    array $additionalData = []
  ): bool {
    try {
      $modelInstance = app($modelClass);
      $tableName = $modelInstance->getTable();

      $columns = $request->input('columns', []);
      $showNumbering = (bool) $request->input('show_numbering', false);

      $settingsData = [
        'user_id' => auth()->id(),
        'table_name' => $tableName,
        'model_name' => $modelClass,
      ];

      $updateData = [
        'visible_columns' => json_encode($columns),
        'limit' => (int) $request->input('limit', 10),
        'show_numbering' => $showNumbering,
      ];

      $updateData = array_merge($updateData, $additionalData);

      TableSettings::updateOrCreate($settingsData, $updateData);

      return true;
    } catch (\Exception $e) {
      Log::error('Error saving table settings: ' . $e->getMessage(), [
        'request' => $request->all(),
        'model_class' => $modelClass,
        'trace' => $e->getTraceAsString()
      ]);

      return false;
    }
  }

  public static function applySearchFilter($query, Request $request, array $searchColumns)
  {
    if ($request->filled('q')) {
      $search = $request->q;
      $query->where(function ($q) use ($search, $searchColumns) {
        foreach ($searchColumns as $column) {
          if (!in_array($column, ['id', 'created_at', 'updated_at'])) {
            $q->orWhere($column, 'LIKE', "%{$search}%");
          }
        }
      });
    }

    return $query;
  }
}