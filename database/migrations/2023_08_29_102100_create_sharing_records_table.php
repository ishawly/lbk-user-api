<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sharing_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sharing_id')->nullable(false);
            $table->unsignedBigInteger('record_id')->nullable(false);
            $table->unsignedBigInteger('user_id')->nullable(false);
            $table->tinyInteger('type')->nullable(false)->comment('-1:支出,1:收入');
            $table->bigInteger('amount')->default(0)->comment('单位分');
            $table->date('transaction_at')->nullable(false)->comment('交易发生日期');
            $table->json('snapshot');
            $table->timestamps();
            $table->comment('分摊记录明细');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sharing_records');
    }
};
