<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Transformers\PermissionTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionsController extends Controller
{
    //
    public function assign(){
        $user = User::find(16);
        $user->assignRole('Maintainer');
    }

    public function index()
    {

        $permissions = $this->user()->getAllPermissions();

        return $this->response->collection($permissions, new PermissionTransformer());
    }
}
