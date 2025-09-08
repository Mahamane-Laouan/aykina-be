<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CouponListController extends Controller
{
    // index
    public function index(Request $request)
    {
        $search = $request->input('search');

        $records = Coupon::when($search, function ($query, $search) {
            return $query->where('code', 'LIKE', "%{$search}%");
        })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        if ($request->ajax()) {
            $recordsArray = $records->map(function ($record) {
                return [
                    'id' => $record->id,
                    'code' => $record->code,
                    'discount' => $record->discount,
                    'type' => $record->type,
                    'coupon_for' => $record->coupon_for,
                    'status' => $record->status,
                    'expire_date' => $record->expire_date
                        ? Carbon::parse($record->expire_date)->format('d M, Y / g:i A')
                        : null,
                    'edit_url' => route('coupon-edit', $record->id),
                ];
            });

            return response()->json(['records' => $recordsArray]);
        }

        // Format created_at date within the records for convenience
        $records->getCollection()->transform(function ($record) {
            $record->formatted_created_at = $record->expire_date
                ? Carbon::parse($record->expire_date)->format('d M, Y / g:i A')
                : '';
            return $record;
        });

        return view('coupon-list', compact('records', 'search'));
    }


    // addCoupon
    public function addCoupon()
    {
        return view('coupon-add');
    }


    // saveCoupon
    public function saveCoupon(Request $request)
    {
        $rules = [
            'code' => 'required',
            'discount' => 'required',
            'type' => 'required',
            'coupon_for' => 'required',
            'status' => 'required',
            'description' => 'required',
            'expire_date' => 'required|date_format:Y-m-d H:i:s',
        ];

        $customMessages = [
            'code.required' => 'The coupon code is required.',
            'discount.required' => 'Please specify the discount value.',
            'type.required' => 'Please select the type of discount (Percentage or Fixed).',
            'coupon_for.required' => 'Please specify the target audience or purpose of the coupon.',
            'status.required' => 'Please select the status of the coupon (active or inactive).',
            'description.required' => 'Please provide a description for the coupon.',
            'expire_date.required' => 'Please specify the expiration date of the coupon.',
        ];


        $this->validate($request, $rules, $customMessages);

        // Save coupon data
        $coupon = new Coupon();
        $coupon->code = $request->input('code');
        $coupon->discount = $request->input('discount');
        $coupon->type = $request->input('type');
        $coupon->coupon_for = $request->input('coupon_for');
        $coupon->status = $request->input('status');
        $coupon->description = $request->input('description');
        $coupon->expire_date = $request->input('expire_date');
        $coupon->save();

        return redirect()->route('coupon-list')->with('message', 'Coupon added successfully.');
    }


    // deleteCoupon
    public function deleteCoupon($id)
    {
        $data = Coupon::where('id', $id)->delete();
        return response()->json(['message' => 'Coupon deleted successfully']);
    }



    // editCoupon
    public function editCoupon($id)
    {
        $user = Coupon::find($id);
        return view('coupon-edit', compact('user'));
    }


    // updateCoupon
    public function updateCoupon($id, Request $request)
    {
        $user = Coupon::find($id);
        $user->status = $request->input('status');
        $user->save();

        return redirect()->route('coupon-list')->with('message', 'Coupon updated successfully');
    }


    // changeCouponStatus 
    public function
    changeCouponStatus($id)
    {
        // Check the current status
        $currentType = Coupon::where('id', $id)->value('status');

        // Toggle the status (1 -> 0, 0 -> 1)
        $status = $currentType == 1 ? 0 : 1;

        // Update the status
        $updated = Coupon::where('id', $id)->update(['status' => $status]);

        if ($updated) {
            return response()->json(['message' => 'Status changed successfully']);
        } else {
            return response()->json(['message' => 'Failed to change status'], 500);
        }
    }
}
