<?php

namespace App\Http\Controllers;

use App\Models\InstantUser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\InstantUserService;
use Illuminate\Support\Facades\Schema;

class InstantUserController extends Controller
{
    public $service;

    function __construct()
    {
        $this->service = new InstantUserService;
    }

    public function index()
    {
        return view('InstantUser/Index', ['user' => $this->service->GetSessionUser()]);
    }

    public function newUser()
    {
        return view('InstantUser/Index', ['user' => $this->service->GetNewUser()]);
    }

    public function list()
    {
        return view('InstantUser/List', $this->service->GetUserList());
    }

    public function SubmitUserInfo(Request $request)
    {
        $msg = $this->service->SubmitUser($request);
        return back()->with('message', $msg);
    }

    public function ForgetSession()
    {
        InstantUserService::ForgetSession();

        return redirect()->action([ReminderController::class, 'Reminder']);
    }

    public function IsStranger() 
    {
        $isStranger = Session('first_visit');
        Session(['first_visit' => false]);
        return [
            'isStranger' => $isStranger,
            'timerID' => InstantUser::where('instant_id', session('iid'))->first()->id,
        ];
    }
}