<?php

namespace App\Http\Controllers;

use App\Jobs\SendMailJob;
use App\Models\Dqc84;
use App\Models\Dqc841;
use App\Models\DqcModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Laravel\Lumen\Routing\Controller as BaseController;

class GeneralController extends BaseController
{
  public function NewModel(Request $request)
  {
    try {
      $this->validate($request, [
        'model' => 'required|string|max:10'
      ]);
      // query laravel
      $model =  new DqcModel();
      $model->MODEL = $request->model;
      $model->save();
      // query normal
      //$model=DB::insert("insert into DQCMODEL (MODEL) values (?)",[$request->model]);
    } catch (Exception $e) {
      return response()->json(["mensagem" => $e], 502);
    }

    return response()->json(["mensagem" => $request->model . " foi criado com sucesso"]);
  }
  public function NewDQC84(Request $request)
  {
    try {
      $this->validate($request, [
        'model_id' => 'required|int',
        'fart' => 'required|string|max:15',
        'total' => 'required|int'

      ]);
      // query laravel
      $dqc84 =  new Dqc84();
      $dqc84->MODEL = $request->model_id;
      $dqc84->FART_PART_NO = $request->fart;
      $dqc84->TOTAL_LOCATION = $request->total;
      $dqc84->save();
      // query normal
      //DB::insert("insert into DQC84 (MODEL,FART_PART_NO,TOTAL_LOCATION) values (?,?,?)", [$request->model_id, $request->fart_part_no, $request->total_location]);
    } catch (Exception $e) {
      return response()->json(["mensagem" => $e], 502);
    }

    return response()->json(["mensagem" => $request->fart_part_no . " foi criado com sucesso"]);
  }
  public function NewDQC841(Request $request)
  {
    try {
      $this->validate($request, [
        'fart_id' => 'required|int',
        'part_no' => 'required|string|max:15',
        'unt_usg' => 'required|int',
        'description' => 'required|string',
        'ref_designator' => 'string',

      ]);
      // query laravel
      $dqc841 =  new Dqc841();
      $dqc841->FART_PART_NO = $request->fart_id;
      $dqc841->PARTS_NO = $request->part_no;
      $dqc841->UNT_USG = $request->unt_usg;
      $dqc841->DESCRIPTION = $request->description;
      $dqc841->REF_DESIGNATOR = $request->ref_designator;
      $dqc841->save();
      // query normal
      //DB::insert("insert into DQC841 (FART_PART_NO,PARTS_NO,UNT_USG,DESCRIPTION,REF_DESIGNATOR) values (?,?,?,?,?)", [$request->fart_part_no_id, $request->part_no, $request->unt_usg, $request->description, $request->ref_designator]);
    } catch (Exception $e) {
      return response()->json(["mensagem" => $e], 502);
    }

    return response()->json(["mensagem" => $request->part_no . " foi criado com sucesso"]);
  }
  public function Models()
  {
    try {

      $models = DqcModel::all();
    } catch (Exception $e) {
      return response()->json(["mensagem" => $e], 502);
    }
    return response()->json(["mensagem" => "models resgatados com sucesso", "data" => $models]);
  }
  public function DQC84()
  {
    try {
      $Dqc84 = Dqc84::Read();
    } catch (Exception $e) {
      return response()->json(["mensagem" => $e], 502);
    }
    return response()->json(["mensagem" => "Dcq84 resgatados com sucesso", "data" => $Dqc84]);
  }
  public function DQC841()
  {
    try {
      $Dqc841 = Dqc841::Read();
    } catch (Exception $e) {
      return response()->json(["mensagem" => $e], 502);
    }
    return response()->json(["mensagem" => "models resgatados com sucesso", "data" => $Dqc841]);
  }
  public function UpdateDQCModels($id, Request $request)
  {

    try {
      DqcModel::where('ID', $id)->update(['MODEL' => $request->Model]);
    } catch (Exception $e) {
      return response()->json(["mensagem" => $e], 502);
    }
    return response()->json(["mensagem" => "models atualizado com sucesso"]);
  }
  public function UpdateDQC84($id, Request $request)
  {
    try {

      Dqc84::where('ID', $id)->update(['MODEL' => $request->model_id, "FART_PART_NO" => $request->fart, "TOTAL_LOCATION" => $request->total]);
    } catch (Exception $e) {
      return response()->json(["mensagem" => $e], 502);
    }
    return response()->json(["mensagem" => "Dqc84 atualizado com sucesso"]);
  }
  public function UpdateDQC841($id, Request $request)
  {
    try {
      $Dqc841 = Dqc841::Read();
    } catch (Exception $e) {
      return response()->json(["mensagem" => $e], 502);
    }
    return response()->json(["mensagem" => "models resgatados com sucesso", "data" => $Dqc841]);
  }
  public function DeleteDQCModels($id)
  {
    try {
      $DqcModel = DqcModel::where('ID', $id)->delete();
    } catch (Exception $e) {
      return response()->json(["mensagem" => $e], 502);
    }
    return response()->json(["mensagem" => "modelo $id exluido com sucesso", "data" => $DqcModel]);
  }
  public function DeleteDQC84($id)
  {
    try {
      $Dqc84 = Dqc84::where('ID', $id)->delete();
    } catch (Exception $e) {
      return response()->json(["mensagem" => $e], 502);
    }
    return response()->json(["mensagem" => "dqc84 deletado com sucesso", "data" => $Dqc84]);
  }
  public function DeleteDQC841($id)
  {
    try {
      $Dqc841 = Dqc841::where('ID', $id)->delete();
    } catch (Exception $e) {
      return response()->json(["mensagem" => $e], 502);
    }
    return response()->json(["mensagem" => "dqc841 deletado com sucesso", "data" => $Dqc841]);
  }

  public function Generate(Request $request)
  {
    try {
      if ($request->email) {
        DqcModel::SendEmailReport($request->email);
      } else {
        return response()->json(["mensagem" => "Dados para o relatorio", "data" => DqcModel::GetDataToReport()]);
      }
    } catch (Exception $e) {
      return response()->json(["mensagem" => $e], 502);
    }
    return response()->json(["mensagem" => "Email enviado para " . $request->email]);
  }
}
