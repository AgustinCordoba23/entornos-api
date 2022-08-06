<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public function me(Request $request) {
        return new UserResource($request->user());
    }
}
