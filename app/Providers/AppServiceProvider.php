<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->configureAssetUrls();
        $this->removeViteHotFileInProduction();
    }

    private function configureAssetUrls(): void
    {
        // Serve Vite build files from the current host (fixes Railway when APP_URL is wrong).
        Vite::createAssetPathsUsing(fn (string $path) => '/'.ltrim($path, '/'));

        if (! $this->app->runningInConsole()) {
            $request = $this->app->make(Request::class);

            if ($request->header('X-Forwarded-Proto') === 'https') {
                URL::forceScheme('https');
            }
        }

        if ($appUrl = config('app.url')) {
            URL::forceRootUrl(rtrim($appUrl, '/'));
        }
    }

    private function removeViteHotFileInProduction(): void
    {
        if ($this->app->environment('production')) {
            $hotFile = public_path('hot');

            if (is_file($hotFile)) {
                @unlink($hotFile);
            }
        }
    }
}
