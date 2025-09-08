<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

class ConfigurationController extends Controller
{
    // Show the form
    public function index()
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
            return redirect('/')->with('error', 'Some required PHP extensions are missing.');
        }

        // Use config() to fetch DB info from config/database.php (which reads .env internally)
        $db_name = config('database.connections.mysql.database');
        $db_user = config('database.connections.mysql.username');
        $db_password = config('database.connections.mysql.password');
        $app_url = config('app.url');

        return view('configuration', [
            'db_name' => $db_name,
            'db_user' => $db_user,
            'db_password' => $db_password,
            'app_url' => $app_url
        ]);
    }

    // Save the configuration
    public function save(Request $request)
    {
        $envPath = base_path('.env');

        $envContent = File::get($envPath);

        $newValues = [
            'APP_URL' => $request->app_url ?? env('APP_URL'),
            'DB_DATABASE' => $request->db_database ?? env('DB_DATABASE'),
            'DB_USERNAME' => $request->db_username ?? env('DB_USERNAME'),
            'DB_PASSWORD' => $request->db_password ?? env('DB_PASSWORD'),
        ];

        foreach ($newValues as $key => $value) {
            $envContent = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $envContent);
        }
        File::put($envPath, $envContent);

        // return redirect('')->back()->with('success', 'Configuration updated successfully!');
        // return redirect()->route('login')->with('success', 'Configuration updated successfully!');
        return response()->json(['success' => true, 'message' => 'Configuration updated successfully!']);
    }
}
