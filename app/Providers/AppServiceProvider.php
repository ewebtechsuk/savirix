<?php

namespace App\Providers;

use App\Models\Property;
use App\Services\WorkflowEngine;
use App\Support\AppKeyManager;
use App\Support\ModelChangeRecorder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        try {
            if (! Schema::hasTable('workflows')) {
                return;
            }
        } catch (\Throwable $exception) {
            return;
        }

        $recorder = app(ModelChangeRecorder::class);

        Model::saving(function ($model) use ($recorder) {
            $recorder->record($model);
        });

        Model::saved(function ($model) use ($recorder) {
            $original = $recorder->pull($model);
            $changes = [];

            if (method_exists($model, 'getChanges')) {
                foreach ($model->getChanges() as $attribute => $value) {
                    $changes[$attribute] = [
                        'from' => $original[$attribute] ?? null,
                        'to' => $value,
                    ];
                }
            }

            $context = [
                'model_id' => method_exists($model, 'getKey') ? $model->getKey() : null,
                'changes' => $changes,
            ];

            app(WorkflowEngine::class)->processModelEvent('saved', $model, $context);

            if ($model instanceof Property && isset($changes['status'])) {
                app(WorkflowEngine::class)->processModelEvent('property.status_changed', $model, $context);
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        AppKeyManager::ensure();

        $this->app->singleton(ModelChangeRecorder::class);

        if ($this->app->environment('testing')) {
            $databasePath = database_path('testing.sqlite');

            if (! file_exists($databasePath)) {
                touch($databasePath);
            }

            config([
                'database.default' => 'sqlite',
                'database.connections.sqlite.database' => $databasePath,
            ]);
        }
    }
}
