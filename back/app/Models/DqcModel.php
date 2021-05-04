<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Exception;

class DqcModel extends Model
{
    protected $table = 'DQCMODEL';
    public $timestamps = false;





    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'MODEL',
    ];
    public static function GetDataToReport()
    {
        $DqcModel = DqcModel::Join('DQC84', 'DQCMODEL.ID', 'DQC84.MODEL')->Join('DQC841', 'DQC84.ID', 'DQC841.FART_PART_NO')->select('DQCMODEL.MODEL', 'DQC84.FART_PART_NO', 'DQC84.TOTAL_LOCATION', 'DQC841.PARTS_NO', 'DQC841.UNT_USG', 'DQC841.DESCRIPTION', 'DQC841.REF_DESIGNATOR')->get();
        // caso seja left join pois eu fiquei em duvida $DqcModel = DqcModel::leftJoin('DQC84', 'DQCMODEL.ID', 'DQC84.MODEL')->leftJoin('DQC841', 'DQC84.ID', 'DQC841.FART_PART_NO')->select('DQCMODEL.MODEL', 'DQC84.FART_PART_NO', 'DQC84.TOTAL_LOCATION', 'DQC841.PARTS_NO', 'DQC841.UNT_USG', 'DQC841.DESCRIPTION', 'DQC841.REF_DESIGNATOR')->get();

        return $DqcModel;
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
            DqcModel::Join('DQC84', 'DQCMODEL.ID', 'DQC84.MODEL')->Join('DQC841', 'DQC84.ID', 'DQC841.FART_PART_NO')
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
