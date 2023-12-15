<?php

namespace App\Http\Livewire;

use Livewire\Component;
use \Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Countries;
use App\Models\Hotels;

class hotelSearch extends Component
{
    public $query;
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
    public $hotel_id;
    public $hotels;
    public $highlightIndex;

    public function mount(Request $req)
    {
        $this->resetter();
        $this->country['code'] = $req->country;
        if($req->hotel_id){
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
        $this->hotels = [];
        $this->highlightIndex = 0;
    }

    public function incrementHighlight()
    {
        if ($this->highlightIndex === count($this->hotels) - 1) {
            $this->highlightIndex = 0;
            return;
        }
        $this->highlightIndex++;
    }

    public function decrementHighlight()
    {
        if ($this->highlightIndex === 0) {
            $this->highlightIndex = count($this->hotels) - 1;
            return;
        }
        $this->highlightIndex--;
    }

    public function selectHotel()
    {
        $hotel = $this->hotels[$this->highlightIndex] ?? null;
        if ($hotel) {
            $this->redirect(route('f.onboarding', $hotels['id']));
        }
    }

    public function updatedQuery()
    {
        $this->hotels = ($this->country['code']) ?
            Hotels::where('name', 'like', '{"en":"' . $this->query . '%')
                                  ->where('country_id', Countries::where('code', 'like', '%'.$this->country['code'].'%')->pluck('id')[0])
                                  ->get()
                                  ->toArray() : 
            Hotels::where('name', 'like', '{"en":"' . $this->query . '%')
            				      ->get()
            				      ->toArray();
    }

    public function render()
    {
        return view('livewire.hotel-search', [
            'hotels'        => $this->hotels, 
            'selCountry'    => $this->country,
            'selHotel'      => $this->hotel
        ]);
    }
}
