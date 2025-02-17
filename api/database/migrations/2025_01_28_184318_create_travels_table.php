<?php

use App\Enum\TravelStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('travels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained(
                table: 'users', indexName: 'id_user'
            );
            $table->string('destination', 255);
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', TravelStatusEnum::toArray());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travels');
    }
};
