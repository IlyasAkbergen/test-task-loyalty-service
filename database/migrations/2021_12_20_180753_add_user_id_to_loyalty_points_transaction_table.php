<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToLoyaltyPointsTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('loyalty_points_transaction', 'user_id')) {
            Schema::table('loyalty_points_transaction', function (Blueprint $table) {
                $table->unsignedBigInteger('user_id')->default(0);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('loyalty_points_transaction', 'user_id')) {
            Schema::table('loyalty_points_transaction', function (Blueprint $table) {
                $table->dropColumn('user_id');
            });
        }
    }
}
