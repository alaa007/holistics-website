<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Removes the duplicated medical team placeholders.
     *
     * An earlier version of the team seeder keyed on something other than
     * specialty, so a second set of the six directory roles was created with
     * specialty_id left null. The team page filters by specialty, so those
     * rows render as placeholder cards with no specialty tag and cannot be
     * saved from the admin panel at all (specialty is a required field).
     *
     * Deliberately narrow: it only removes non-leadership rows that have no
     * specialty, no name and no photo, and only when a row with the same
     * role and a real specialty exists to replace it. Anything an admin has
     * actually filled in is left alone.
     */
    public function up(): void
    {
        $replacementRoles = DB::table('team_members')
            ->where('is_leadership', false)
            ->whereNotNull('specialty_id')
            ->pluck('role_en');

        if ($replacementRoles->isEmpty()) {
            return;
        }

        DB::table('team_members')
            ->where('is_leadership', false)
            ->whereNull('specialty_id')
            ->whereIn('role_en', $replacementRoles)
            ->where(fn ($q) => $q->whereNull('name_en')->orWhere('name_en', ''))
            ->where(fn ($q) => $q->whereNull('photo')->orWhere('photo', ''))
            ->delete();
    }

    public function down(): void
    {
        // Nothing to restore: the deleted rows were unusable duplicates of
        // rows that are still present.
    }
};
