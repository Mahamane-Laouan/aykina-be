<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SystemCheckController extends Controller
{
    public function checkDirectories()
    {

        $missingExtensions = [];

        // $requiredExtensions = ['mbstring', 'openssl', 'pdo']; // 🔹 Yaha required extensions list karo
        $requiredExtensions = ['bcmath', 'ctype', 'fileinfo', 'json', 'mbstring', 'openssl', 'pdo', 'tokenizer', 'xml'];
        foreach ($requiredExtensions as $ext) {
            if (!extension_loaded($ext)) {
                $missingExtensions[] = $ext;
            }
        }

        // ❌ If extensions are missing, redirect to an error page or back
        if (!empty($missingExtensions)) {
            return redirect()->back()->with('error', 'Some required PHP extensions are missing.');
        }

        // ✅ Required writable directories list
        $directories = [
            'storage' => storage_path(),
            'cache' => base_path('bootstrap/cache'),
        ];
        
        // ✅ Checking if directories are writable
        $permissionsStatus = [];
        foreach ($directories as $key => $path) {
            $permissionsStatus[$key] = is_writable($path);
        }

        return view('directories', compact('permissionsStatus'));
    }
}
