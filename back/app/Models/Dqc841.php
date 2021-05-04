<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\DqcModel;



class Dqc841 extends Model
{
    protected $table = 'DQC841';
    const CREATED_AT = 'CREATE_DT';
    const UPDATED_AT = 'UPDATE_DT';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'FART_PART_NO', 'PARTS_NO', 'UNT_USG', 'DESCRIPTION', 'REF_DESIGNATOR'
    ];


    public static function Read()
    {
        $Dqc841 = Dqc841::join('DQC84', 'DQC841.FART_PART_NO', 'DQC84.ID')->select('DQC841.ID', 'DQC84.FART_PART_NO', 'DQC841.PARTS_NO', 'DQC841.UNT_USG', 'DQC841.DESCRIPTION', 'DQC841.REF_DESIGNATOR', 'DQC841.UPDATE_DT', 'DQC841.CREATE_DT')->get();
        return $Dqc841;
    }
}
