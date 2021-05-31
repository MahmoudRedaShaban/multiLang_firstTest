<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;

class Language
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // This code check from url
        /* // Check if no select any lang go select lang
        $locales = config('locales.languages');
        // if not found segment == en | ar | ..in locales
        if(!array_key_exists($request->segment(1), $locales)){
            $segments = $request->segments();
            $segments = Arr::prepend($segments, config('locales.fallback_locale'));
            return redirect()->to(implode('/', $segments));
        } */
        // This code check from Session
        if(Session::has('locale') && array_key_exists(Session::get('locale'), config('locales.languages'))){
            // if session set lng & lang found in config lang set lang in project
            App::setLocale(Session::get('locale'));

        }else{ //get lang form pc vistor
            $userLanguages = preg_split('/[,;]/',request()->server('HTTP_ACCEPT_LANGUAGE'));
            foreach($userLanguages as $userLanguage){
                if(array_key_exists($userLanguage, config('locales.languages'))){
                    App::setLocale($userLanguage);
                    Lang::setLocale($userLanguage);
                    setlocale(LC_TIME, config('locales.languages')[$userLanguage]['unicode']);
                    Carbon::setLocale(config('locales.languages')[$userLanguage]['lang']);

                    //Suport RTL
                    if(config('locales.languages')[$userLanguage]['rtl_support']){
                        Session::put('lang-rtl',true);
                    }else{
                        Session::forget('lang-rtl');
                    }
                    break;
                }
            }
        }

        return $next($request);
    }
}
