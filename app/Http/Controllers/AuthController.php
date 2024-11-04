<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Outlet;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Password;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Auth\Events\PasswordReset;

class AuthController extends Controller
{
    // SHOW FORM
    public function showLoginForm(){
        return view('login');
    }
    public function showRegisterForm()
    {
        return view('register');
    }

    public function showEditForm($uid)
    {
        // Get the authenticated user
        $user = User::where('uid', $uid)->firstOrFail();

        // Check if the authenticated user's UID matches the one in the URL
        if ($user->uid !== $uid) {
            // If the UIDs do not match, redirect the user or show a 403 error
            abort(403, 'Unauthorized access');
        }

        // If the UIDs match, show the edit profile form
        return view('edit-profile', [
            'user' => $user,
        ]);
    }


    public function showLupaPasswordForm(){
        return view('lupa-password');
    }
    public function showResetPasswordForm(Request $request,$token){
        return view('reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    // LOGIN MANUAL
    public function login(Request $request){
        // Validate the incoming request data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        // Attempt to log the user in
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Authentication successful, redirect to intended page or home
            if(Auth::user()->role === 'Admin'){
                return redirect()->route('admin-dashboard')->with('success', 'Selamat Datang! ' . Auth::user()->name);
            }else{
                return redirect()->intended('/')->with('success', 'Selamat Datang! ' . Auth::user()->name);
            }
        }

        // If login fails, redirect back with an error message
        return back()->withErrors(['email' => 'Email atau password salah!!']);
    }

    public function logout(Request $request){
        Auth::logout();

        // Optionally, invalidate the session
        $request->session()->invalidate();

        // Regenerate the session token
        $request->session()->regenerateToken();

        return redirect('/')->with('success','Anda berhasil Logout!'); 
    }

    // LOGIN WITH GOOGLE
    public function redirectGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    public function callbackGoogle()
    {
        try {
            $google_user = Socialite::driver('google')->user();

            // Check if a user with the Google ID exists
            $user = User::where('google_id', $google_user->getId())->first();

            // If the user doesn't exist, check for the email first
            if (!$user) {
                // Check for existing user by email
                $existing_user = User::where('email', $google_user->getEmail())->first();

                // If an existing user with the same email is found, associate the Google ID
                if ($existing_user) {
                    $existing_user->update([
                        'google_id' => $google_user->getId(), // Associate Google ID
                        'email_verified_at' => now(), // Auto-verify email
                    ]);
                    $user = $existing_user; // Set user to existing user
                } else {
                    // If no user exists with the same email, create a new user
                    $user = User::create([
                        'name' => $google_user->getName(),
                        'email' => $google_user->getEmail(),
                        'google_id' => $google_user->getId(),
                        'role' => 'User',
                        'email_verified_at' => now(), // Auto-verify email

                    ]);
                }

                // Log in the user
                Auth::login($user);
            } else {
                // Log in the user if found by Google ID
                Auth::login($user);
            }

            // Redirect with success message
            return redirect()->intended('/')->with('success', 'Selamat Datang ' . $user->name);
        } catch (\Throwable $th) {
            dd('Something Went Wrong! ' . $th->getMessage());
        }
    }

    // LOGIN WITH FACEBOOK
    public function redirectFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    // KOCAK WKWK (TIDAK TERPAKAI)
    public function pdfLogin(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'pdf' => 'required|mimes:pdf',
        ]);

        // Get the file from the request
        $pdfFile = $request->file('pdf');

        return redirect()->intended('home')->with('success', 'Successfully logged in with PDF.');
    }

    // RANDOM UID
    function generateUid()
    {
        // Menghasilkan 2 huruf kapital acak
        $letters = strtoupper(Str::random(2));

        // Menghasilkan 3 angka acak
        $numbers = rand(000, 999);

        // Menggabungkan huruf dan angka
        return $letters . $numbers;
    }

    // REGISTER USER
    public function Register(Request $request)
    {
        // Validate the form data
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
            ],
        ]);

        // Create a new user
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = 'User';
        $user->status = 'Aktif';
        $user->password = bcrypt($request->password);
        $user->remember_token = Str::random(40);
        $user->uid = $this->generateUid();
        $user->save();

        // Trigger email verification
        event(new Registered($user));

        // Redirect to verification notice
        return redirect()->route('verification.notice');
    }

    // CEK EMAIL USER
    public function checkEmailUser(Request $request)
    {
        // Validate the email input
        $request->validate([
            'email' => 'required|email',
        ]);

        // Check if the email exists in the database
        $emailExists = User::where('email', $request->email)->exists();

        // Return a JSON response
        return response()->json([
            'exists' => $emailExists,
        ]);
    }

    // CEK EMAIL OUTLET
    public function checkEmailOutlet(Request $request)
    {
        // Validate the email input
        $request->validate([
            'email' => 'required|email',
        ]);

        // Check if the email exists in the database
        $emailExists = Outlet::where('email', $request->email)->exists();

        // Return a JSON response
        return response()->json([
            'exists' => $emailExists,
        ]);
    }

    // LUPA PASSWORD
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    // UPDATE PASSWORD
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
            ],
        ]);

        // Debugging
        Log::info('Reset Password Request:', $request->all());

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => bcrypt($password),
                ])->setRememberToken(Str::random(60));

                $user->save();
                event(new PasswordReset($user));
            }
        );

        // Debugging the status
        Log::info('Password Reset Status:', ['status' => $status]);

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    // VERIFIKASI TANGGAL LAHIR
    public function verifyDateOfBirth(Request $request)
    {
        // Validate that the 'date' field is required and is a valid date
        $request->validate([
            'date' => 'required|date|date_format:Y-m-d', // Ensure the format is YYYY-MM-DD
        ]);

        // Get the authenticated user
        $user = Auth::user();

        // Check if the date from the request matches the user's 'tanggal_lahir'
        $isValid = $user->tanggal_lahir === $request->date;

        // Return the validation result as a JSON response
        return response()->json(['isValid' => $isValid]);
    }
}
