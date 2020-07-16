<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Logins;
use Illuminate\Support\Facades\Auth;
class SessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        /*$user_data = Logins::find(Auth::user()->id)->user_data;

        //Create Session
        session()->put('id', $user_data->id);
        session()->put('username', Auth::user()->username);
        session()->put('name',$user_data->name);
        session()->put('status',$user_status->status);*/
        if(Auth::user()->username == 'admin'){
            return view('dashboard');
            //return redirect()->route('home');
            // return 'Test';
        }else if(Auth::user()->username == 'manager'){
            return view('dashboardManager');
            // return 'Test2';
        }
        //return redirect('home');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //
        session()->flush();
        echo session()->get('id');
        Auth::logout();
        return redirect('login');
    }
}
