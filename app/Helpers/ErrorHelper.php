<?php

namespace App\Helpers;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;

class ErrorHelper
{
  public static function logAndRedirect(
    Exception $e,
    string $action,
    string $redirectRoute,
    array $context = []
  ): RedirectResponse {
    Log::error("Error {$action}: {$e->getMessage()}", [
      'trace' => $e->getTraceAsString(),
      ...$context
    ]);

    return redirect()->route($redirectRoute)
      ->with('error', "Gagal {$action}. Silakan coba lagi.");
  }
}