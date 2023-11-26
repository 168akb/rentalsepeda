<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\User;
use App\Transcation;
use App\ProductTranscation;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class DataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {

    for ($year = 2019; $year <= 2023; $year++){

	    for ($month = 1; $month <= 12; $month++){

	    	for ($day = 1; $day <= 31; $day++){

	    		$date = Carbon::create($year, $month, $day);

			    for ($i=0; $i < rand(2 , 10); $i++) {

			    	$id = IdGenerator::generate(['table' => 'transcations', 'length' => 10, 'prefix' =>'INV-', 'field' => 'invoices_number']);
					$endDate = $faker->dateTImeBetween($date, $date->format('Y-m-d H:i:s').' +7 days');

			        Transcation::create([
			            'invoices_number' => $id,
			            'user_id' => rand(33,36),
			            'tgl_sewa' => $date,
			            'tgl_kembali' => $endDate,
			            'dikembalikan_pada' => $endDate,
			            'damage_fine' => '0',
			            'total_denda' => '0',
			            'total' => '0',
			            'grand_total' => '0',
			            'metode_pembayaran' => 'Tunai',
			            'status' => 'Selesai',
			            'bukti_pembayaran' => '',
			        ]);

			        ProductTranscation::create([
			        	'product_id' => random_int(1,16),
			        	'invoices_number' => $id,
			        	'qty' => 1,
			        ]);
		    	} 
		    }
	    }
	}
	
	  //   for ($i=0; $i < 100; $i++) {

	  //   	$id = IdGenerator::generate(['table' => 'transcations', 'length' => 10, 'prefix' =>'INV-', 'field' => 'invoices_number']);
	  //   	$startDate = $faker->dateTimeThisYear('-1 year');
			// $endDate = $faker->dateTImeBetween($startDate, $startDate->format('Y-m-d H:i:s').' +7 days');

	  //       Transcation::create([
	  //           'invoices_number' => $id,
	  //           'user_id' => rand(33,36),
	  //           'tgl_sewa' => $startDate,
	  //           'tgl_kembali' => $endDate,
	  //           'dikembalikan_pada' => $endDate,
	  //           'damage_fine' => '0',
	  //           'total_denda' => '0',
	  //           'total' => '0',
	  //           'grand_total' => '0',
	  //           'metode_pembayaran' => 'Tunai',
	  //           'status' => 'Selesai',
	  //           'bukti_pembayaran' => '',
	  //       ]);

	  //       ProductTranscation::create([
	  //       	'product_id' => random_int(1,16),
	  //       	'invoices_number' => $id,
	  //       	'qty' => 1,
	  //       ]);
   //  	} 

    }
}
