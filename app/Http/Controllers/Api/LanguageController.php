<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\LanguageSetting;
use App\Models\LanguageStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Validator;

class LanguageController extends BaseController
{
    public function addKey(Request $request)
    {
        try {
            $key = $request->input('key');

            // Check if key already exists
            $isKey = LanguageSetting::where('key', $key)->first();

            if (!$isKey) {
                // If key does not exist, insert it
                $isKey = new LanguageSetting();
                $isKey->key = $key;
                $isKey->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Key added successfully',
                    'isKey' => $isKey,
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Key already exists',
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error in adding key'], 500);
        }
    }

    public function fetchDefaultLanguage(Request $request)
    {
        try {

            // $user_id = Auth::user()->token()->user_id;
            $statusId = $request->input('status_id');
            $language = "";

            if ($statusId) {
                $language = LanguageStatus::where('status', true)
                    ->where('status_id', $statusId)
                    ->first();
            } else {
                $language = LanguageStatus::where('default_status', true)->first();
            }

            if (!$language) {
                return response()->json([
                    'success' => false,
                    'message' => 'Language is not available',
                ], 404);
            }

            // $results = DB::table('language_settings')
            //     ->select('key', $language->language . ' as Translation')
            //     ->get();

            $results = DB::table('Language_settings')
                ->select('setting_id', 'key', DB::raw($language->language . ' as Translation'))
                // ->select('key', DB::raw("'" . $language->language . "' as Translation"))
                ->get();

            // dd($language);

            return response()->json([
                'language_alignment' => $language->language_alignment ?? "ltr",
                'success' => true,
                'message' => 'Language found',
                'language' => $language->language,
                'results' => $results,
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred',   'error' => $e->getMessage()], 500);
        }
    }

    public function fetchLanguageKeywordsWithTranslation(Request $request)
    {
        try {
            $page = $request->input('page_no', 1);
            $pageSize = $request->input('per_page', 10);
            $statusId = $request->input('status_id');

            $language = LanguageStatus::where('status_id', $statusId)->first();
            if (!$language) {
                return response()->json(['success' => false, 'message' => 'Language not found'], 404);
            }

            $offset = ($page - 1) * $pageSize;

            $results = DB::table('Language_settings')
                ->select('setting_id', 'key', DB::raw($language->language . ' as Translation'))
                ->offset($offset)
                ->limit($pageSize)
                ->get();

            $total = DB::table('Language_settings')->count();

            return response()->json([
                'success' => true,
                'message' => 'Language found',
                'language_alignment' => $language->language_alignment,
                'language' => $language->language,
                'results' => $results,
                'pagination' => [
                    'currentPage' => $page,
                    'pageSize' => $pageSize,
                    'totalItems' => $total,
                    'totalPages' => ceil($total / $pageSize),
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred'], 500);
        }
    }

    public function editKeyword(Request $request)
    {
        try {
            $statusId = $request->input('status_id');
            $settingId = $request->input('setting_id');
            $newValue = $request->input('newValue');

            $language = LanguageStatus::where('status_id', $statusId)->first();

            if (!$language || !$settingId || !$newValue) {
                return response()->json(['success' => false, 'message' => 'Missing required fields'], 400);
            }

            $updated = DB::table('Language_settings')
                ->where('setting_id', $settingId)
                ->update([$language->language => $newValue]);

            if ($updated) {
                return response()->json(['success' => true, 'message' => 'Keyword updated successfully']);
            } else {
                return response()->json(['success' => false, 'message' => 'Setting ID not found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred'], 500);
        }
    }

    public function addLanguageColumn_old(Request $request)
    {
        $request->validate([
            'language' => 'required|string|unique:Language_statuses,language'
        ]);

        $language = ucfirst($request->language);

        // Check if column already exists
        if (!Schema::hasColumn('Language_settings', $language)) {
            Schema::table('Language_settings', function (Blueprint $table) use ($language) {
                $table->string($language)->nullable();
            });

            // Update new column with default values (same as 'key')
            // LanguageSetting::query()->update([$language => \DB::raw('`key`')]);

            DB::statement("UPDATE Language_settings SET `$language` = `key`");


            // Add Language to LanguageStatus Table
            LanguageStatus::create([
                'language' => $language,
                'country' => 'Unknown',
                'language_alignment' => 'ltr',
                'status' => 1,
                'default_status' => 0,
            ]);

            return response()->json(['success' => true, 'message' => "Language '$language' added successfully."], 200);
        }

        return response()->json(['success' => false, 'message' => "Language '$language' already exists."], 400);
    }

    public function addLanguageColumn(Request $request)
    {
        $language = ucfirst($request->language);
        $validator = Validator::make($request->all(), [
            'language' => 'required|string|unique:Language_statuses,language'
        ]);

        if ($validator->fails()) {
            // return $this->sendError('Enter this field', $validator->errors(), 422);
            return response()->json(['success' => false, 'message' => "Language '$language' already exists."], 200);
        }




        // Case-insensitive check
        $is_check = LanguageStatus::whereRaw('LOWER(language) = ?', [strtolower($language)])->exists();

        if ($is_check) {
            return response()->json(['success' => false, 'message' => "Language '$language' already exists."], 400);
        }

        // Check if column already exists
        $columnExists = \DB::select("SHOW COLUMNS FROM Language_settings LIKE '$language'");
        if (count($columnExists) > 0) {
            return response()->json(['success' => false, 'message' => "Language '$language' already exists in the table."], 400);
        }

        Schema::table('Language_settings', function (Blueprint $table) use ($language) {
            $table->string($language)->nullable();
        });

        DB::statement("UPDATE Language_settings SET `$language` = `key`");

        // Add Language to LanguageStatus Table
        LanguageStatus::create([
            'language' => $language,
            'country' => 'Unknown',
            'language_alignment' => 'ltr',
            'status' => 1,
            'default_status' => 0,
        ]);

        return response()->json(['success' => true, 'message' => "Language '$language' added successfully."], 200);
    }


    public function translateAllKeywords_old(Request $request)
    {
        try {
            $status_id = $request->input('status_id');

            // Fetch language details from status_id
            $isLanguage = DB::table('Language_statuses')->where('status_id', $status_id)->first();

            // Validate status_id
            if (!$isLanguage) {
                return response()->json(['success' => false, 'message' => 'Invalid status_id'], 400);
            }

            // Get all settings data for translation
            $results = DB::select("SELECT setting_id, `key` FROM Language_settings");

            // Construct json_data for FastAPI based on fetched settings
            $jsonData = [];
            foreach ($results as $row) {
                $jsonData[$row->setting_id] = $row->key;
            }

            // Construct request data for FastAPI
            $requestData = [
                'json_data' => $jsonData,
                'target_language' => $isLanguage->language,
            ];
            // dd($requestData);


            \Log::info("Request Data to FastAPI: " . json_encode($requestData));

            // Make a POST request to FastAPI
            $apiUrl = "http://62.72.36.245:3692/translate/";
            $response = Http::post($apiUrl, $requestData);



            if ($response->failed()) {
                return response()->json(['success' => false, 'message' => 'Failed to get translation'], 500);
            }

            $translatedData = $response->json()['translated_data'];

            // Update database with translated values
            foreach ($translatedData as $setting_id => $translatedValue) {
                DB::update("UPDATE Language_settings SET `{$isLanguage->language}` = ? WHERE `setting_id` = ?", [$translatedValue, $setting_id]);
            }

            // Send successful response
            return response()->json([
                'success' => true,
                'message' => 'All keywords translated and updated successfully',
                'translated_data' => $translatedData,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error occurred while translating: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while translating',
            ], 500);
        }
    }

    public function translateAllKeywords_28_02(Request $request)
    {
        try {
            $status_id = $request->input('status_id');

            // Fetch language details from status_id
            $isLanguage = DB::table('Language_statuses')->where('status_id', $status_id)->first();

            // dd($isLanguage->language);

            // Validate status_id
            if (!$isLanguage) {
                return response()->json(['success' => false, 'message' => 'Invalid status_id'], 400);
            }

            // Get all settings data for translation
            $results = DB::select("SELECT setting_id, `key` FROM Language_settings");

            // Construct json_data in required format
            $jsonData = [];
            foreach ($results as $row) {
                $jsonData[$row->key] = $row->key; // Key will be used as a reference
            }

            // Construct request data for FastAPI
            $requestData = [
                'json_data' => (object) $jsonData,
                'target_language' => $isLanguage->language,
            ];


            // dd($requestData);

            \Log::info("Request Data to FastAPI: " . json_encode($requestData));

            // Make a POST request to FastAPI
            $apiUrl = "http://62.72.36.245:3692/translate/";
            $response = Http::post($apiUrl, $requestData);

            // dd($response);

            if ($response->failed()) {
                return response()->json(['success' => false, 'message' => 'Failed to get translation'], 500);
            }

            $translatedData = $response->json()['translated_data'];

            // Update database with translated values



            // Send successful response
            return response()->json([
                'success' => true,
                'message' => 'All keywords translated and updated successfully',
                'translated_data' => $translatedData,
            ]);
            // foreach ($translatedData as $key => $translatedValue) {
            //     DB::update("UPDATE Language_settings SET `{$isLanguage->language}` = ? WHERE `key` = ?", [$translatedValue, $key]);
            // }

            // // Send successful response
            // return response()->json([
            //     'success' => true,
            //     'message' => 'All keywords translated and updated successfully',
            //     'translated_data' => $translatedData,
            // ]);
        } catch (\Exception $e) {
            // \Log::error('Error occurred while translating: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while translating',
            ], 500);
        }
    }

    public function translateAllKeywords(Request $request)
    {
        try {
            $status_id = $request->input('status_id');

            // Fetch language details from status_id
            $isLanguage = DB::table('Language_statuses')->where('status_id', $status_id)->first();

            // Validate status_id
            if (!$isLanguage) {
                return response()->json(['success' => false, 'message' => 'Invalid status_id'], 400);
            }

            // Get all settings data for translation
            $results = DB::select("SELECT setting_id, `key` FROM Language_settings");

            // Construct json_data in required format
            $jsonData = [];
            foreach ($results as $row) {
                $jsonData[$row->key] = $row->key; // Key will be used as a reference
            }

            // Construct request data
            $requestData = [
                'json_data' => (object) $jsonData, // Force associative array to JSON object
                'target_language' => $isLanguage->language
            ];

            // Convert data to JSON
            $payload = json_encode($requestData, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);

            // FastAPI endpoint
            $apiUrl = "http://62.72.36.245:3692/translate/";

            // Initialize cURL session
            $ch = curl_init($apiUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Content-Type: application/json"
            ]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

            // ✅ Remove timeout restrictions to wait indefinitely
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);  // Wait indefinitely to connect
            curl_setopt($ch, CURLOPT_TIMEOUT, 0);        // Wait indefinitely for response

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);

            if ($response === false) {
                return response()->json(['success' => false, 'message' => 'cURL Error: ' . $curlError], 500);
            }

            if ($httpCode !== 200) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to get translation',
                    'status_code' => $httpCode,
                    'response' => $response
                ], 500);
            }

            $translatedData = json_decode($response, true)['translated_data'] ?? [];

            // ✅ Update database with translated values
            foreach ($translatedData as $key => $translatedValue) {
                DB::update("UPDATE Language_settings SET `{$isLanguage->language}` = ? WHERE `key` = ?", [$translatedValue, $key]);
            }

            // Send successful response
            return response()->json([
                'success' => true,
                'message' => 'All keywords translated and updated successfully',
                'translated_data' => $translatedData,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while translating: ' . $e->getMessage(),
            ], 500);
        }
    }


