<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public function get_users(): \Illuminate\Http\JsonResponse
    {
        $users = DB::table('users')->get();

        return response()->json($users);
    }
}
