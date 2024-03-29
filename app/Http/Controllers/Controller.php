<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Auth\AuthController;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\User;
use Illuminate\Support\Facades\Auth;



abstract class Controller extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    /**
     * The authenticated user.
     *
     * @var \App\User|null
     */
    protected $user;

    /**
     * Is the user signed in?
     *
     * @var \App\User|null
     */
    protected $signedIn;

    /**
     *
     * Create a new controller instance.
     *
     */
    public function __construct()
    {

        $this->user = $this->signedIn = Auth::user();

    }




}
