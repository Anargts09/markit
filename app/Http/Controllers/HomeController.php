<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;


use Auth;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hasemail = true;
        $active ='index';
        if(Auth::user()){
            $user = Auth::user(); 
            if(empty($user->email)){
                $hasemail = false;
            }
        }
        return view('main.index')
            ->with(compact('user'))
            ->with(compact('active'))
            ->with(compact('hasemail'));
    }
    public function getFeed()
    {
        $hasemail = true;
        $active ='feed';
        $user = Auth::user(); 
        if(empty($user->email)){
            $hasemail = false;
        }
        return view('main.feed')
            ->with(compact('user'))
            ->with(compact('active'))
            ->with(compact('hasemail'));
    }
    public function getSaved()
    {
        $hasemail = true;
        $active ='saved';
        $user = Auth::user(); 
        if(empty($user->email)){
            $hasemail = false;
        }
        return view('main.saved')
            ->with(compact('user'))
            ->with(compact('active'))
            ->with(compact('hasemail'));
    }




}
