<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{
    // index
    public function index(Request $request)
    {
        $allowedRoutes = [
            base64_decode('dmFsaWRhdGU='),
            base64_decode('YXBpL3ZhbGlkYXRlUHVyY2hhc2U='),
            base64_decode('YXBpL3ZlcmlmeVRva2Vu'),
            '/',
            base64_decode('Y2hlY2stZGlyZWN0b3JpZXM=')
        ];

        if (!$request->is($allowedRoutes)) {
            if (!$this->verifyToken()) {
                abort(400, 'Unauthorized or invalid token.');
            }
        }

        return view('auth.login');
    }




    public function login(Request $request)
    {
        $rules = [
            'email' => 'required',
            'password' => 'required',
        ];

        $customMessages = [
            'email.required' => 'Please enter your email',
            'password.required' => 'Please enter your password',
        ];

        $this->validate($request, $rules, $customMessages);

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::guard('admin')->user();

            if ($user->id == 1) {
                return redirect()->route('admin-dashboard');
            } else {
                if ($user->people_id == 1) {
                    return redirect()->route('provider-dashboard');
                } else {
                    return redirect()->route('handyman-dashboard');
                }
            }
        } else {
            return back()->with('error', 'Wrong credentials, please try again.');
        }
    }


    private function verifyToken()
    {
        try {
            $tokenFilePath = storage_path('app/validatedToken.txt');

            if (!File::exists($tokenFilePath)) {
                Log::error("Token file not found: " . $tokenFilePath);
                return false;
            }

            $token = trim(File::get($tokenFilePath));

            $response = Http::post(base64_decode("aHR0cHM6Ly92YWxpZGF0b3Iud2hveGFjaGF0LmNvbS92ZXJpZnlfbmV3"), [
                'server_ip' => request()->ip(),
                'mac_address' => exec('getmac'),
                'token' => $token,
            ]);

            $data = $response->json();

            Log::info('Verification API Response:', $data);

            if (!isset($data['success']) || !$data['success']) {
                Log::error("Token verification failed.");
                return false;
            }

            return true;
        } catch (\Exception $e) {
            Log::error('Token verification error:', ['exception' => $e->getMessage()]);
            return false;
        }
    }




    // logout
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('login');
    }
}
