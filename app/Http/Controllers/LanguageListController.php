<?php

namespace App\Http\Controllers;

use App\Models\LanguageStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Validator;
use Illuminate\Http\Request;

class LanguageListController extends Controller
{
    // index
    public function index(Request $request)
    {
        $search = $request->input('search');

        $records = LanguageStatus::when($search, function ($query, $search) {
            return $query->where('category_name', 'LIKE', "%{$search}%");
        })
            ->orderBy('created_at', 'desc')
            ->paginate(10);


        return view('language-list', compact('records', 'search'));
    }



    // languageTranslateList
    public function languageTranslateList($id)
    {
        $records = LanguageStatus::where('status_id', $id)
            ->orderBy('created_at', 'desc')
            ->paginate(10); // Show only 10 entries per page

        return view('language-translatelist', compact('records'));
    }


    // addLanguageDynamic
    public function addLanguageDynamic()
    {
        return view('language-add');
    }


    public function saveLanguageDynamic(Request $request)
    {
        $language = ucfirst($request->language);

        $rules = [
            'language' => 'required|string|unique:language_statuses,language',
            'language_alignment' => 'required|in:ltr,rtl',
        ];

        $customMessages = [
            'language.required' => 'Please enter language name.',
            'language_alignment.required' => 'Please select language alignment.',
        ];

        $this->validate($request, $rules, $customMessages);


        // Case-insensitive check to prevent duplicates
        $is_check = LanguageStatus::whereRaw('LOWER(language) = ?', [strtolower($language)])->exists();
        if ($is_check) {
            return response()->json(['success' => false, 'message' => "Language '$language' already exists."], 400);
        }

        // Check if the language column already exists in the Language_settings table
        $columnExists = \DB::select("SHOW COLUMNS FROM language_settings LIKE '$language'");
        if (count($columnExists) > 0) {
            return response()->json(['success' => false, 'message' => "Language '$language' already exists in the table."], 400);
        }

        // Add new language column to language_settings table
        Schema::table('language_settings', function (Blueprint $table) use ($language) {
            $table->string($language)->nullable();
        });

        // Update the table with the new column
        DB::statement("UPDATE language_settings SET `$language` = `key`");

        // Store the language in the LanguageStatus table
        LanguageStatus::create([
            'language' => $language,
            'country' => 'Unknown',
            'language_alignment' => $request->language_alignment,
            'status' => 1,
            'default_status' => 0,
        ]);

        return redirect()
            ->route('language-list')
            ->with('message', 'Language added successfully.');;
    }



    // Edit Language
    // Edit Language
    public function editLanguageDynamic($status_id)
    {
        $language = LanguageStatus::where('status_id', $status_id)->firstOrFail();

        return view('language-edit', [
            'language' => $language,
        ]);
    }

    // Update Language
    public function updateLanguageDynamic($status_id, Request $request)
    {
        try {
            // Validate the incoming request
            $validated = $request->validate([
                'language' => 'required|string',
                'language_country' => 'nullable|string',
                'default_status' => 'nullable|boolean',
                'language_alignment' => 'nullable|string',
            ]);

            $language = LanguageStatus::where('status_id', $status_id)->firstOrFail();

            // Prepare the fields to update
            $payload = [
                'language' => $validated['language'],
                'country' => $validated['language_country'] ?? $language->country,
                'default_status' => $validated['default_status'] ?? $language->default_status,
                'language_alignment' => $validated['language_alignment'] ?? $language->language_alignment,
            ];

            // If language name changes, rename column in LanguageSettings
            if ($language->language !== $validated['language']) {
                DB::statement("ALTER TABLE Language_settings CHANGE COLUMN `{$language->language}` `{$validated['language']}` VARCHAR(255)");
            }

            // Update the language details
            $language->update($payload);

            return redirect()
                ->route('language-list')
                ->with('message', 'Language updated successfully.');
        } catch (\Exception $e) {
            \Log::error('Error updating language: ' . $e->getMessage());

            return redirect()
                ->back()
                ->with('error', 'An error occurred while updating language.');
        }
    }


    // changeLanguageListStatus
    public function
    changeLanguageListStatus($id)
    {
        // Check the current status
        $currentType = LanguageStatus::where('status_id', $id)->value('status');

        // Toggle the status (1 -> 0, 0 -> 1)
        $status = $currentType == 1 ? 0 : 1;

        // Update the status
        $updated = LanguageStatus::where('status_id', $id)->update(['status' => $status]);

        if ($updated) {
            return response()->json(['message' => 'Status changed successfully']);
        } else {
            return response()->json(['message' => 'Failed to change status'], 500);
        }
    }


    // Controller Method
    public function changeLanguageListeDefaultStatus(Request $request)
    {
        try {
            // Validate the incoming request
            $validated = $request->validate([
                'status_id' => 'required|integer',
                'default_status' => 'required|boolean',
            ]);

            // If `default_status` is set to 1, set all others to 0 first
            if ($request->default_status == 1) {
                LanguageStatus::query()->update(['default_status' => 0]);
            }

            // Update the requested status_id
            $languageStatus = LanguageStatus::findOrFail($request->status_id);
            $languageStatus->update(['default_status' => $request->default_status]);

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
}
