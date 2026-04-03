<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GenerateModelsWithMigration extends Command
{
    protected $signature = 'app:gen';

    protected $description = 'Generate models + migrations + Filament v4 resources';

    public function handle()
    {
        $models = [

             // 'supplier_billings' => [
            //     'id' => ['type' => 'id', 'options' => []],
            //     'supplier_id' => ['type' => 'string', 'options' => ['nullable' => true]],
            //     'bill_image' => ['type' => 'string', 'options' => ['nullable' => true]],
            //     'payment' => ['type' => 'integer', 'options' => ['default' => 0]],
            //     'received' => ['type' => 'integer', 'options' => ['default' => 0]],
            //     'payment_mode' => ['type' => 'integer', 'options' => ['default' => 0]],
            //     'transaction_id' => ['type' => 'string', 'options' => ['nullable' => true]],
            //     'note' => ['type' => 'mediumtext', 'options' => ['nullable' => true]],
            //     // Timestamps
            //     'created_at' => ['type' => 'timestamp', 'options' => ['useCurrent' => true]],
            //     'updated_at' => ['type' => 'timestamp', 'options' => ['useCurrent' => true]],
            // ],
        ];

        foreach ($models as $model => $fields) {
            $modelName = Str::studly(Str::singular($model));
            $table     = Str::plural(Str::snake($modelName));

            // 1. Create model + migration
            $this->call('make:model', [
                'name' => $modelName,
                '--migration' => true,
            ]);

            // 2. Create Filament Resource
            $this->call('make:filament-resource', [
                $modelName,
                '--generate' => true,
                '--view' => true,
                '--panel' => 'admin',
                '--no-interaction' => true,
            ]);

            // 3. Update migration
          //  $this->updateMigrationFields($table, $fields);

            $this->info("✔ {$modelName} created successfully.");
        }

        return self::SUCCESS;
    }

    /**
     * Get correct migration file for table
     */
    protected function getMigrationFileForTable(string $table): string
    {
        $files = collect(File::files(database_path('migrations')));

        $file = $files->first(function ($file) use ($table) {
            return str_contains($file->getFilename(), "create_{$table}_table");
        });

        if (!$file) {
            throw new \RuntimeException("Migration for table {$table} not found.");
        }

        return $file->getPathname();
    }

    /**
     * Update migration fields dynamically
     */
    protected function updateMigrationFields(string $table, array $fields)
    {
        $migrationFile = $this->getMigrationFileForTable($table);

        $fieldLines = '';

        foreach ($fields as $field => $props) {

            $type = $props['type'] ?? 'string';
            $options = $props['options'] ?? [];

            // ID
            if ($type === 'id') {
                $fieldLines .= "            \$table->id();\n";
                continue;
            }

            // FOREIGN KEY
            if ($type === 'foreignId') {
                $line = "\$table->foreignId('$field')";

                if (!empty($options['constrained'])) {
                    $line .= "->constrained('{$options['constrained']}')";
                }

                if (!empty($options['cascadeOnDelete'])) {
                    $line .= "->cascadeOnDelete()";
                }

                if (!empty($options['index'])) {
                    $line .= "->index()";
                }

                $line .= ';';

                $fieldLines .= "            $line\n";
                continue;
            }

            // ENUM
            if ($type === 'enum') {
                $values = var_export($options['values'] ?? [], true);

                $line = "\$table->enum('$field', $values)";

                if (isset($options['default'])) {
                    $line .= "->default('{$options['default']}')";
                }

                $line .= ';';

                $fieldLines .= "            $line\n";
                continue;
            }

            // NORMAL TYPES
            $line = "\$table->$type('$field')";

            if (!empty($options['nullable'])) {
                $line .= "->nullable()";
            }

            if (array_key_exists('default', $options)) {
                $default = var_export($options['default'], true);
                $line .= "->default($default)";
            }

            if (!empty($options['unique'])) {
                $line .= "->unique()";
            }

            if (!empty($options['index'])) {
                $line .= "->index()";
            }

            $line .= ';';

            $fieldLines .= "            $line\n";
        }

        // Add timestamps automatically
        $fieldLines .= "            \$table->timestamps();\n";

        $content = file_get_contents($migrationFile);

        $pattern = '/Schema::create\(\s*[\'"]' . preg_quote($table, '/') . '[\'"]\s*,\s*function\s*\(Blueprint\s*\$table\)\s*\{(.*?)\}\s*\);/s';

        $replacement = "Schema::create('$table', function (Blueprint \$table) {\n$fieldLines        });";

        $updated = preg_replace($pattern, $replacement, $content, 1);

        file_put_contents($migrationFile, $updated);
    }
}