    public function updateStatus(Request $request)
    {
        try {
            // Validate the incoming request
            $validated = $request->validate([
                'status_id' => 'required|integer',
                'status' => 'nullable|boolean',
                'default_status' => 'nullable|boolean',
            ]);

            // Prepare the fields to update
            $payload = [];
            if ($request->has('status')) {
                $payload['status'] = $request->status;
            }
            if ($request->has('default_status')) {
                $payload['default_status'] = $request->default_status;
            }

            // If no valid fields, return an error response
            if (empty($payload)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No valid fields to update'
                ], 400);
            }

            // Handle default_status logic
            if ($request->default_status === true) {
                // Set default_status to false for all entries
                LanguageStatus::query()->update(['default_status' => false]);
            }

            // Update the status for the given status_id
            $languageStatus = LanguageStatus::findOrFail($request->status_id);
            $languageStatus->update($payload);

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating status: ' . $e->getMessage()
            ], 500);
        }
    }

    public function listAllLanguages()
    {
        try {
            // Fetch all languages
            $languages = LanguageStatus::all();

            // Check if any languages were found
            if ($languages->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No languages found'
                ], 404);
            }

            // Format the results
            $formattedLanguages = $languages->map(function ($language) {
                return [
                    'language' => $language->language,
                    'status' => $language->status, // Assuming `status` column exists
                    'default_status' => $language->default_status,
                    'status_id' => $language->status_id,
                    'country' => $language->country,
                    'language_alignment' => $language->language_alignment,
                ];
            });

            // Send the response
            return response()->json([
                'success' => true,
                'message' => 'Languages retrieved successfully',
                'languages' => $formattedLanguages
            ], 200);
        } catch (\Exception $e) {
            \Log::error('Error fetching languages: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred'
            ], 500);
        }
    }

    public function getLanguageDataFromStatusId(Request $request)
    {
        try {
            // Validate the incoming request
            $validated = $request->validate([
                'status_id' => 'required|integer',
            ]);

            // Fetch language data based on status_id
            $languageData = LanguageStatus::where('status_id', $request->status_id)->first();

            // Check if data is found
            if (!$languageData) {
                return response()->json([
                    'success' => false,
                    'message' => 'Language not found'
                ], 404);
            }

            // Send the language data as a response
            return response()->json([
                'success' => true,
                'data' => $languageData
            ], 200);
        } catch (\Exception $e) {
            \Log::error('Error fetching language data: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching language data'
            ], 500);
        }
    }
    public function editLanguage(Request $request)
    {
        try {
            // Validate the incoming request
            $validated = $request->validate([
                'status_id' => 'required|integer',
                'language_name' => 'nullable|string',
                'language_country' => 'nullable|string',
                'default_status' => 'nullable|boolean',
                'language_alignment' => 'nullable|string',
            ]);

            $statusId = $request->status_id;

            // Check if the language entry exists
            $currentLanguage = LanguageStatus::where('status_id', $statusId)->first(['language']);

            if (!$currentLanguage) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid status_id'
                ], 400);
            }

            // Prepare the fields to update
            $payload = [];
            if ($request->filled('language_name')) {
                $payload['language'] = $request->language_name;
            }
            if ($request->filled('language_country')) {
                $payload['country'] = $request->language_country;
            }
            if ($request->filled('language_alignment')) {
                $payload['language_alignment'] = $request->language_alignment;
            }
            if ($request->has('default_status')) {
                $payload['default_status'] = $request->default_status;
            }

            // If no valid fields, return an error response
            if (empty($payload)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No valid fields to update'
                ], 400);
            }

            // If language_name is updated, rename the column in LanguageSettings
            if (!empty($request->language_name) && $currentLanguage->language !== $request->language_name) {
                DB::statement("ALTER TABLE Language_settings CHANGE COLUMN `{$currentLanguage->language}` `{$request->language_name}` VARCHAR(255)");

                // Update the language name in LanguageStatus table
                LanguageStatus::where('status_id', $statusId)->update(['language' => $request->language_name]);
            }

            // Update the language details
            LanguageStatus::where('status_id', $statusId)->update($payload);

            return response()->json([
                'success' => true,
                'message' => 'Language updated successfully'
            ], 200);
        } catch (\Exception $e) {
            \Log::error('Error updating language: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating language'
            ], 500);
        }
    }

    public function fetchLanguages()
    {
        try {
            // Fetch all languages
            $languages = LanguageStatus::pluck('language');

            return response()->json([
                'success' => true,
                'languages' => $languages
            ], 200);
        } catch (\Exception $e) {
            \Log::error('Error fetching languages: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching languages'
            ], 500);
        }
    }
    public function translateoneKeywords(Request $request)
    {
        try {
            // Get the required inputs from the request
            $settingId = $request->input('setting_id');
            $status_id = $request->input('status_id');
            $newValue = $request->input('newValue');

            // Fetch language details based on status_id
            $isLanguage = DB::table('Language_statuses')->where('status_id', $status_id)->first();

            // Validate if the language for the provided status_id exists
            if (!$isLanguage) {
                return response()->json(['success' => false, 'message' => 'Invalid status_id'], 400);
            }

            // Fetch the specific setting record by setting_id
            $setting = DB::table('Language_settings')->where('setting_id', $settingId)->first();

            // Check if the setting exists
            if (!$setting) {
                return response()->json(['success' => false, 'message' => 'Invalid setting_id'], 400);
            }

            // Construct json_data for translation (based on `setting_id` and newValue)
            $jsonData = [
                $setting->key => $newValue // The key in Language_settings and the new value to be translated
            ];

            // Prepare request data to send to FastAPI
            $requestData = [
                'json_data' => $jsonData,
                'target_language' => $isLanguage->language,
            ];

            \Log::info("Request Data to FastAPI: " . json_encode($requestData));

            // Make a POST request to FastAPI for translation
            $apiUrl = "http://62.72.36.245:3692/translate/";
            $response = Http::post($apiUrl, $requestData);

            if ($response->failed()) {
                return response()->json(['success' => false, 'message' => 'Failed to get translation from FastAPI'], 500);
            }

            // Extract the translated value from FastAPI response
            $translatedData = $response->json()['translated_data'];

            // If translated data is returned, update the Language_settings table
            if (isset($translatedData[$setting->key])) {
                // Update the language field with the translated value
                DB::table('Language_settings')
                    ->where('setting_id', $settingId)
                    ->update([$isLanguage->language => $translatedData[$setting->key]]);

                // Send successful response with the updated translation
                return response()->json([
                    'success' => true,
                    'message' => 'Keyword translated and updated successfully',
                    'translated_data' => [
                        'setting_id' => $settingId,
                        'new_value' => $translatedData[$setting->key]
                    ],
                ]);
            } else {
                return response()->json(['success' => false, 'message' => 'Translation not found for the provided text'], 500);
            }
        } catch (\Exception $e) {
            \Log::error('Error occurred while translating: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while translating',
            ], 500);
        }
    }
}
