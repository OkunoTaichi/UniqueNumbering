<?php

namespace App\Http\Controllers\RoomType;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function Room_index()
    {
        
       
        return view(
            'Room.Room_index'
        );
    }

}
