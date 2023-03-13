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
        Schema::create('records', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable(false);
            $table->tinyInteger('type')->nullable(false)->comment('-1:支出,1:收入');
            $table->bigInteger('category_id')->nullable(false)->comment('分类,10000以下系统设置,以上为用户自定义');
            $table->bigInteger('amount')->default(0)->comment('单位分');
            $table->string('remarks')->default('');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('records');
    }
};
