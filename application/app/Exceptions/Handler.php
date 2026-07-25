<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use App\Exceptions\SaldoTerlaluBesarException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * Renderable exceptions
     */
    protected function register()
    {
        // Tangani langsung saat exception dilempar
        $this->renderable(function (SaldoTerlaluBesarException $e, $request) {

            // Jika request berasal dari browser (HTML form)
            if ($request->expectsHtml()) {
                return back()
                    ->withInput()
                    ->with('error', $e->getMessage());
            }

            // Jika request API / AJAX
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 422);
        });
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof ThrottleRequestsException) {
            return back()->with('error', 'Terlalu banyak percobaan. Coba lagi dalam beberapa menit.');
        }

        return parent::render($request, $e);
    }
}
