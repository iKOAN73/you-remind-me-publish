<?php

namespace App\Services;

use App\Http\Controllers\InstantUserController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\InstantUser;
use Illuminate\Contracts\Session\Session;
use Laravel\Jetstream\Http\Controllers\Inertia\CurrentUserController;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;


class InstantUserService
{
    public function GetUserList()
    {
        return InstantUser::GetUserList();
    }

    public static function GetColumns()
    {
        return InstantUser::GetColumns();
    }

    public function GetSessionUser() : ?InstantUser
    {
        $cookieIID = Session('iid');
        return $this->AuthUser($cookieIID);
    }

    public function AuthUser(?string $iid) : InstantUser
    {
        $user = self::Auth($iid) ?? $this->IssueNewUser();

        self::RememberUser($user);

        return $user;
    }

    public function GetNewUser() : InstantUser
    {
        $user = $this->IssueNewUser();
        self::ForgetSession();
        self::RememberUser($user);

        /* 初回案内用 */
        Session(['first_visit' => true]);

        return $user;
    }

    public function SubmitUser(Request $request) : string
    {
        if (InstantUser::ExistsUser($request->postID))
        {
            $user = self::Auth($request->postID);
            $user->name = $request->postName;
            $user->AddUser();
            self::RememberUser($user);
            Session(['first_visit' => false]);
            return 'Updated Your data.';
        }

        return 'Invalid ID.';
    }

    public static function ForgetSession()
    {
        // Cookie::queue(Cookie::forget('iid'));
        Session()->forget('iid');
        // Session()->forget('first_visit');
    }

    private function IssueNewUser() : InstantUser
    {
        $newuser = new InstantUser;
        $newuser->name = "ゲスト";
        $newuser->instant_id = self::GetIID();
        $newuser->Adduser();

        /* 初回案内用 */
        Session(['first_visit' => true]);

        return $newuser;
    }

    private static function GetIID() : String
    {
        $str = substr(base_convert(bin2hex(openssl_random_pseudo_bytes(10)), 16, 36), 0, 10);
        return $str;
    }

    private static function Auth($iid) : ?InstantUser
    {
        return InstantUser::Where('instant_id', $iid)->first();
    }

    private static function RememberUser($user)
    {
        // Cookie::queue('iid', $user->instant_id, 365 * 24 * 60 * 60);
        Session(['iid' => $user->instant_id]);
    }
}

// ID変更の場合は名前変えず
// 動的に項目を増やすリスト表示ページ
