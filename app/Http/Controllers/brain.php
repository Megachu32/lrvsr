<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Models\Post;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Vote;
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

    //home function
    public function home() {
    
        $communities = Community::all(); 
        $posts = Post::with('user')
        ->withCount('comments')
        ->withSum('votes', 'vote_type') // ONLY sums them (adds 'votes_sum')
        ->with(['votes' => function($query) {
                $query->where('user_id', Auth::id());
        }])
        ->with(['comments' => function($query) {
            $query->whereNull('parent_id')->latest()->take(3); 
        }])
        // Also load the replies for those comments (we limit these in the view for simplicity)
        ->with('comments.replies.user') 
        ->latest()
        ->take(5)
        ->get();
        return view('home.index', compact('communities', 'posts'));
    }

    //login function
    public function login(Request $request)
    {
        // dd("masuk login");
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
            
            // dd("berhasil login");
            // Security best practice: prevent "Session Fixation" attacks
            $request->session()->regenerate();

            // Redirect to intended page (or default to dashboard/home)
            // TODO change the page destination i guess
            // return redirect()->intended('dashboard')->with('success', 'Logged in successfully!');
            return redirect()->route('home')->with('success', 'Logged in successfully!');
        }

        // 3. IF LOGIN FAILS
        // 'back()' sends them to the login form. 
        // 'onlyInput' keeps the username filled in so they don't have to retype it.
        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->onlyInput('username');
    }

    //register function
    public function register(Request $request)
    {
        // 1. VALIDATION
        // If this fails, Laravel automatically redirects back with error messages.
        // You do NOT need manual "if" statements or redirects.
        $validated = $request->validate([
            'username' => 'required', // TODO change the table and column it check right now, currently it checks 'users' table, 'username' column
            'password' => 'required',         
            'email' => 'required|email|unique:users,email',               // hey, i want your password
            ]);

        // 2. SAVING TO DATABASE
            // We use the 'create' method. 
            // CRITICAL: Never save a password as plain text. Use Hash::make()
        User::create([
            'username' => $request->username,
            'password' => $request->password, 
            'role_id' => 2, // Default role as 'regular user'
            'email' => $request->email,
        ]);

        // 3. SUCCESS REDIRECT
        //TODO change the route destination
        return redirect()->route('login')->with('success', 'Registration successful! Please login.');
    }

    //logout function
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
        return redirect()->route('login'); // or '/'
    }

    // Function to show the Create Community Page
    public function createCommunity(Request $request)
    {
        return view('community.create');
        
    }
    // Function to show the Create Post Page
    public function createPost() {
        // 2. FETCH DATA FROM DATABASE
        // This gets every single row from the 'communities' table
        $communities = Community::all(); 

        // 3. SEND TO VIEW
        // 'compact' is a PHP helper that passes the $communities variable 
        // to the view so you can use it there.
        return view('post.create', compact('communities'));
    }
    
    //function to handle community creation form submission
    public function postCommunity(Request $request)
    {
// 1. VALIDATION (Add this!)
        // This stops the code if 'name' is missing, empty, or already taken.
        $request->validate([
            'name' => 'required|string|max:255|unique:communities,name',
            'description' => 'nullable|string',
        ]);

        // 2. Create the Community
        $community = Community::create([
            'name' => $request->name, // Now we know this is safe
            'description' => $request->description,
            'creator_id' => Auth::id(),
        ]);

        // 3. Subscribe the creator as 'admin'
        Subscription::create([
            'user_id' => Auth::id(),
            'community_id' => $community->community_id,
            'role' => 'admin'
        ]);
// dd("masuk");
        return redirect()->route('community.view', $community->community_id);
    }

    //function to handle post creation form submission
    public function postPost(Request $request)
    {
        // 1. VALIDATION
        // Ensure the user actually selected a community and typed a title
        $validated = $request->validate([
            'community_id' => 'required|exists:communities,community_id',
            'title'        => 'required|max:255',
            'content'      => 'nullable', // Content can be empty
        ]);

        // 2. CREATE THE POST
        Post::create([
            'user_id'      => Auth::id(), // Takes the ID of the currently logged-in user
            'community_id' => $request->community_id,
            'title'        => $request->title,
            'content'      => $request->content,
        ]);

        // 3. REDIRECT
        // Send them back to the home page with a success message
        $community = Community::findOrFail($request->community_id);

        // 2. FETCH POSTS IN THIS COMMUNITY (optional)
        $posts = $community->posts()
            ->with('user')            // Load the full User data (so you can see names)
            ->withCount('comments')   // ONLY counts them (adds 'comments_count')
            ->withCount('votes')      // ONLY counts them (adds 'votes_count')
            ->get();

        // 3. RETURN THE VIEW WITH DATA
        return view('community.index', compact('community', 'posts'));
    }

    public function viewCommunity($id) {
        // 1. FETCH THE COMMUNITY BY ID
        // The "Gold Standard" way
        $community = Community::with('rules')
            ->withCount('subscribers')
            ->findOrFail($id);       
            
         // 2. FETCH POSTS IN THIS COMMUNITY (optional)
        $posts = $community->posts()
            ->with('user')              // Load the full User data (so you can see names)
            ->withCount('comments')     // ONLY counts them (adds 'comments_count')
            ->withSum('votes', 'vote_type') // ONLY sums them (adds 'votes_sum')
            ->with(['votes' => function($query) {
                $query->where('user_id', Auth::id());
            }])
            ->latest()                  // Order by newest first
            ->get();

        $user = Auth::user();   

        // 3. RETURN THE VIEW WITH DATA
        return view('community.index', compact('community', 'posts', 'user'));
    }

    public function joinCommunity($id) {
        $community = Community::findOrFail($id);
        $user = Auth::user();

        // Attach the user to the community's subscribers
        if ($community->subscribers()->where('users.user_id', $user->user_id)->exists()) {
            return redirect()->route('community.view', $id)->with('info', 'You are already a member of this community.');
        }

        $community->subscribers()->attach($user->user_id);

        return redirect()->route('community.view', $id)->with('success', 'You have joined the community!');
    }

    public function vote(Request $request)
    {
        // 1. Validate
        $request->validate([
            'post_id' => 'required|exists:posts,post_id',
            'vote_type' => 'required|in:1,-1', // 1 = Up, -1 = Down
        ]);

        $user_id = Auth::id();
        $post_id = $request->post_id;
        $new_vote_value = (int)$request->vote_type;

        // 2. Check if user already voted on this post
        $existing_vote = Vote::where('user_id', $user_id)
                            ->where('post_id', $post_id)
                            ->first();

        if ($existing_vote) {
            // SCENARIO A: User clicked the SAME arrow again (Undo vote)
            if ($existing_vote->vote_type === $new_vote_value) {
                $existing_vote->delete();
                return back(); // No message needed, just refreshes
            } 
            
            // SCENARIO B: User changed their mind (Up -> Down or Down -> Up)
            else {
                $existing_vote->update(['vote_type' => $new_vote_value]);
                return back();
            }
        }

        // SCENARIO C: New Vote (User hasn't voted yet)
        Vote::create([
            'user_id' => $user_id,
            'post_id' => $post_id,
            'vote_type' => $new_vote_value
        ]);

        return back();
    }

    public function search(Request $request)
    {
        $query = $request->input('q'); // Get the word from the search bar

        // 1. If search is empty, just return an empty view
        if (!$query) {
            return view('search.index', ['posts' => [], 'communities' => [], 'users' => [], 'query' => '']);
        }

        // 2. Search POSTS (Title or Content matches)
        $posts = \App\Models\Post::where('title', 'LIKE', "%{$query}%")
                    ->orWhere('content', 'LIKE', "%{$query}%")
                    ->with(['user', 'community'])   // Load related data
                    ->withCount('comments')         // Count comments
                    ->withSum('votes', 'vote_type') // Sum votes
                    ->latest()
                    ->get();

        // 3. Search COMMUNITIES (Name or Description matches)
        $communities = \App\Models\Community::where('name', 'LIKE', "%{$query}%")
                    ->orWhere('description', 'LIKE', "%{$query}%")
                    ->get();

        // 4. Search USERS (Username matches)
        $users = \App\Models\User::where('username', 'LIKE', "%{$query}%")
                    ->get();

        // 5. Send everything to the view
        return view('search.index', compact('posts', 'communities', 'users', 'query'));
    }

    // 1. SHOW EDIT FORM
    public function editPost($id)
    {
        $post = \App\Models\Post::findOrFail($id);

        // Security Check: Is the logged-in user the author?
        if (Auth::id() !== $post->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Return a view similar to your create post view, but with data pre-filled
        return view('post.edit', compact('post'));
    }

    // 2. UPDATE POST
    public function updatePost(Request $request, $id)
    {
        $post = \App\Models\Post::findOrFail($id);

        if (Auth::id() !== $post->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        $post->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        $community = Community::findOrFail($post->community_id);

        // 2. FETCH POSTS IN THIS COMMUNITY (optional)
        $posts = $community->posts()
            ->with('user')            // Load the full User data (so you can see names)
            ->withCount('comments')   // ONLY counts them (adds 'comments_count')
            ->withCount('votes')      // ONLY counts them (adds 'votes_count')
            ->get();

        // 3. RETURN THE VIEW WITH DATA
        return view('community.index', compact('community', 'posts'));
    }

    // 3. DELETE POST
    public function deletePost($id)
    {
        $post = \App\Models\Post::findOrFail($id);

        if (Auth::id() !== $post->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $post->delete();

        return redirect()->back()->with('success', 'Post deleted successfully!');
    }

    // 1. Show the Management Page
    public function settings($id)
    {
        $community = Community::findOrFail($id);
        $currentUser = Auth::user();
        
        // GET MY ROLE
        $mySubscription = \App\Models\Subscription::where('user_id', $currentUser->user_id)
                            ->where('community_id', $id)
                            ->first();

        // SECURITY: Allow Global Admins (role_id 1) OR Community Admins/Moderators\
        if ($currentUser->role_id == 2) { 
            // If NOT a Global Admin, check their community-specific role
                    // dd("s");

            if (!$mySubscription || $mySubscription->role === 'member') {
                abort(403, 'You are not authorized to manage this community.');
            }
        }

        // Get all members of this community to display in a list
        // We assume Subscription has a 'user' relationship defined
        $members = \App\Models\Subscription::where('community_id', $id)
                    ->with('user')
                    ->get();
        return view('community.settings', compact('community', 'members', 'mySubscription', 'currentUser'));
    }

    // 2. Change a User's Role (Promote/Demote/Ban)
    public function updateRole(Request $request, $community_id)
    {
        // Find the member we want to change
        $targetSub = \App\Models\Subscription::where('community_id', $community_id)
                        ->where('user_id', $request->user_id)
                        ->firstOrFail();

        // Apply the new role sent from the form
        if ($request->has('role')) {
            $targetSub->update(['role' => $request->role]);
        }

        // Handle Banning
        if ($request->has('ban')) {
            $targetSub->update(['is_banned' => true]);
            // Optional: Delete their posts if needed
        }

        return back()->with('success', 'Member updated successfully.');
    }

    public function adminDashboard()
    {
        // SECURITY CHECK: Only allow the user with ID 1 (You) to access this
        if (Auth::user()->role_id !== 1) {
            abort(403, 'Access Denied. Super Admin only.');
        }

        // 1. Fetch Stats
        $stats = [
            'users' => \App\Models\User::count(),
            'communities' => \App\Models\Community::count(),
            'posts' => \App\Models\Post::count(),
        ];

        // 2. Fetch Latest Data (Paginated)
        $users = \App\Models\User::latest()->paginate(10, ['*'], 'users_page');
        $communities = \App\Models\Community::withCount('subscribers')->latest()->paginate(10, ['*'], 'communities_page');

        return view('admin.index', compact('stats', 'users', 'communities'));
    }


// --- RULE MANAGEMENT FUNCTIONS ---

    public function rule($community_id)
    {
        $community = Community::with('rules')->findOrFail($community_id);
        $rules = $community->rules;
        return view('community.rule', compact('community', 'rules'));
    }

    // 1. INSERT FUNCTION (Create Rule)
    public function postRule(Request $request, $community_id)
    {
        // dd("masuk");
        // Validation: Ensure title and description are present
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // Insert into the database
        // Assuming your Rule model is 'App\Models\Rule'
        \App\Models\Rule::create([
            'community_id' => $community_id,
            'title' => $validated['title'],
            'description' => $validated['description'],
        ]);

        // Send them back to the home page with a success message
        $community = Community::findOrFail($community_id);

        // 2. FETCH POSTS IN THIS COMMUNITY (optional)
        $posts = $community->posts()
            ->with('user')            // Load the full User data (so you can see names)
            ->withCount('comments')   // ONLY counts them (adds 'comments_count')
            ->withCount('votes')      // ONLY counts them (adds 'votes_count')
            ->get();

        // 3. RETURN THE VIEW WITH DATA
        return view('community.index', compact('community', 'posts'));

        return back()->with('success', 'New rule added successfully!');
    }

    // 2. UPDATE FUNCTION (Edit Rule)
    // NOTE: I changed 'brain $rule' to '\App\Models\Rule $rule' 
    public function updateRule(Request $request, $id) 
    {
        $rule = \App\Models\Rule::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
        ]);

        $rule->update($validated);



        return back()->with('success', 'Rule updated successfully!');
    }

    // 3. DELETE FUNCTION
    public function destroyRule($id) 
    {
        $rule = \App\Models\Rule::findOrFail($id);
        $rule->delete();
        
        return back()->with('success', 'Rule removed.');
    }

    public function updateIcon(Request $request, $id)
    {
        // 1. Find the community
        $community = Community::findOrFail($id);

        // 2. Security Check: Only the creator OR global admin (role_id 1) can change this
        if (Auth::id() !== $community->creator_id && Auth::user()->role_id !== 1) {
            abort(403, 'Only the owner can change the community icon.');
        }

        // 3. Validation
        $request->validate([
            'icon_url' => 'required|url', // Ensures it is a valid web link
        ]);

        // 4. Update the database
        $community->update([
            'icon_url' => $request->icon_url
        ]);

        // 5. Redirect back with success message

        // 2. FETCH POSTS IN THIS COMMUNITY (optional)
        $posts = $community->posts()
            ->with('user')            // Load the full User data (so you can see names)
            ->withCount('comments')   // ONLY counts them (adds 'comments_count')
            ->withCount('votes')      // ONLY counts them (adds 'votes_count')
            ->get();

        // 3. RETURN THE VIEW WITH DATA
        return view('community.index', compact('community', 'posts'));
    }
}
