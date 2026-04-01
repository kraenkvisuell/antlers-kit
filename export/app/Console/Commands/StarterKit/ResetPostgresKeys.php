<?php

namespace App\Console\Commands\StarterKit;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ResetPostgresKeys extends Command
{
    protected $signature = 'kit:reset-postgres-keys';

    public function handle()
    {
        $tables = Schema::getTableListing();

        foreach ($tables as $table) {
            $table = Str::afterLast($table, '.');

            if (
                Schema::hasColumn($table, 'id') && stristr(Schema::getColumnType($table, 'id'), 'int')
                && DB::table($table)->count()
            ) {
                $this->info('resetting id on ' . $table);

                DB::statement(
                    "SELECT setval('{$table}_id_seq1',(SELECT GREATEST(MAX(id)+1,nextval('{$table}_id_seq1'))-1 FROM {$table}));"
                );
            }
        }
    }
}
