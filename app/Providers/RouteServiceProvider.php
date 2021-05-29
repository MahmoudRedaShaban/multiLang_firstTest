<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();
        //set default lang in route
        // $locale = request()->segment(1);
        //Get local form Project
        $locale = app()->getLocale();

        $this->routes(function  () use($locale) {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                // ->prefix($locale)    //stop this convert lang in product To hundel translate
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        });

        /* Huandel Route For Model [Product ]  read slug and translate route*/
        //this is transiton in Route
        Route::bind('product' , function ($slug) use ($locale) {
            //Edit read Route for translation
            return $this->resolveModel(Product::class, $slug, $locale);
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }

    //hundel data and  Translation And return Result
    protected function resolveModel($modelClass, $slug, $locale)
    {
        // Search in db foun this slug
        $model = $modelClass::where('slug->'.$locale, $slug)->first();
        // if is found this slug in lng  get author lang and result but not abort(404)
        if(is_null($model)){
            foreach(config('locales.languages') as $key => $value){
                $modelinLocal = $modelClass::where('slug->'.$key, $slug)->first();
                if($modelinLocal){

                    // dd($slug, $modelinLocal->slug, urlencode(request()->fullUrl()));
                    $newRoute = str_replace($slug, $modelinLocal->slug, urlencode(request()->fullUrl()));
                    return redirect()->to($newRoute)->send(); // send == Required
                }
            }
            abort(404);
        }

        return $model;
    }
}
