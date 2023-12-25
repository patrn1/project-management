<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Поиск пользователя по имени
     */
    public function search(Request $request)
    {
        $query = $request->query->get('query');
        $userList = User::where('name', 'LIKE', "%{$query}%")->paginate(5)->items();

        return UserResource::collection($userList);
    }
}
