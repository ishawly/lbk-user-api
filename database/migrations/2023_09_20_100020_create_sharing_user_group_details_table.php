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
        Schema::create('sharing_user_group_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sharing_user_group_id')->nullable(false);
            $table->unsignedBigInteger('user_id')->nullable(false);
            $table->integer('sharing_ratio')->default(0)->nullable(false)->comment('分摊比率,万分比取分子');
            $table->timestamp('joined_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sharing_user_group_details');
    }
};
