<?php

namespace App\Traits;

use App\Helpers\TableSettingsHelper;

trait TableSettingsTrait
{
  public function getTableSettings(): mixed
  {
    return TableSettingsHelper::getTableSettingsForModel(static::class);
  }
}