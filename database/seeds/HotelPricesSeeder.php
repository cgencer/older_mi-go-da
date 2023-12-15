<?php

use Illuminate\Database\Seeder;

class HotelPricesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $error = 0;
        $hotels = DB::connection('mysql_beta')->select('select * from hotels');
        $this->command->getOutput()->progressStart(count($hotels));
        foreach ($hotels as $hotel) {
            try {
                $findHotel = \App\Models\Hotels::where('oldID', $hotel->oldID)->get();
                if ($findHotel->count() > 0) {
                    $findHotel = $findHotel->first();
                    $findHotel->price = $hotel->price;
                    if (!empty($hotel->price)) {
                        $findHotel->regular_price = ($hotel->price / 100);
                    } else {
                        $findHotel->regular_price = null;
                    }
                    $findHotel->save();
                    $this->command->getOutput()->progressAdvance();
                } else {
                    $this->command->error(PHP_EOL . 'Hotel bulunamadı var. Hotel ID: ' . $hotel->id);
                    $error++;
                }
            } catch (Exception $e) {
                $this->command->error(PHP_EOL . 'Hata var. Hotel ID: ' . $hotel->id);
                $this->command->alert('Hata: ' . $e->getTraceAsString());
                $error++;
                die();
            }
        }
        if ($error > 0) {
            $this->command->info('Hotel price bilgileri güncellendi ama bazı hoteller aktarılırken sorun yaşandı.');
        } else {
            $this->command->info('Hotel price bilgileri güncellendi .');
        }
        $this->command->getOutput()->progressFinish();
    }
}
