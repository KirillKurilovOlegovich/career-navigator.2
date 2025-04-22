<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void //выз при вып мигр,отвеч за созд 2 нов табл в бд cache и cache_locks.
    {
        Schema::create('cache', function (Blueprint $table) { //Созд табл с именем cache.
            $table->string('key')->primary(); //доб поле key служ перв кл и буд хран ключ кэша
            $table->mediumText('value');//доб поле хран закэширован дан, тип дан mediumText позв хран больш объемы текста
            $table->integer('expiration');//доб поле хран время истеч срока действия кэша
        });

        Schema::create('cache_locks', function (Blueprint $table) {//Созд табл с именем cache_locks.
            $table->string('key')->primary();//доб поле key служ перв кл и буд хран ключ блок кэша
            $table->string('owner'); //доб хран владель блок
            $table->integer('expiration'); //доб хран время истечения срока дейст блок
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void //вызыв при откате мигр, отвеч за удал табл 
    {
        Schema::dropIfExists('cache'); //удал табл
        Schema::dropIfExists('cache_locks'); //удал табл 
    }
};
