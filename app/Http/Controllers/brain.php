<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash; // Import this for password security!

use Illuminate\Http\Request;

class brain extends Controller
{
    /*
    Mega's Comment Dictionary

    TODO -> to be completed later
    FIXME -> glitchy/need to be fixed
    NOTE -> important piece of information
    HACK -> workaround, or temporary code.
    BUG -> unfixed bug
    XXX -> very, VERY BAD.
    REVIEW -> flag a code so someone should look at this
    OPTIMIZE -> code could be faster/lighter

    if you have better comments extension:
    ! = red -> alerts/warning
    ? = blue -> question
    * = green -> highlights
    */

    public function login(Request $request)
{
    // 1. VALIDATION
    $credentials = $request->validate([
        'username' => 'required',
        'password' => 'required',
    ]);

    // 2. ATTEMPT LOGIN
    // Auth::attempt() does three things automatically:
    // a. Checks database for 'username'
    // b. Hashes the input password and compares it with the DB hash
    // c. Starts a secure login session if they match
    if (Auth::attempt($credentials)) {
        
        // Security best practice: prevent "Session Fixation" attacks
        $request->session()->regenerate();

        // Redirect to intended page (or default to dashboard/home)
        // TODO change the page destination i guess
        return redirect()->intended('dashboard')->with('success', 'Logged in successfully!');
    }

    // 3. IF LOGIN FAILS
    // 'back()' sends them to the login form. 
    // 'onlyInput' keeps the username filled in so they don't have to retype it.
    return back()->withErrors([
        'username' => 'The provided credentials do not match our records.',
    ])->onlyInput('username');
}

    public function register(Request $request)
    {
        // 1. VALIDATION
        // If this fails, Laravel automatically redirects back with error messages.
      // You do NOT need manual "if" statements or redirects.
      $validated = $request->validate([
          'username' => 'required|unique:users,username', // TODO change the table and column it check right now, currently it checks 'users' table, 'username' column
          'password' => 'required',                       // hey, i want your password
          'conpass'  => 'required|same:password'          // hey, i'm supposed to be the twin of password
        ]);

       // 2. SAVING TO DATABASE
        // We use the 'create' method. 
        // CRITICAL: Never save a password as plain text. Use Hash::make()
      User::create([
           'username' => $request->username,
           'password' => Hash::make($request->password), 
      ]);

      // 3. SUCCESS REDIRECT
     //TODO change the route destination
    return redirect()->route('login')->with('success', 'Registration successful! Please login.');
}

    public function logout(Request $request){
       // 1. Log the user out of the Auth system
        Auth::logout();

        // 2. Invalidate the generic PHP Session 
        // (This kills the session ID so it can't be reused by hackers)
        $request->session()->invalidate();

        // 3. Regenerate the CSRF Token
        // (Prevents Cross-Site Request Forgery attacks on the next form submission)
        $request->session()->regenerateToken();

        // 4. Redirect (Don't return a view directly!)
        //TODO change the destination
        return redirect()->route('home'); // or '/'
    }
    


}
