<?php

namespace App\Http\Controllers\RoomType;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoomTypeController extends Controller
{
    public function RoomType_index()
    {
        
       
        return view(
            'RoomType.RoomType_index'
        );
    }
}
