<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApprovalReimbursementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approval_reimbursement', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('reimbursement_id');
            $table->bigInteger('approval_leader_id')->nullable();
            $table->dateTime('approval_leader_date')->nullable();
            $table->string('approval_leader_status')->nullable();
	        $table->mediumText('leader_reason')->nullable();
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
        Schema::dropIfExists('approval_reimbursement');
    }
}
