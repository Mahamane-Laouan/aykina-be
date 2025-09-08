<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use App\Models\MailSetup;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Exceptions\HttpResponseException;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    public function boot()
    {
        app()->booted(function () {
            $request = request();

            $allowedRoutes = [
                base64_decode('dmFsaWRhdGU='),
                base64_decode('YXBpL3ZhbGlkYXRlUHVyY2hhc2U='),
                base64_decode('YXBpL3ZlcmlmeVRva2Vu'),
                '/',
                base64_decode('Y2hlY2stZGlyZWN0b3JpZXM=')
            ];

            if ($request->is($allowedRoutes)) {
                return;
            }

            if (!$this->verifyToken()) {
                // Throw an HTTP response exception that redirects to '/'
                throw new HttpResponseException(redirect('/'));
            }
        });
    }


    private function verifyToken(): bool
    {
        try {
            $tokenFilePath = storage_path('app/validatedToken.txt');

            if (!File::exists($tokenFilePath)) {
                Log::error("Token file not found: " . $tokenFilePath);
                return false;
            }

            $token = File::get($tokenFilePath);

            $apiUrl = base64_decode("aHR0cHM6Ly92YWxpZGF0b3Iud2hveGFjaGF0LmNvbS92ZXJpZnlfbmV3");

            $response = Http::post($apiUrl, [
                "server_ip" => request()->ip(),
                "mac_address" => exec('getmac'),
                "token" => trim($token),
            ]);

            $data = $response->json();

            if (!isset($data['success']) || !$data['success']) {
                Log::error("Token verification failed");
                return false;
            }

            return true;
        } catch (\Exception $e) {
            Log::error('Verification Error:', ['exception' => $e->getMessage()]);
            return false;
        }
    }
}
