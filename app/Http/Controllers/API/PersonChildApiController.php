<?php namespace App\Http\Controllers\API;

use App\Http\Requests;
use App\Http\Controllers\Controller;


use App\Models\AddressOriginal;
use App\Models\AddressPresent;
use App\Models\CriminalHistory;
use App\Models\DataCase;
use App\Models\DataChild;
use App\Models\DataFather;
use App\Models\DataMother;
use App\Models\DataSpouse;
use App\Models\NameTitle;
use \Hash;
use Illuminate\Http\Response;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\View;
use \Input;
use Symfony\Component\VarDumper\Cloner\Data;

class PersonChildApiController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($personId)
    {

        return CriminalHistory::find($personId)->datachild()->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store($personId)
    {

        $person = CriminalHistory::find($personId);

        if ($person) {

            $datachild = new DataChild();
            $datachild->fill(Input::all());
            if(Input::has('nametitle.id')){
                $nametitle = NameTitle::find(Input::get('nametitle.id'));
                $datachild->nametitle()->associate($nametitle);
            }
            $datachild->criminalhistory()->associate($person);
            $datachild->save();

        } else {
            return null;
        }

        return $person;





    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        return CriminalHistory::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        return CriminalHistory::find($id);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($personId,$childId)
    {


        $person = CriminalHistory::find($personId);

        if ($childId) {
            $datachild = DataChild::find($childId)->delete();
            return $person;
        } else {
            return null;
        }


    }



}
