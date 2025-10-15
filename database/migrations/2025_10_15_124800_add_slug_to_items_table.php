<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Item;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('name');
        });

        // Backfill slugs for existing items
        Item::query()->select('id', 'name')->chunkById(200, function ($items) {
            foreach ($items as $item) {
                $base = Str::slug($item->name ?? '');
                if ($base === '') {
                    $base = 'item';
                }
                $slug = $base;
                $attempt = 0;
                while (
                    DB::table('items')->where('slug', $slug)->where('id', '!=', $item->id)->exists()
                ) {
                    $attempt++;
                    $suffix = '-' . Str::lower(Str::random(6));
                    $slug = substr($base, 0, 255 - strlen($suffix)) . $suffix;
                    if ($attempt > 20) {
                        $slug = substr($base, 0, 200) . '-' . time() . '-' . Str::lower(Str::random(4));
                        break;
                    }
                }
                DB::table('items')->where('id', $item->id)->update(['slug' => $slug]);
            }
        });

        // Ensure NOT NULL at DB level (MySQL). Unique index already added by the schema builder above.
        DB::statement("ALTER TABLE items MODIFY slug VARCHAR(255) NOT NULL");
    }

    public function down(): void
    {
        // Drop unique index if exists (ignore errors)
        try {
            DB::statement("ALTER TABLE items DROP INDEX items_slug_unique");
        } catch (\Throwable $e) {
            // ignore
        }

        Schema::table('items', function (Blueprint $table) {
            if (Schema::hasColumn('items', 'slug')) {
                $table->dropColumn('slug');
            }
        });
    }
};