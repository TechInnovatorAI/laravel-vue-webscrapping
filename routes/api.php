<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ScrapeController;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\OfficialRankingController;
use App\Http\Controllers\PaypalController;



Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/sign', [AuthController::class, 'sign']);
Route::post('auth/updateEnddate', [AuthController::class, 'updateEnddate']);
//Paypal Routes
Route::get('paypal', [PaypalController::class, 'view']);
Route::post('paypal/create', [PaypalController::class, 'PayPal']);
Route::post('paypal/transaction', [PaypalController::class, 'Transaction']);

Route::post('scrape', [ScrapeController::class, 'scrapeData']);
Route::post('scrape-draw', [ScrapeController::class, 'scrapeDraw']);
Route::get('create-athlete-ranking/{t_id}/{tournament_id}', [ScrapeController::class, 'createAthleteRankings']);
Route::post('scrape-draws/{draw_id}', [ScrapeController::class, 'scrapeDraws']);
Route::get('tournament-types', [TournamentController::class, 'getTournamentTypes']);
Route::get('/tournaments/filter', [TournamentController::class, 'filter']);
Route::get('/tournaments/athlete-filter', [TournamentController::class, 'athleteFilter']);
Route::get('/tournaments/updateFilter', [TournamentController::class, 'updateFilter']);
// Route::get('/all-athelete-rankings',[TournamentController::class,'getAtheleteRankings']);
Route::post('/fetch-tournament-details', [TournamentController::class, 'fetchTournamentDetails']);

Route::get('getWeightByCategory/{category}',[TournamentController::class,'getWeightByCategory']);
Route::get('getWeightGroupByCategory/{category}',[TournamentController::class,'getWeightGroupByCategory']);

Route::get('record/{record_id}', [ScrapeController::class, 'getRecord']);

Route::get('reviews/{asin}', [ScrapeController::class, 'getReviews']);

Route::get('official-rankings', [OfficialRankingController::class, 'getRankings']);
Route::post('rankings/update', [OfficialRankingController::class, 'update']);

Route::prefix('tournament')->group(function () {
    Route::get('all', [TournamentController::class, 'all']);
    Route::get('archive', [TournamentController::class, 'archive']);
    Route::get('archive/delete/{id}', [TournamentController::class, 'delete_archive']);
    Route::post('save', [TournamentController::class, 'save']);
    Route::get('delete/{id}', [TournamentController::class, 'delete']);
});

Route::get('athelete', [ScrapeController::class, 'createAthleteRankings']);
Route::get('athlete-rankings', [ScrapeController::class, 'allAtheleteRankings']);

Route::get('check-call', [TournamentController::class, "checkCall"]);


Route::get("tournament-players/{t_id}/{tournament_id}", [ScrapeController::class, "allPlayers"]);
Route::get("athelete-player-ranking/{from}/{to}", [ScrapeController::class, "athletePlayerRankings"]);


//test api
Route::get("athelete-player-total-wins/{player_name}/{t_id}/{tournament_id}", [ScrapeController::class, "getTotalWins"]);
Route::get("update_athleteRanking", [OfficialRankingController::class, "update_Athlete_OfficialRanking"]);

