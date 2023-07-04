<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAccessToRoleAccesses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('role_accesses', function (Blueprint $table) {
            $table->char('view', 1)->nullable()->after('access');
            $table->char('create', 1)->nullable()->after('view');
            $table->char('update', 1)->nullable()->after('create');
            $table->char('delete', 1)->nullable()->after('update');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('role_accesses', function (Blueprint $table) {
            //
        });
    }
}
