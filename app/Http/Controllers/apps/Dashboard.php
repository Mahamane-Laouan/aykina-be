<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Service;
use App\Models\Category;
use App\Models\Review;
use Illuminate\Http\Request;
use Carbon\Carbon;

class Dashboard extends Controller
{
  public function index()
  {
    $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

    $data = User::select('id', 'created_at')->get()->groupBy(function ($data) {
      return Carbon::createFromTimestamp($data->created_at)->format('M');
    });

    // // Total Services
    // $services = Service::all();
    // $totalServices = count($services);

    // // Total Categories
    // $categories = Category::all();
    // $totalCategories = count($categories);

    // // Total Reviews
    // $reviews = Review::all();
    // $totalReviews = count($reviews);

    $months = [];
    $monthCount = [];

    foreach ($monthNames as $monthName) {
      $months[] = $monthName;
      $monthCount[] = isset($data[$monthName]) ? count($data[$monthName]) : 0;
    }

    // Total Users
    $users = User::all();
    $totalUsers = count($users);
    return view('content.apps.dashboard', [
      'data' => $data,
      'months' => $months,
      'monthCount' => $monthCount,
      'users' => $users,
      'totalUsers' => $totalUsers,
      // 'totalServices' => $totalServices,
      // 'totalCategories' => $totalCategories,
      // 'totalReviews' => $totalReviews,
    ]);
  }
}
