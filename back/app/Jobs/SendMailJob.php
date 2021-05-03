<?php

namespace App\Jobs;

use App\Models\Dqc841;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;


class SendMailJob implements ShouldQueue
{
    use Queueable, SerializesModels, InteractsWithQueue;

    private $email;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $fileName = "ReportDaProva";
        $columns = [
            'MODEL', 'FART_PART_NO', 'TOTAL_LOCATION', 'PARTS_NO', 'UNT_USG', 'DESCRIPTION', 'REF_DESIGNATOR'
        ];

        $filePath = public_path() . '/' . $fileName;
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
                        $item['REF_DESIGNATOR'],
                    ]);
                }
            });
        fclose($file);
        Mail::send('Email', [], function ($message) use ($filePath) {
            $message->to($this->email, 'Testador da prova');
            $message->subject('Subject');
            $message->attach($filePath);
        });
        unlink($filePath);
    }
}
