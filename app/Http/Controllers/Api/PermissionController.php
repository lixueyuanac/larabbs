<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    //
    public function assign(){
        $user = User::find(16);
        $user->assignRole('Maintainer');
    }
}
