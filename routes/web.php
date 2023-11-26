<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Posts;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
*/

Route::get('/', function () {
    return redirect('login');
});

Route::post('/products/restore/{id}','ProductController@restore')->name('products.restore');

Auth::routes();

Route::get('/guest', 'GuestController@index');

Route::group(['middleware' => ['auth']], function () {  
    Route::get('/home', 'HomeController@index')->name('home');
    

    Route::resource('/sepeda/products','ProductController');
    Route::resource('/sepeda/mereks','MerekController');
    Route::resource('/sepeda/kategori','KategoriController');

    Route::get('/sepeda/restore_sepeda', 'ProductController@restore_sepeda')->name('product.restore_sepeda');
    Route::post('/sepeda/cleardamage/{id}', 'ProductController@cleardamage')->name('product.cleardamage');

    Route::get('/sepeda/hilang', 'ProductController@hilang')->name('product.hilang');
    Route::post('/sepeda/tidakhilang/{id}', 'ProductController@tidakhilang')->name('product.tidakhilang');
    Route::post('/sepeda/tandaihilang/{id}', 'ProductController@tandaihilang')->name('product.tandaihilang'); 

    Route::get('/sepeda/inputkondisi/{id}', 'ProductController@inputkondisi')->name('product.inputkondisi');
    Route::post('/sepeda/damage/{id}', 'ProductController@damage')->name('product.damage'); 


    Route::get('/profile', 'ProfilController@index')->name('profile.index');
    Route::get('/profile/edit', 'ProfilController@edit')->name('profile.edit');
    Route::post('profile/edit', 'ProfilController@update')->name('profile.update');
    Route::get('profile/uploadktp', 'ProfilController@viewktp')->name('profile.viewktp');
    Route::post('profile/uploadktp', 'ProfilController@uploadktp')->name('profile.uploadktp');

    Route::resource('/user/users','UserController');
    Route::resource('/user/members','MemberController');
    Route::resource('/user/admins','AdminController');

    Route::get('/home/filter', 'HomeController@filter')->name('home.filter');
    
    Route::get('/transcation/search','TransactionController@search');

    Route::get('/transcation', 'TransactionController@index');
    Route::post('/transcation/addproduct/{id}', 'TransactionController@addProductCart');
    Route::post('/transcation/removeproduct/{id}', 'TransactionController@removeProductCart');
    Route::post('/transcation/clear', 'TransactionController@clear');
    Route::post('/transcation/increasecart/{id}', 'TransactionController@increasecart');
    Route::post('/transcation/decreasecart/{id}', 'TransactionController@decreasecart');
    Route::post('/transcation/bayar','TransactionController@bayar');
    
    Route::get('/transaksi/onprocess','TransactionController@history');
    Route::get('/transaksi/history','TransactionController@historyfinished');

    Route::get('/transaksi/laporan/{id}','TransactionController@laporan');
    Route::get('/transaksi/cetak/{id}','TransactionController@cetak')->name('transaksi.cetak');
    Route::match(array('GET','POST'),'/transaksi/detail/{id}','TransactionController@detail');
    Route::match(array('GET','POST'),'/transaksi/complete/{id}', 'TransactionController@complete');
    Route::match(array('GET','POST'),'/transaksi/perpanjang/{id}', 'TransactionController@perpanjang');

    Route::post('/transaksi/update/{id}','TransactionController@update');
    Route::post('/transaksi/tolak/{id}','TransactionController@tolakperpanjang')->name('transaksi.tolakperpanjang');

    Route::get('transaksi/cancel/{id}', 'TransactionController@cancel')->name('transaksi.cancel');

    Route::get('transaksi/upload/{id}', 'TransactionController@transfer')->name('transaksi.upload');
    Route::post('/transaksi/uploadbukti/{id}','TransactionController@uploadbukti');
    
    Route::get('/transaksi/verify/{id}','TransactionController@verify');
    Route::post('/transaksi/verified/{id}','TransactionController@verified');
    Route::post('/transaksi/invalid/{id}','TransactionController@invalid')->name('transaksi.invalid');

    Route::get('/transaksi/approve/{id}','TransactionController@approve');
    Route::post('/transaksi/approved/{id}','TransactionController@approved');

    Route::post('/transaksi/ambil/{id}','TransactionController@ambil')->name('transaksi.ambil');
});




