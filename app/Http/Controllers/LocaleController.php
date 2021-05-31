<?php

namespace App\Http\Controllers;

use App\Models\Prodect;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;

class LocaleController extends Controller
{
    //

    protected $previousRequest; //old segmant
    protected $locale;

    public function switch($locale)
    {
        // Not Working for url
        /*  $this->previousRequest = request()->create(url()->previous());
        $this->locale = $locale;
        // all route after url  ==[../en/post/show]
        $segments =  $this->previousRequest->segments();

        // IF locale found in locals is true
        if(array_key_exists($this->locale, config('locales.languages'))){

            $segments[0] = $this->locale;
            $newRoute = $this->translateRouteSegments($segments);

            return redirect()->to($this->buildNewRoute($newRoute));
        }
        return back(); */

        // $this->previousRequest = $this->getPreviousRequest();
        // $segments = $this->previousRequest->segments();


        try {
            if(array_key_exists($locale, config('locales.languages'))){
                App::setLocale($locale);
                Lang::setLocale($locale);
                setlocale(LC_TIME, config('locales.languages')[$locale]['unicode']);
                Carbon::setLocale(config('locales.languages')[$locale]['lang']);
                Session::put('locale', $locale);

                if(config('locales.languages')[$locale]['rtl_support'] == 'rtl'){
                    Session::put('lang-rtl',true);
                }else{
                    Session::forget('lang-rtl');
                }
                // check if show post or not  ---------
                if(isset($segments[1])){
                    return $this->resolveModel(Prodect::class, $segments[1] ,$locale);
                }
                return redirect()->back();
            }
            return redirect()->back();
        } catch (Exceptions $e) {
            return redirect()->back();
        }

    }

    /*  protected function translateRouteSegments($segments)
    {
        $translatedSegments = collect();

        foreach($segments as $segment){
            if($key = array_search($segment, Lang::get('routes'))){
                $translatedSegments->push(__('routes.'.$key,[],$this->locale));
            }else{
                $translatedSegments->push($segment);
            }
        }
        return $translatedSegments;
    }


    protected function buildNewRoute($newRoute)
    {
        // convert array to 'value1/vlaue2/v3..'
        $redirectUrl =implode('/',$newRoute->toArray());
        //if url contenu query
        $queryBag = $this->previousRequest->query();
        $redirectUrl .= count($queryBag) ? '?'.http_build_query($queryBag): '';

        return $redirectUrl;
    } */

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

                    $newRoute = str_replace($slug, $modelinLocal->slug, urlencode(urlencode(route('products.show',$modelinLocal->slug))));
                    return redirect()->to($newRoute)->send(); // send == Required
                }
            }
            abort(404);
        }
        // dd($slug, $model->slug);
        // solving fix [repet slug ] is convrt betwean lng > exception
        if($slug === $model->slug){ //her is slug.lng == slug.lngOther [return back no convert]
            return redirect()->back();
        }
        return $model;
    }

}
