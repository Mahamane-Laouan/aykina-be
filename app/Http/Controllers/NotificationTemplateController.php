<?php

namespace App\Http\Controllers;

use App\Models\NotificationsPermissions;
use Illuminate\Http\Request;

class NotificationTemplateController extends Controller
{
    // index
    public function index(Request $request)
    {
        $search = $request->input('search');
   
        $records = NotificationsPermissions::when($search, function ($query, $search) {
            return $query->where('title', 'LIKE', "%{$search}%");
        })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        if ($request->ajax()) {
            $recordsArray = $records->map(function ($record) {
                return [
                    'id' => $record->id,
                    'role_type' => $record->role_type,
                    'label' => $record->label,
                    'title' => $record->title,
                    'notify_desc' => $record->notify_desc,
                    'status' => $record->status,
                    'edit_url' => route('notification-templateedit', $record->id),
                ];
            });

            return response()->json(['records' => $recordsArray]);
        }

        return view('notification-template', compact('records', 'search'));
    }


    // editNotificationTemplate
    public function editNotificationTemplate($id)
    {
        $notifytemp = NotificationsPermissions::findOrFail($id);

        return view('notification-templateedit', [
            'notifytemp' => $notifytemp,
        ]);
    }


    // updateNotificationTemplate
    public function updateNotificationTemplate($id, Request $request)
    {
        // Find the notification template by ID
        $notificationTemplate = NotificationsPermissions::find($id);

        // Remove only <p> tags, keep other tags intact
        $description = $request->input('description');
        $description = preg_replace('/<\/?p>/i', '', $description); // Remove <p> and </p> tags

        // Update the template with the new values from the form
        $notificationTemplate->title = $request->input('title');
        $notificationTemplate->description = $description;  // Use the modified description
        $notificationTemplate->notify_desc = $request->input('notify_desc');
        $notificationTemplate->status = $request->input('status');

        // Save the updated notification template
        $notificationTemplate->save();

        // Redirect with a success message
        return redirect()->route('notification-template')->with('message', 'Notification Template updated successfully');
    }



    // changeNotificationTemplateStatus 
    public function
    changeNotificationTemplateStatus($id)
    {
        // Check the current status
        $currentType = NotificationsPermissions::where('id', $id)->value('status');

        // Toggle the status (1 -> 0, 0 -> 1)
        $status = $currentType == 1 ? 0 : 1;

        // Update the status
        $updated = NotificationsPermissions::where('id', $id)->update(['status' => $status]);

        if ($updated) {
            return response()->json(['message' => 'Status changed successfully']);
        } else {
            return response()->json(['message' => 'Failed to change status'], 500);
        }
    }
}
