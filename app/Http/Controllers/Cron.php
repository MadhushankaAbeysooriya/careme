<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;

class Cron extends Controller
{
    public function activateBlackList()
    {
        $today = Carbon::today();

        $blacklistedUsers = User::where('black_list', 1)->get();

        if(!$blacklistedUsers->isEmpty())
        {
            foreach ($blacklistedUsers as $user) {
                $latestBlacklist = $user->userblacklist->last();
                if ($latestBlacklist && $latestBlacklist->activating_date === $today->toDateString()) {

                    $user->update(['black_list' => 0]);
                }
            }

        }

        return response()->json(['message' => 'Blacklisted users deactivated successfully.'], 200);
    }
}
