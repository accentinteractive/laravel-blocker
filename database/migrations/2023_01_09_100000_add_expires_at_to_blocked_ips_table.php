<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExpiresAtToBlockedIpsTable extends Migration
{

    const TABLE_NAME = 'ai_blocked_ips';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if ( ! Schema::hasColumn(self::TABLE_NAME, 'expires_at')) {
            Schema::table(self::TABLE_NAME, function($table) {
                $table->dateTime('expires_at');
            });
        }
        Schema::dropColumns(self::TABLE_NAME, 'created_at');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(self::TABLE_NAME, function($table) {
            $table->timestamp('created_at')->useCurrent();
        });
        Schema::dropColumns(self::TABLE_NAME, 'expires_at');
    }
}
