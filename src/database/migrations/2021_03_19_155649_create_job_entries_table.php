<?php

use App\Models\JobEntry;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        Schema::create('job_entries', function (Blueprint $table) {
            
            $phone_number_length = 13;

            $table->id();

            $table->string('name');
            $table->string('email');
            $table->string('phone_number', $phone_number_length);
            $table->string('desired_role');

            $table->enum('school_level', JobEntry::SCHOOL_LEVELS);

            $table->string('resume');
            $table->text('additional_info')->nullable();

            $table->string('ip', 15);
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
        Schema::dropIfExists('job_entries');
    }
}
