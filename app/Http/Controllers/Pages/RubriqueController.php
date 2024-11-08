<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RubriqueController extends Controller
{
    public function showWhyMonAssurance()
    {
    	return view('app.frontend.rubrique.why-monassurance-ci')->with(['active'=>'']);
    }

    public function showHowToCompare()
    {
    	return view('app.frontend.rubrique.how-to-compare')->with(['active'=>'']);
    }

    public function showInsuranceVoyage()
    {
    	return view('app.frontend.rubrique.garantie-assurance-voyage')->with(['active'=>'voyage']);
    }
}
