<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicTacToeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/tictactoe', [TicTacToeController::class, 'index'])
    ->name('tictactoe.index');
Route::post('/tictactoe/handleMove', [TicTacToeController::class, 'handleMove'])
    ->name('tictactoe.handleMove');
Route::get('/tictactoe/clear', [TicTacToeController::class, 'clearGameData'])
    ->name('tictactoe.clearGameData');
Route::post('/tictactoe/play', [TicTacToeController::class, 'play'])
    ->name('tictactoe.play');
