<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('admin_skills', function (Blueprint $table) {
            $table->unsignedInteger('sort_order')->default(0)->after('id');
        });

        Schema::table('admin_experiences', function (Blueprint $table) {
            $table->unsignedInteger('sort_order')->default(0)->after('id');
        });

        Schema::table('admin_projects', function (Blueprint $table) {
            $table->unsignedInteger('sort_order')->default(0)->after('id');
        });

        $skills = DB::table('admin_skills')->orderBy('id')->get();
        foreach ($skills as $index => $skill) {
            DB::table('admin_skills')->where('id', $skill->id)->update(['sort_order' => $index]);
        }

        $experiences = DB::table('admin_experiences')->orderByDesc('start_date')->get();
        foreach ($experiences as $index => $experience) {
            DB::table('admin_experiences')->where('id', $experience->id)->update(['sort_order' => $index]);
        }

        $projects = DB::table('admin_projects')->orderByDesc('created_at')->get();
        foreach ($projects as $index => $project) {
            DB::table('admin_projects')->where('id', $project->id)->update(['sort_order' => $index]);
        }
    }

    public function down(): void
    {
        Schema::table('admin_skills', function (Blueprint $table) {
            $table->dropColumn('sort_order');
        });

        Schema::table('admin_experiences', function (Blueprint $table) {
            $table->dropColumn('sort_order');
        });

        Schema::table('admin_projects', function (Blueprint $table) {
            $table->dropColumn('sort_order');
        });
    }
};
