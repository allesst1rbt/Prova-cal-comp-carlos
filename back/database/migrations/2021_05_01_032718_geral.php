<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Geral extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    DB::statement("
        CREATE TABLE DQCMODEL (
          ID int(11) NOT NULL AUTO_INCREMENT,
          MODEL varchar(10) NOT NULL,
          PRIMARY KEY (ID),
          UNIQUE KEY MODEL_UNIQUE (MODEL)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    DB::statement("
          CREATE TABLE DQC84 (
          ID int(11) NOT NULL AUTO_INCREMENT,
          MODEL int(11) NOT NULL,
          FART_PART_NO varchar(15) NOT NULL,
          TOTAL_LOCATION int(11) NOT NULL,
          UPDATE_DT timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
          CREATE_DT timestamp NOT NULL DEFAULT current_timestamp(),
          PRIMARY KEY (ID),
          UNIQUE KEY FART_PART_NO_UNIQUE (FART_PART_NO),
          KEY fk_DQC84_1_idx (MODEL),
          CONSTRAINT fk_DQC84_1 FOREIGN KEY (MODEL) REFERENCES DQCMODEL (id) ON DELETE CASCADE ON UPDATE NO ACTION
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    DB::statement("
        CREATE TABLE DQC841 (
          ID int(11) NOT NULL AUTO_INCREMENT,
          FART_PART_NO int(11) NOT NULL,
          PARTS_NO varchar(15) NOT NULL,
          UNT_USG int(11) NOT NULL,
          DESCRIPTION longtext NOT NULL,
          REF_DESIGNATOR longtext DEFAULT NULL,
          UPDATE_DT timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
          CREATE_DT timestamp NOT NULL DEFAULT current_timestamp(),
         PRIMARY KEY (ID),
         UNIQUE KEY UQ_PARTS (FART_PART_NO,PARTS_NO),
         KEY fk_DQC841_1_idx (FART_PART_NO),
         CONSTRAINT fk_DQC841_1 FOREIGN KEY (FART_PART_NO) REFERENCES DQC84 (ID) ON DELETE CASCADE ON UPDATE NO ACTION
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    //
  }
}
