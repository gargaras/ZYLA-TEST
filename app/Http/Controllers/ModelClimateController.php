<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClimate;
use App\Models\Current;
use App\Models\Location;
use App\Models\ModelClimate;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Builder;

class ModelClimateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $current = Current::create($request->all());
        $location = $current->locations()->create( $request->all() );
        $climate = ModelClimate::create($request->all());
        $climate->location()->associate($location)->save();

        return response()->json($location);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ModelClimate  $modelClimate
     * @return \Illuminate\Http\Response
     */
    public function show(ModelClimate $query )
    {
        function logica ($reques){
            try {
                $response = ModelClimate::with('location')->where('query', 'like', '%'.$reques.'%')->first()
                ->loadMorph('location',[Location::class => ['locationable'] ]);
            } catch (\Throwable $th) {
                $client = new Client([
                    'base_uri'=>env('WEATHERSTACKk_URL').'?access_key='.env('WEATHERSTACKk_API_kEY').'&query='.$reques,
                ]);
                $response = $client->request('GET', '')->getBody()->getContents();
                $request = json_decode($response, true);
                return redirect()->route('store',[ModelClimateController::class, 'store']);
            }

            //every 3 hours the weather should be updated
            $timeDB = $response->location->locationable->updated_at;
            $date = Carbon::now();
            if ($date->diffInMinutes($timeDB) >= 180) {
                $client = new Client([
                    'base_uri'=>env('WEATHERSTACKk_URL').'?access_key='.env('WEATHERSTACKk_API_kEY').'&query='.$reques,
                ]);
                $response = $client->request('GET', '')->getBody()->getContents();
                $response = json_decode($response, true);
                return redirect()->route('store',[ModelClimateController::class, 'store']);
            }
            else return response()->json($response);

        }

        if ( isset($_GET['query']) ) {
            $query = $_GET['query'];
            $response = logica($query);
            return response()->json($response->original);
        }else{
            $response = logica($query);
            return response()->json($response->original);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ModelClimate  $modelClimate
     * @return \Illuminate\Http\Response

*    public function edit(ModelClimate $modelClimate)
 *   {

  *  }
*/
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ModelClimate  $modelClimate
     * @return \Illuminate\Http\Response
     */
    public function update(StoreClimate $request, ModelClimate $modelClimate)
    {
        ModelClimate::where('query', 'like', '%'.$request['query'].'%')->first()->update($request->all());
        Location::whereHas('climate', function (Builder $query) {$query->where('query', 'like', '%New York%');})->first()->update($request->all());
        Current::with('locations')
        ->whereHas('locations', function (Builder $query) {$query->whereHas('climate', function (Builder $query) {$query->where('query', 'like', '%New York%');});})->first()
        ->update($request->all());

        return response()->json();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ModelClimate  $modelClimate
     * @return \Illuminate\Http\Response
     */
    public function destroy(ModelClimate $modelClimate)
    {
        //
    }
}
