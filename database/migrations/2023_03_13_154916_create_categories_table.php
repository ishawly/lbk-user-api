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
        Schema::create('categories', function (Blueprint $table) {
            $table->id(); // 分类,10000以下系统设置,以上为用户自定义
            $table->bigInteger('user_id')->nullable(false)->default(0)->comment('0:系统用户');
            $table->string('name')->nullable(false);
            $table->tinyInteger('type')->nullable(false)->comment('-1:支出,1:收入,0:通用');
            $table->string('icon')->nullable(false)->default('');
            $table->integer('sort')->nullable(false)->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
