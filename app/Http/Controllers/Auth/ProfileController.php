<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\PrivateUserResource;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware(['auth:api']);
    }

    public function action(Request $request)
    {
        # code...

        return new PrivateUserResource($request->user());
    }
}
