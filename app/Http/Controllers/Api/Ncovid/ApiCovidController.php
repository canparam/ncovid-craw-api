<?php

namespace App\Http\Controllers\Api\Ncovid;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Support\CrawApi;
class ApiCovidController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function BacNinh($tp){
        $craw = new CrawApi('https://ncov.moh.gov.vn/',$tp);
        //bc
        return  response()->json($craw->Pros());
    }
}
