<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\PlayerRequest;
use App\Http\Requests\UpdatePlayerRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Enums\UserType;
use Illuminate\Support\Str;

class PlayerController extends Controller
{
    private const PLAYER_ROLE = 2;
    
    public function index()
    {
        $players = User::where('type', UserType::Player)->get();
        return view('admin.player.index', compact('players'));
    }

    public function create()
    {
        $player_name = $this->generateRandomString();

        return view('admin.player.create', compact('player_name'));
    }

    public function store(PlayerRequest $request)
    {
        $admin = Auth::user();

        $inputs = $request->validated();

        $userPrepare = array_merge(
            $inputs,
            [
                'password' => Hash::make($inputs['password']),
                'agent_id' => Auth::id(),
                'type' => UserType::Player,
            ]
        );

        $player = User::create($userPrepare);
            $player->roles()->sync(self::PLAYER_ROLE);

        Log::info('User prepared: '.json_encode($userPrepare));
        
       
        return redirect()->back()
        ->with('success', 'Player created successfully')
        ->with('url', env('APP_URL'))
        ->with('password', $request->password)
        ->with('user_name', $player->user_name);
    }

    public function show($id)
    {
        $player = User::findOrFail($id);
        return view('admin.player.show', compact('player'));
    }

    public function edit($id)
    {
        $player = User::findOrFail($id);
        return view('admin.player.edit', compact('player'));
    }

    public function update(UpdatePlayerRequest $request, $id)
    {
        $player = User::findOrFail($id);
        $validated = $request->validated();
        $player->update([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'status' => (int) $validated['status'],
        ]);
        return redirect()->route('admin.players.index')->with('success', 'Player updated successfully');
    }

    public function destroy($id)
    {
        $player = User::findOrFail($id);
        $player->delete();
        return redirect()->route('admin.players.index')->with('success', 'Player deleted successfully');
    }

    private function generateRandomString()
    {
        $randomNumber = mt_rand(10000000, 99999999);

        return 'W-'.$randomNumber;
    }

    private function getRefrenceId($prefix = 'REF')
    {
        return uniqid($prefix);
    }

    public function resetPwdForm($id)
    {
        $player = User::findOrFail($id);
        return view('admin.player.change_password', compact('player'));
    }

    public function makeChangePassword($id, Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);

        $player = User::find($id);
        $player->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()
            ->with('success', 'Player Change Password successfully')
            ->with('password', $request->password)
            ->with('user_name', $player->user_name);
    }



    public function resetPassword($id)
    {
        $player = User::findOrFail($id);
        $newPassword = $this->generateRandomPassword();
        $player->password = Hash::make($newPassword);
        $player->is_changed_password = 0;
        $player->save();

        return redirect()
            ->back()
            ->with('success', 'Password reset successfully')
            ->with('password_reset_user_name', $player->user_name)
            ->with('password_reset_password', $newPassword);
    }

    private function generateRandomPassword(int $length = 10): string
    {
        return Str::random($length);
    }

    public function banUser($id)
    {
        $user = User::find($id);
        $user->update(['status' => $user->status == 1 ? 0 : 1]);

        return redirect()->back()->with(
            'success',
            'User '.($user->status == 1 ? 'activate' : 'inactive').' successfully'
        );
    }

}
