<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('abilities', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
        });

        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('course', 100)->nullable();
            $table->integer('max_member')->default(5);
            $table->string('invitation_code', 20)->unique();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title', 150);
            $table->string('type', 50)->nullable();
            $table->text('description')->nullable();
            $table->dateTime('deadline')->nullable();
            $table->foreignId('group_id')->constrained()->cascadeOnDelete();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

        Schema::create('task_generations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained()->cascadeOnDelete();
            $table->foreignId('generated_by')->constrained('users')->cascadeOnDelete();
            $table->text('prompt');
            $table->text('ai_response')->nullable();
            $table->string('model', 50)->nullable();
            $table->integer('version')->default(1);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

        Schema::create('user_abilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('ability_id')->constrained()->cascadeOnDelete();
            $table->integer('level')->default(0);
            $table->unique(['user_id', 'ability_id']);
        });

        Schema::create('password_resets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('token_hash', 64);
            $table->dateTime('expired_at');
            $table->dateTime('used_at')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('group_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('group_id')->constrained()->cascadeOnDelete();
            $table->string('role')->default('member');
            $table->dateTime('joined_at')->nullable();
            $table->unique(['user_id', 'group_id']);
        });

        Schema::create('sub_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->foreignId('task_id')->constrained()->cascadeOnDelete();
            $table->text('description')->nullable();
            $table->foreignId('required_ability_id')->nullable()->constrained('abilities')->nullOnDelete();
            $table->foreignId('generation_id')->nullable()->constrained('task_generations')->nullOnDelete();
            $table->string('status')->default('pending');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

        Schema::create('sub_task_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sub_task_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('role')->default('assignee');
            $table->string('status')->default('assigned');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->unique(['sub_task_id', 'user_id']);
        });

        Schema::create('user_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('token_hash', 64);
            $table->dateTime('expired_at');
            $table->dateTime('revoked_at')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('support_files', function (Blueprint $table) {
            $table->id();
            $table->string('file_name', 255);
            $table->string('file_path', 255);
            $table->foreignId('task_id')->constrained()->cascadeOnDelete();
            $table->foreignId('uploaded_by')->constrained('users')->cascadeOnDelete();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('support_files');
        Schema::dropIfExists('user_sessions');
        Schema::dropIfExists('sub_task_assignments');
        Schema::dropIfExists('sub_tasks');
        Schema::dropIfExists('group_members');
        Schema::dropIfExists('password_resets');
        Schema::dropIfExists('user_abilities');
        Schema::dropIfExists('task_generations');
        Schema::dropIfExists('tasks');
        Schema::dropIfExists('groups');
        Schema::dropIfExists('abilities');
    }
};
