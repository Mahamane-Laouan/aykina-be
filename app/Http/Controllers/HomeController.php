<?php

namespace App\Http\Controllers;

use App\Models\SiteSetup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    // public function checkExtensions()
    // {
    //     $extensions = [
    //         'bcmath', 'ctype', 'fileinfo', 'json', 'mbstring',
    //         'openssl', 'pdo', 'tokenizer', 'xml'
    //     ];

    //     $extensionsStatus = [];

    //     foreach ($extensions as $extension) {
    //         $extensionsStatus[$extension] = extension_loaded($extension);
    //     }



    //     return view('extensions', compact('extensionsStatus'));
    // }

    public function checkExtensions_old()
    {
        // ✅ Required PHP extensions list
        $extensions = ['bcmath', 'ctype', 'fileinfo', 'json', 'mbstring', 'openssl', 'pdo', 'tokenizer', 'xml'];
        $extensionsStatus = [];

        foreach ($extensions as $extension) {
            $extensionsStatus[$extension] = extension_loaded($extension);
        }

        // ✅ PHP Version Check
        $requiredPHPVersion = '8.1';
        $currentPHPVersion = phpversion();
        $phpVersionStatus = version_compare($currentPHPVersion, $requiredPHPVersion, '>=');

        return view('extensions', compact('extensionsStatus', 'phpVersionStatus', 'currentPHPVersion', 'requiredPHPVersion'));
    }

    public function checkExtensions()
    {
        $extensions = ['bcmath', 'ctype', 'fileinfo', 'json', 'mbstring', 'openssl', 'pdo', 'tokenizer', 'xml'];
        $extensionsStatus = [];

        $missingExtensions = false;

        foreach ($extensions as $extension) {
            $isLoaded = extension_loaded($extension);
            $extensionsStatus[$extension] = $isLoaded;

            if (!$isLoaded) {
                $missingExtensions = true;
            }
        }

        $requiredPHPVersion = '8.1';
        $currentPHPVersion = phpversion();
        $phpVersionStatus = version_compare($currentPHPVersion, $requiredPHPVersion, '>=');

        $chunks = array_chunk($extensionsStatus, ceil(count($extensionsStatus) / 2), true);

        // Check if all extensions and PHP version are valid
        $allExtensionsValid = !$missingExtensions;


        if ($allExtensionsValid) {
            try {
                \Log::info("All extensions and PHP version are valid.");

                // Verify Token API Call (uncomment if needed)
                // $response = Http::timeout(60)->post(env('APP_URL') . '/api/verifyToken');
                // \Log::info("Verification API Response:", $response->json());

                // Fetch Purchase Code from Database
                $purchaseCode = SiteSetup::where('id', "1")->value('purchase_code');

                if (!empty($purchaseCode)) {
                    \Log::info("Purchase code found: $purchaseCode. Redirecting to login...");
                    return redirect()->route('login')->send();  // Force Redirect
                } else {
                    \Log::error("Purchase code not found in database!");
                    return redirect()->route('/')->send();
                }
            } catch (\Exception $e) {
                \Log::error('HTTP Request Failed: ' . $e->getMessage());
            }
        } else {
            \Log::warning("Required PHP version or extensions missing.");
        }



        return view('extensions', compact('extensionsStatus', 'phpVersionStatus', 'currentPHPVersion', 'requiredPHPVersion', 'missingExtensions', 'chunks'));
    }
}
