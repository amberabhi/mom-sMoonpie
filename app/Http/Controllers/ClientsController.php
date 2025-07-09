<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Setting;
use App\Services\HttpService;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    protected $httpService;
    public function __construct(){
        $this->httpService = new HttpService();
    }

    public function index(){
        $rows = Client::all();
        return view('clients.index', compact('rows'));
    }

    public function syncClients(){
        $settings = Setting::first();
        $loEndpoint = $settings->logiwa_endpoint;
        $url = $loEndpoint.'Client/list/i/0/s/200';

        $headers = array(
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.trim($settings->logiwa_token)
        );

        $response = $this->httpService->getRequest($url, [], $headers);

        $rows = [];
        if(count($response['data'])){
            $rows = $response['data'];
        }

        if($rows){
            foreach ($rows as $row) {
                Client::updateOrCreate([
                    'identifier' => $row['identifier']
                ],[
                    'officialIdentity' => $row['officialIdentity'],
                    'displayName' => $row['displayName'],
                    'fullName' => $row['fullName'],
                    'taxNumber' => $row['taxNumber'],
                    'timeZoneId' => $row['timeZoneId']
                ]);
            }

            return redirect()->back()->with('success', 'Clients synced.');
        }
    }

    public function setDefault(Request $request){
        $id = $request->id;
        $identifier = $request->identifier;

        \DB::transaction(function () use ($id, $identifier) {
            Client::query()->update(['is_default' => 0]);
            Client::where('id', $id)->update(['is_default' => 1]);
            // update in settings
            Setting::where('id', 1)->update(['logiwa_client_identifier' => $identifier]);
        });

        return response()->json(['error' => false, 'message' => 'Default client updated successfully.']);
    }
}
