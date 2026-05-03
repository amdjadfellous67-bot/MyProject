<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\PasswordResetRequest;
use App\Models\User;
use App\Models\Employee;

class PasswordResetRequestController extends Controller
{
    public function submit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'message' => 'nullable|string',
        ]);

        $user = User::where('email', $request->email)->first();

        PasswordResetRequest::create([
            'name' => $user ? $user->employee->full_name : 'Unknown',
            'email' => $request->email,
            'message' => $request->message,
            'user_id' => $user?->id,
            'status' => 'pending',
        ]);

        return response()->json(['success' => true, 'message' => 'Your request has been sent to the administrator.']);
    }

    public function index()
    {
        $requests = PasswordResetRequest::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.password-requests.index', compact('requests'));
    }

    public function markResolved(Request $request, PasswordResetRequest $passwordRequest)
    {
        $passwordRequest->update(['status' => 'resolved']);
        return back()->with('success', 'Request marked as resolved.');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::find($request->user_id);
        $user->update(['password' => Hash::make($request->password)]);

        PasswordResetRequest::where('user_id', $user->id)
            ->where('status', 'pending')
            ->update(['status' => 'resolved']);

        return back()->with('success', 'Password has been reset successfully.');
    }
}
