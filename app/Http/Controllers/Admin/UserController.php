<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
{
    $users = User::paginate(10);

    return view('admin.users.index', compact('users'));
}


    public function update(Request $request, User $user)
    {
        if ($request->has('status')) {
            $user->status = $request->status;
        }

        if ($request->has('is_banned')) {
            $user->is_banned = $request->is_banned;
        }

        $user->save();

        return redirect()
            ->route('admin.users.index');
    }
    public function ban(User $user)
{
    $user->update(['is_banned' => true]);
    return response()->json($user);
}

public function unban(User $user)
{
    $user->update(['is_banned' => false]);
    return response()->json($user);
}
public function updateStatus(Request $request, User $user)
{
    $request->validate([
        'status' => 'required|in:pending,active,banned'
    ]);

    $user->update([
        'status' => $request->status
    ]);

    return redirect()->back()->with('success', 'User status updated.');
}

}
