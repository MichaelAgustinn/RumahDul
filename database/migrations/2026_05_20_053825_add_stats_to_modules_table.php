<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('modules', function (Blueprint $table) {
            $table->unsignedBigInteger('views_count')->default(0)->after('file_path');
            $table->unsignedBigInteger('downloads_count')->default(0)->after('views_count');
        });
    }

    public function down()
    {
        Schema::table('modules', function (Blueprint $table) {
            $table->dropColumn(['views_count', 'downloads_count']);
        });
    }
};
