<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       // Trigger AFTER UPDATE
        DB::unprepared('
            CREATE TRIGGER trg_bug_logs_after_update
            AFTER UPDATE ON bug_logs
            FOR EACH ROW
            BEGIN
            
                IF NEW.new_status = "Resolved" AND OLD.new_status <> "Resolved" THEN
                    UPDATE bugs
                    SET status = "Resolved",
                        closed_at = NOW()
                    WHERE id = NEW.bug_id;
                END IF;

                IF NEW.new_status = "In Progress" AND OLD.new_status <> "In Progress" THEN
                    UPDATE bugs
                    SET status = "In Progress",
                        closed_at = NULL
                    WHERE id = NEW.bug_id;
                END IF;
            END
        ');

        // Trigger AFTER INSERT
        DB::unprepared('
            CREATE TRIGGER trg_bug_logs_after_insert
            AFTER INSERT ON bug_logs
            FOR EACH ROW
            BEGIN
                IF NEW.new_status = "Resolved" THEN
                    UPDATE bugs
                    SET status = "Resolved",
                        closed_at = NOW()
                    WHERE id = NEW.bug_id;
                END IF;
            END
        ');
    }

    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trg_bug_logs_after_update');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_bug_logs_after_insert');
    }
};
