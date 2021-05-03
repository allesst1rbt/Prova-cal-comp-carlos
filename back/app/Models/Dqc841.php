<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;




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

    public static function GetDataToReport()
    {
        $Dqc841 = Dqc841::join('DQC84', 'DQC841.FART_PART_NO', 'DQC84.ID')->join('DQCMODEL', 'DQC84.MODEL', 'DQCMODEL.ID')->select('DQCMODEL.MODEL', 'DQC84.FART_PART_NO', 'DQC84.TOTAL_LOCATION', 'DQC841.PARTS_NO', 'DQC841.UNT_USG', 'DQC841.DESCRIPTION', 'DQC841.REF_DESIGNATOR')->get();
        //Dqc841::join('DQC84', 'DQC841.FART_PART_NO', 'DQC84.ID')->select('DQC841.ID', 'DQC84.FART_PART_NO', 'DQC841.PARTS_NO', 'DQC841.UNT_USG', 'DQC841.DESCRIPTION', 'DQC841.REF_DESIGNATOR')->get();
        return $Dqc841;
    }
    public static function SendEmailReport($email)
    {
        try {
            $fileName = "ReportDaProva.csv";
            $columns = [
                'MODEL', 'FART_PART_NO', 'TOTAL_LOCATION', 'PARTS_NO', 'UNT_USG', 'DESCRIPTION', 'REF_DESIGNATOR'
            ];

            $filePath = '../storage/app/' . $fileName;
            $file = fopen($filePath, 'w');
            fputcsv($file, $columns);
            Dqc841::join('DQC84', 'DQC841.FART_PART_NO', 'DQC84.ID')
                ->join('DQCMODEL', 'DQC84.MODEL', 'DQCMODEL.ID')
                ->select('DQCMODEL.MODEL', 'DQC84.FART_PART_NO', 'DQC84.TOTAL_LOCATION', 'DQC841.PARTS_NO', 'DQC841.UNT_USG', 'DQC841.DESCRIPTION', 'DQC841.REF_DESIGNATOR')
                ->chunk(45000, function ($row) use ($file) {
                    foreach ($row as $item) {


                        fputcsv($file, [
                            $item['MODEL'],
                            $item['FART_PART_NO'],
                            $item['TOTAL_LOCATION'],
                            $item['PARTS_NO'],
                            $item['UNT_USG'],
                            $item['DESCRIPTION'],
                            isset($item['REF_DESIGNATOR']) ? $item['REF_DESIGNATOR'] : "",
                        ]);
                    }
                });
            fclose($file);
            Mail::send('email', [], function ($message) use ($filePath, $email) {
                $message->to($email, 'Testador da prova');
                $message->subject('Relatorio da prova cal-comp');
                $message->attach($filePath);
            });
            unlink($filePath);
        } catch (Exception $e) {
            return $e;
        }
        return "sucesso";
    }
}
