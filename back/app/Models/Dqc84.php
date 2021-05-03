<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Dqc84 extends Model
{
    protected $table = 'DQC84';
    const CREATED_AT = 'CREATE_DT';
    const UPDATED_AT = 'UPDATE_DT';






    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'MODEL', 'FART_PART_NO', 'TOTAL_LOCATION',
    ];
    public static function Read()
    {
        $Dqc84 = Dqc84::join('DQCMODEL', 'DQC84.MODEL', 'DQCMODEL.ID')->select('DQC84.*', 'DQCMODEL.MODEL')->orderBy('DQC84.ID', 'ASC')->get();
        return $Dqc84;
    }
}
