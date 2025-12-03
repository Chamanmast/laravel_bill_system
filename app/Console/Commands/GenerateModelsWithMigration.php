<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GenerateModelsWithMigration extends Command
{
    protected $signature = 'app:gen';

    protected $description = 'Generate multiple models with migrations + Filament v4 resources';

    public function handle()
    {
        // Define the models and their fields with types and options
        $models = [
            'supplier_billings' => [
                'id' => ['type' => 'id', 'options' => []],
                'supplier_id' => ['type' => 'string', 'options' => ['nullable' => true]],
                'bill_image' => ['type' => 'string', 'options' => ['nullable' => true]],
                'payment' => ['type' => 'integer', 'options' => ['default' => 0]],
                'received' => ['type' => 'integer', 'options' => ['default' => 0]],
                'payment_mode' => ['type' => 'integer', 'options' => ['default' => 0]],
                'transaction_id' => ['type' => 'string', 'options' => ['nullable' => true]],
                'note' => ['type' => 'mediumtext', 'options' => ['nullable' => true]],
                // Timestamps
                'created_at' => ['type' => 'timestamp', 'options' => ['useCurrent' => true]],
                'updated_at' => ['type' => 'timestamp', 'options' => ['useCurrent' => true]],
            ],

        ];

        foreach ($models as $model => $fields) {
            $modelName = Str::studly($model);

            // create model + migration
            $this->call('make:model', [
                'name' => $modelName,          // argument "name"
                '--migration' => true,         // option
            ]);

            // // create filament resource (v4)
            $this->call('make:filament-resource', [
                $modelName,
                'model' => $modelName,                         // argument "name"
                '--generate' => true,                         // List/Create/Edit
                '--view' => true,                             // include read-only View page (skips prompt)
                '--simple' => false,                          // keep separate pages
                '--panel' => 'admin',                         // target panel
                '--soft-deletes' => false,                    // set true if model uses SoftDeletes
                '--record-title-attribute' => Str::plural($modelName),         // avoid title prompt
                '--no-interaction' => true,                   // suppress any remaining questions
            ]);

            // update migration fields
            $this->updateMigrationFields($modelName, $fields);

            $this->info("✔ $modelName model + migration + Filament resource created.");
        }

        return self::SUCCESS;
    }

    protected function generateModel(string $model)
    {
        $this->call('make:model', [
            'name' => $model,
            '--migration' => true,
        ]);
    }

    protected function generateFilamentResource(string $model)
    {
        $this->call('make:filament-resource', [
            'name' => $model,
        ]);
    }

    protected function getLastMigrationFile(): string
    {
        $last = collect(File::files(database_path('migrations')))
            ->sortByDesc(fn ($file) => $file->getMTime())
            ->first();

        if (! $last) {
            throw new \RuntimeException('No migration files found in database/migrations');
        }

        return $last->getPathname();
    }

    protected function updateMigrationFields(string $model, array $fields)
    {
        $migrationFile = $this->getLastMigrationFile();
        $table = Str::plural(Str::snake($model));

        $fieldLines = '';

        foreach ($fields as $field => $props) {
            // Support multiple input shapes: ['type'=>'string','options'=>[]] or numeric array
            if (is_string($props)) {
                $type = $props;
                $options = [];
            } elseif (isset($props['type'])) {
                $type = $props['type'];
                $options = $props['options'] ?? [];
            } elseif (is_array($props) && isset($props[0])) {
                $type = $props[0];
                $options = $props[1] ?? [];
            } else {
                $type = 'string';
                $options = [];
            }

            $typeLower = strtolower($type);
            $typeMap = [
                'mediumtext' => 'mediumText',
                'text' => 'text',
                'tinyint' => 'tinyInteger',
                'tinyinteger' => 'tinyInteger',
                'boolean' => 'boolean',
                'integer' => 'integer',
                'bigint' => 'bigInteger',
                'biginteger' => 'bigInteger',
                'timestamp' => 'timestamp',
                'string' => 'string',
                'id' => 'id',
            ];

            $method = $typeMap[$typeLower] ?? $type;

            // build line
            if ($method === 'id') {
                $line = '$table->id();';
                $fieldLines .= "            $line\n";

                continue;
            }

            $length = $options['length'] ?? $options['maxLength'] ?? null;

            $line = "\$table->$method('$field'";
            if ($length) {
                $line .= ", $length";
            }
            $line .= ')';

            if (! empty($options['nullable'])) {
                $line .= '->nullable()';
            }
            if (array_key_exists('default', $options)) {
                $default = $options['default'];
                $line .= '->default('.var_export($default, true).')';
            }
            if (! empty($options['unique'])) {
                $line .= '->unique()';
            }
            if (! empty($options['unsigned'])) {
                $line .= '->unsigned()';
            }
            if (! empty($options['useCurrent'])) {
                $line .= '->useCurrent()';
            }

            $line .= ';';
            $fieldLines .= "            $line\n";
        }

        $content = file_get_contents($migrationFile);

        $pattern = '/Schema::create\(\s*[\'\"]'.preg_quote($table, '/').'[\'\"]\s*,\s*function\s*\(Blueprint\s*\$table\)\s*\{(.*?)\}\s*\);/s';

        if (preg_match($pattern, $content)) {
            $replacement = "Schema::create('$table', function (Blueprint \$table) {\n$fieldLines        });";
            $updated = preg_replace($pattern, $replacement, $content, 1);
            file_put_contents($migrationFile, $updated);
        } else {
            $this->warn("Could not find Schema::create for table $table in migration: $migrationFile");
        }
    }
}
