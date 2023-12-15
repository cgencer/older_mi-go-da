<?php

namespace App\Http\Livewire;

use Livewire\Component;
use \Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Countries;
use App\Models\Hotels;

class countrySearch extends Component
{
    public $query;
    public $highlightIndex;
    public $countries = [];
    public $hotelname = '';
    public $req;
    public $country = [
        'id'    => 0,
        'name'  => '',
        'code'  => ''
    ];
    public $hotel = [
        'id'    => 0,
        'name'  => '',
        'stripe'=> ''
    ];
 
    public function mount(Request $req)
    {
        $this->resetter();
        $this->country['code'] = $req->country;
        if($req->has('country')){
            $c = Countries::where('code', $req->country)->get()->first();
            if($c){
                $this->country['id']   = $c->id;
                $this->country['name'] = $c->name;
            }
        }
        if($req->has('hotel_id')){
            $this->hotel['id'] = $req->hotel_id;

            $h = Hotels::where('id', $req->hotel_id )
                              ->get()
                              ->first()
                              ->toArray();
            $this->hotel['id'] = $h['id'];
            $this->hotel['name'] = $h['name']['en'];
            $this->hotel['stripe'] = $h['stripe_data'];
            $c = Countries::where('id', $h['country_id'])->get()->first();
            if($c){
                $this->country['id']   = $c->id;
                $this->country['name'] = $c->name;
            }
        }
    }

    public function resetter()
    {
        $this->query = '';
        $this->countries = [];
        $this->highlightIndex = 0;
    }

    public function incrementHighlight()
    {
        if ($this->highlightIndex === count($this->countries) - 1) {
            $this->highlightIndex = 0;
            return;
        }
        $this->highlightIndex++;
    }

    public function decrementHighlight()
    {
        if ($this->highlightIndex === 0) {
            $this->highlightIndex = count($this->countries) - 1;
            return;
        }
        $this->highlightIndex--;
    }

    public function selectCountry()
    {
        $country = $this->countries[$this->highlightIndex] ?? null;
        if ($country) {
            $this->redirect(route('f.onboarding', ['country_id' => $country['id']]));
        }
    }

    public function updatedQuery()
    {
        $this->countries = Countries::where('name', 'like', '{"en":"' . $this->query . '%')
            						->get()
            						->toArray();
    }

    public function render()
    {
        return view('livewire.country-search', [
            'hotelname'     => $this->hotelname, 
            'countries'     => $this->countries, 
            'selCountry'    => $this->country,
            'selHotel'      => $this->hotel
        ]);
    }
}
