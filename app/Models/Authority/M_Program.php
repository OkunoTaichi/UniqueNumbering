<?php

namespace App\Models\Authority;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_Program extends Model
{
    use HasFactory;

    //テーブル名
    protected $table = 'm_program';

    //可変項目
    protected $fillable = 
    [
        'ProgramID',
        'ProgramDiv',
        'ProgramName',
        'UpdatePerson',
    ];
}
