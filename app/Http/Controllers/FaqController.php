<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FaqController extends Controller
{

    // index
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Get the currently authenticated admin user
        $user = Auth::guard('admin')->user();

        // Check if the user is a provider
        $providerId = $user->id;

        // Fetch FAQs specific to the logged-in provider with optional search functionality
        $records = Faq::with([
            'service' => function ($query) {
                $query->select('id', 'service_name');
            }
        ])
            ->whereHas('service', function ($query) use ($providerId) {
                // Ensure the service belongs to the logged-in provider
                $query->where('user_id', $providerId);
            })
            ->when($search, function ($query, $search) {
                // Apply search filter to FAQ title
                $query->where('title', 'LIKE', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        if ($request->ajax()) {
            $recordsArray = $records->map(function ($record) {
                return [
                    'id' => $record->id,
                    'title' => $record->title ?? '',
                    'description' => $record->description ?? '',
                    'service_name' => $record->service->service_name ?? '',
                    'service_url' => $record->service && $record->service->id
                        ? route('providerservice-edit', $record->service->id) // Ensure service ID is passed
                        : null,
                    'edit_url' => route('faq-edit', $record->id),
                ];
            });

            return response()->json(['records' => $recordsArray]);
        }

        return view('faq-list', compact('records', 'search'));
    }


    //  addFaq
    public function addFaq()
    {
        $user = Auth::guard('admin')->user(); // Get the logged-in user
        $providerId = $user->id; // Logged-in provider's ID

        // Fetch services related to the provider
        $services = Service::where('v_id', $providerId)
            ->select('id', 'service_name') // Only fetch required columns
            ->get();

        return view('faq-add', compact('services'));
    }


    // saveFaq
    public function saveFaq(Request $request)
    {
        $rules = [
            'title' => 'required',
            'description' => 'required',
            'servce_id' => 'required|exists:services,id', // Validate service_id
        ];

        $customMessages = [
            'title.required' => 'Please enter a question.',
            'description.required' => 'Please enter an answer.',
            'servce_id.required' => 'Please select a service.',
            'servce_id.exists' => 'The selected service is invalid.',
        ];

        $this->validate($request, $rules, $customMessages);

        $user = Auth::guard('admin')->user(); // Get the logged-in user

        $faq = new Faq();
        $faq->title = strip_tags($request->input('title'));
        $faq->description = strip_tags($request->input('description'));
        $faq->service_id = $request->input('servce_id'); // Assign selected service
        $faq->user_id = $user->id; // Assign the logged-in provider's ID
        $faq->save();

        return redirect()->route('faq-list')->with('message', 'FAQ added successfully.');
    }


    // editFaq
    public function editFaq($id)
    {
        $faq = Faq::findOrFail($id);

        $user = Auth::guard('admin')->user(); // Get the logged-in admin user
        $providerId = $user->id; // Logged-in provider's ID

        // Fetch services related to the provider
        $services = Service::where('v_id', $providerId)
            ->select('id', 'service_name') // Fetch only necessary columns
            ->get();

        return view('faq-edit', compact('services', 'faq'));
    }


    // updateFaq
    public function updateFaq($id, Request $request)
    {
        // Update FAQ
        $faq = Faq::findOrFail($id);
        $faq->title = strip_tags($request->input('title'));
        $faq->description = strip_tags($request->input('description'));
        $faq->service_id = $request->input('service_id');

        $faq->save();

        return redirect()->route('faq-list')->with('message', 'FAQ updated successfully');
    }


    // deleteFaq
    public function deleteFaq($id)
    {
        $data = Faq::where('id', $id)->delete();
        return response()->json(['message' => 'Faq deleted successfully']);
    }
}
