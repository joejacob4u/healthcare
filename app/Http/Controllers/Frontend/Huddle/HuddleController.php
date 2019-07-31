<?php

namespace App\Http\Controllers\Frontend\Huddle;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Huddle\Huddle;
use App\User;
use App\Huddle\CareTeam;
use Auth;

class HuddleController extends Controller
{
    public function __construct()
    {
        $this->middleware('user');
    }

    public function index()
    {
        $huddles = Huddle::orderByDesc('date')->paginate(25);
        return view('huddle.user.index', ['huddles' => $huddles]);
    }

    public function create()
    {
        $care_teams = CareTeam::where('recorder_of_data_user_id', Auth::user()->id)->orWhere('alternative_recorder_of_data_user_id', Auth::user()->id)->pluck('name', 'id');
        $users = User::where('healthsystem_id', session('healthsystem_id'))->pluck('name', 'id');
        return view('huddle.user.add', ['users' => $users, 'care_teams' => $care_teams]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'care_team_id' => 'required',
            'attendance' => 'required',
            'date' => 'required',
        ]);

        if ($huddle = Huddle::create($request->except(['attendance']))) {
            $huddle->users()->sync(array_except($request->attendance, [0, '']));
            return redirect('huddle')->with('success', 'New huddle created.');
        }
    }

    public function view(Huddle $huddle)
    {
        $users = User::where('healthsystem_id', session('healthsystem_id'))->pluck('name', 'id');
        return view('huddle.user.view', ['huddle' => $huddle, 'users' => $users]);
    }
}
