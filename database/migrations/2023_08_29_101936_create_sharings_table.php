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
        Schema::create('sharings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sharing_user_group_id');
            $table->string('status', 20);
            $table->string('name')->nullable(false);
            $table->unsignedBigInteger('created_by')->nullable(false);
            $table->bigInteger('amount')->default(0)->comment('单位分');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sharings');
    }
};
