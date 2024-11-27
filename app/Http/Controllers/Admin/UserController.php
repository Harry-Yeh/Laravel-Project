<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // 方法示例
    public function index()
    {
        // 获取所有用户
        $users = User::paginate(10);

        // 返回视图并传递用户数据
        return view('admin.user', compact('users'));
    }

    public function suspend(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'duration' => 'required|integer',
            'reason' => 'nullable|string|max:255',
        ]);

        $duration = (int) $request->input('duration');
        $suspendUntil = new DateTime;
        $suspendUntil->modify("+{$duration} seconds");

        $user = User::find($request->input('user_id'));
        $user->time_limit = $suspendUntil;
        $user->save();

        return response()->json(['message' => '用戶已成功暫停']);
    }
}