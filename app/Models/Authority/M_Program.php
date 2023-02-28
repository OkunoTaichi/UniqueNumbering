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


    public function M_AuthorityDetails(){
        return $this->hasMany(M_AuthorityDetail::class, 'ProgramID','ProgramID');
    }

    // リレーション先のデータも削除 プログラムの削除機能はない為testできない一旦ステイ
    // public static function boot()
    // {
    // parent::boot();
    //     static::deleted(function ($delete) {
    //         $delete->M_AuthorityDetails()->delete();
    //     });
    // }


}
