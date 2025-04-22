<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void //выз при выол мигр, отвеч за созд 3 табл
    {
        Schema::create('jobs', function (Blueprint $table) { //созд табл
            $table->id(); //поле id служ перв кл и хран id задания
            $table->string('queue')->index(); //храни имя очереди, в кот нах зад, индекс для ускор поиска
            $table->longText('payload'); //хран дан задания в форм json
            $table->unsignedTinyInteger('attempts');//хран кол попыток выполн зада
            $table->unsignedInteger('reserved_at')->nullable();//хран времен мет связ с зад
            $table->unsignedInteger('available_at');//хран времен мет связ с зад
            $table->unsignedInteger('created_at');//хран времен мет связ с зад
        });

        Schema::create('job_batches', function (Blueprint $table) {//созд табл
            $table->string('id')->primary(); //служ перв кл и хран id пак зад
            $table->string('name');//доб пол для хран инфор о пак зад
            $table->integer('total_jobs');//доб пол для хран инфор о пак зад
            $table->integer('pending_jobs');//доб пол для хран инфор о пак зад
            $table->integer('failed_jobs');//доб пол для хран инфор о пак зад
            $table->longText('failed_job_ids');//доб пол для хран инфор о пак зад
            $table->mediumText('options')->nullable();//доб пол для хран инфор о пак зад
            $table->integer('cancelled_at')->nullable();//доб пол для хран инфор о пак зад
            $table->integer('created_at');//доб пол для хран инфор о пак зад
            $table->integer('finished_at')->nullable();//доб пол для хран инфор о пак зад
        });

        Schema::create('failed_jobs', function (Blueprint $table) { //созд табл
            $table->id();//служ перв кл и хран id неудач зад
            $table->string('uuid')->unique();//хран уник id неуд зад
            $table->text('connection');//пол для хран инф о неуд зад
            $table->text('queue');//пол для хран инф о неуд зад
            $table->longText('payload');//пол для хран инф о неуд зад
            $table->longText('exception');//пол для хран инф о неуд зад
            $table->timestamp('failed_at')->useCurrent();// пол хран врем мет неуд зад
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void //выз при откате мигр, отв за удал табл
    {
        Schema::dropIfExists('jobs'); //удал табл
        Schema::dropIfExists('job_batches');//удал табл
        Schema::dropIfExists('failed_jobs');//удал табл
    }
};
