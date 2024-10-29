<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;


class WhatsAppController extends Controller
{
    public function showUsers()
    {
        $drivers = DB::table('users')
            ->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->select('users.*', 'roles.name as role')
            ->where('users.id', '!=', auth()->id())
            ->get();

        return response()->json($drivers);;
    }
}
