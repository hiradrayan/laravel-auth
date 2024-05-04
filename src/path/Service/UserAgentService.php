<?php

namespace Authentication\path\Service;

use Authentication\path\models\UserAgent;
use Authentication\path\Service\StringFunctions;

class UserAgentService
{
    public function set ($user = null)
    {
        if (!$user) {
            $user = \Auth::user();
        }

        if (!$user) {
            return false;
        }

        $stringFunctions = new StringFunctions();
        $nowDate = new \DateTime('UTC');
        $hash = substr(md5(random_bytes(12)),0,32);

        UserAgent::where('user_id', '=', $user->id)
            ->where('is_active', '=', true)
            ->update([
                'is_active' => false
            ]);

        $userAgent = UserAgent::create([
            'user_id' => $user->id,
            'hash'    => $hash,
            'is_active'=> true,
            'agent'    => request()->userAgent(),
            'login_at' => $nowDate,
            'login_ip' => $stringFunctions->getRealIPAddr(request()),
        ]);

        \Cookie::queue('UHASH',$hash,43200);

        return true;
    }

    public function delete ($user = null) {
        if (!$user) {
            $user = \Auth::user();
        }

        if (!$user) {
            return false;
        }

        $stringFunctions = new StringFunctions();
        $nowDate = new \DateTime('UTC');

        $hash = \Cookie::get('UHASH');

        UserAgent::whereRaw("user_id = '$user->id' AND
        (hash = '$hash' OR (is_active = 0 AND logout_at IS NULL))")
            ->update([
                'is_active' => false,
                'logout_ip' => $stringFunctions->getRealIPAddr(request()),
                'logout_at' => $nowDate
            ]);

        \Cookie::queue(\Cookie::forget('UHASH'));

        return  true;

    }
}
