<?php

namespace App\Http\Controllers;

use App\Http\Requests\BanRequest;
use App\Jobs\UnbanUserJob;
use App\Models\Ban;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BanController extends Controller
{
    public function index(User $user)
    {
        $response = [
            'bans' => $user->bans()->get(),
            'user' => $user,
        ];
        return view('bans.index', $response);
    }

    public function store(BanRequest $request, User $user)
    {
        $data = $request->validated();
        $user->is_banned = true;
        $user->save();
        $ban = $user->bans()->create($data);
        UnbanUserJob::dispatch($user)->delay(Carbon::create($ban->end_time));
        return redirect(route('user.show', [$user->id]));
    }

    public function update(BanRequest $request, Ban $ban)
    {
        $data = $request->validated();
        $ban->update($data);
        UnbanUserJob::dispatch($ban->user)->delay(Carbon::create($ban->end_time));
        return back();
    }

    public function destroy(Ban $ban)
    {
        $user = $ban->user;
        $ban->delete();
        $user->ban_sync();
        return back();
    }
}
