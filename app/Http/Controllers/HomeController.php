<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Models\Clock;
use App\Models\Area;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$userId = Auth::id();

        $user = User::find(Auth::id());
        $data = array(
            'user' => $user,
            'areas' => Area::all()
        );
        return view('home', $data);
    }

    public function welcome()
    {
        //$userId = Auth::id();

        $data = array(
            'areas' => Area::all()
        );
        return view('welcome', $data);
    }

    public function admin()
    {
        //$userId = Auth::id();

        $user = User::find(Auth::id());
        $volunteers = User::all();
        $clocksPre = Clock::all();

        $clocks = array();
        foreach($clocksPre as $clock){
            $clock->userFirstname = $clock->user->firstname;
            $clock->userLastname = $clock->user->lastname;
            $clock->userEmail = $clock->user->email;

            if(isset($clock->area)){
                //$clock->areaName = $clock->area->name;
            }
            $clocks[] = $clock;
        }

        $data = array(
            'user' => $user,
            'areas' => Area::all(),
            'volunteers' => $volunteers,
            'clocks' => $clocks
        );
        return view('admin', $data);
    }

    public function coordinator()
    {
        //$userId = Auth::id();

        $user = User::find(Auth::id());
        $volunteers = User::where('area_id', $user->area_id)->get();
        $clocks = Clock::where('area_id', $user->area_id)->get();
        $data = array(
            'user' => $user,
            'volunteers' => $volunteers,
            'clocks' => $clocks
        );
        return view('coordinator', $data);
    }
}
