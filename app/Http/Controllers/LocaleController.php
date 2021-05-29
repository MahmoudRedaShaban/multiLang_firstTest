<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class LocaleController extends Controller
{
    //

    protected $previousRequest; //old segmant
    protected $locale;

    public function switch($locale)
    {
        $this->previousRequest = request()->create(url()->previous());
        $this->locale = $locale;
        // all route after url  ==[../en/post/show]
        $segments =  $this->previousRequest->segments();

        // IF locale found in locals is true
        if(array_key_exists($this->locale, config('locales.languages'))){

            $segments[0] = $this->locale;
            $newRoute = $this->translateRouteSegments($segments);

            return redirect()->to($this->buildNewRoute($newRoute));
        }



    }

    protected function translateRouteSegments($segments)
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
    }

}
