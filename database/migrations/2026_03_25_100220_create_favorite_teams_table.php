<?php

use App\Models\FavoriteTeam;
use App\Models\User;
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
        Schema::create(FavoriteTeam::TABLE, function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(User::TABLE)->onDelete('cascade');
            $table->unsignedSmallInteger('favorite_team_id');
            $table->string('favorite_team_name', 64);
            $table->string('favorite_team_crest', 128)->nullable();
            $table->string('favorite_team_country', 64)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(FavoriteTeam::TABLE);
    }
};
