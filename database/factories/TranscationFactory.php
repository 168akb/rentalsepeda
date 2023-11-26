<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Transcation;

$factory->define(Transcation::class, function (Faker $faker) {

	$id = IdGenerator::generate(['table' => 'transcations', 'length' => 10, 'prefix' =>'INV-', 'field' => 'invoices_number']);
	$startDate = $faker->dateTimeThisMonth('+1 month');
	$endDate = strtotime('+1 Week', $startDate->getTimestamp());

    return [
            // 'invoices_number' => IdGenerator::generate(['table' => 'transcations', 'length' => 10, 'prefix' =>'INV-', 'field' => 'invoices_number']),
            'user_id' => $faker->numberBetween($min = 1, $max = 9),
            'tgl_sewa' => $startDate,
            'tgl_kembali' => $endDate,
            'dikembalikan_pada' => $endDate,
            'damage_fine' => '0',
            'total_denda' => '0',
            'total' => '15000',
            'grand_total' => '15000',
            'metode_pembayaran' => 'Tunai',
            'status' => 'Selesai',
            'bukti_pembayaran' => '',

    ];
});
