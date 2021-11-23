<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReimbursementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reimbursement', function (Blueprint $table) {
            $table->id();
            $table->string('reimbursement_code')->nullable();
            $table->bigInteger('request_by');
            $table->bigInteger('divisi_id');
            $table->bigInteger('institusi_id');
            $table->bigInteger('leader_id')->nullable();;
            $table->date('request_date');
            $table->mediumText('note');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reimbursement');
    }
}
