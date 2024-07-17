<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\{AthleteRanking, Player, ResultMatch, TournamentMatch, OfficialRanking, Tournament, Ranking1, Ranking2};
use App\Http\Controllers\ScrapeController;

class CreateAthleteRankingsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $t_id;
    protected $tournament_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($t_id, $tournament_id)
    {
        $this->t_id = $t_id;
        $this->tournament_id = $tournament_id;
    }

    public function calculateOfficialRanking($tournament_id, $t_id, $player_name, $rank, $ranking){
        // dd($tournament_id, $t_id, $player_name, $rank, $ranking);
        $tournament = Tournament::find($tournament_id);
        if($ranking == 'official'){
            $official = OfficialRanking::where('tournament_id', $tournament_id)->first();
        }else if($ranking == 'ranking1'){
            $official = Ranking1::where('tournament_id', $tournament_id)->first();
        }else if($ranking == 'ranking2'){
            $official = Ranking2::where('tournament_id', $tournament_id)->first();
        }
        $a = $official->partecipazione;
        $b = $this->getTotalWins($player_name, $t_id, $tournament_id);
        $c = $this->rankPosto($rank, $tournament_id, $ranking);
        $f = $official->fattore;
        $cal_ranking = ($a + $b + $c) * $f;

        return $cal_ranking;
    }

    public function custom_trim($string){
        return preg_replace('/^\s+|\s+$/u', '', $string);
    }

    public function getTotalWins($player_name, $t_id, $tournament_id){
        $matches = TournamentMatch::where('t_id', $t_id)
                    ->where('tournament_id', $tournament_id)
                    ->where(function($query) use ($player_name) {
                        $query->where('player1_name', $player_name)->orWhere('player2_name', $player_name);
                    })->get();
        $total_wins = 0;
        foreach ($matches as $match) {
            if ($this->custom_trim($match->player1_name) == $player_name && $match->player1_is_win == 1) {
                $total_wins++;
            } elseif ($this->custom_trim($match->player2_name) == $player_name && $match->player2_is_win == 1) {
                $total_wins++;
            }
        }
        return $total_wins;
    }

    public function rankPosto($rank, $tour_id, $ranking){
        if($ranking == 'official'){
            $official = OfficialRanking::where('tournament_id', $tour_id)->first();
        }else if($ranking == 'ranking1'){
            $official = Ranking1::where('tournament_id', $tour_id)->first();
        }else if($ranking == 'ranking2'){
            $official = Ranking2::where('tournament_id', $tour_id)->first();
        }
        $posto = 0;
        if($rank == 1){
            $posto = $official->posto_1;
        }else if($rank == 2){
            $posto = $official->posto_2;
        }else if($rank == 3){
            $posto = $official->posto_3;
        }else if($rank == 5){
            $posto = $official->posto_5;
        }else if($rank == 7){
            $posto = $official->posto_7;
        }else if($rank == 9){
            $posto = $official->posto_9;
        }else if($rank == 11 || $rank == 15){
            $posto = $official->posto_11;
        }

        return $posto;
    }

    public function getPlayerCountry($player_name){
        $tournament_match = TournamentMatch::where('player1_name', $player_name)
                                          ->orWhere('player2_name', $player_name)
                                          ->first();
    
        if($tournament_match){
            return ($tournament_match->player1_name == $player_name)
                ? $tournament_match->player1_country
                : $tournament_match->player2_country;
        }
    
        return 'Player country not found'; // Example default value
    }

    public function getTotalLosses($player_name, $t_id, $tournament_id){
        $matches = TournamentMatch::where('t_id', $t_id)
                    ->where('tournament_id', $tournament_id)
                    ->where(function($query) use ($player_name) {
                        $query->where('player1_name', $player_name)->orWhere('player2_name', $player_name);
                    })->get();
        $total_losses = 0;
        foreach ($matches as $match) {
            if ($this->custom_trim($match->player1_name) == $player_name && $match->player1_is_win == 0) {
                $total_losses++;
            } elseif ($this->custom_trim($match->player2_name) == $player_name && $match->player2_is_win == 0) {
                $total_losses++;
            }
        }

        return $total_losses;
    }

    public function pointsCalc($player_name, $t_id, $tournament_id){
        $matches = TournamentMatch::where('t_id', $t_id)
                    ->where('tournament_id', $tournament_id)
                    ->where(function($query) use ($player_name) {
                        $query->where('player1_name', $player_name)->orWhere('player2_name', $player_name);
                    })->get();
        
        $total_points_gained = 0;
        $total_points_suffered = 0;
        $matches_list = [];
        
        foreach ($matches as $match) {
            if ($this->custom_trim($match->player1_name) == $player_name) {
                $total_points_gained += $match->player1_score;
                $total_points_suffered += $match->player2_score;
                $mtch = [
                    'player' => $player_name,
                    'opposition' => $match->player2_name,
                    'scores' => $match->player1_score,
                    'opposition_scores' => $match->player2_score,
                ];
                array_push($matches_list, $mtch);
            } else {
                $total_points_gained += $match->player2_score;
                $total_points_suffered += $match->player1_score;
                $mtch = [
                    'player' => $player_name,
                    'opposition' => $match->player1_name,
                    'scores' => $match->player2_score,
                    'opposition_scores' => $match->player1_score,
                ];
                array_push($matches_list, $mtch);
            }
        }
        
        $points_difference = $total_points_gained - $total_points_suffered;

        return [
            'total_points_gained' => $total_points_gained,
            'total_points_suffered' => $total_points_suffered,
            'points_difference' => $points_difference,
            'matches' => $matches_list,
        ];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $players = Player::where('t_id', $this->t_id)->where('tournament_id', $this->tournament_id)->get();
        foreach($players as $player){
            $player_name = $player->player_name;
            $result_match = ResultMatch::where('t_id', $this->t_id)->where('tournament_id', $this->tournament_id)->where('name', $player_name)->first();
            $tournament_match = TournamentMatch::where('t_id', $this->t_id)
                                    ->where('tournament_id', $this->tournament_id)
                                    ->where(function($query) use ($player_name) {
                                        $query->where('player1_name', $player_name)->orWhere('player2_name', $player_name);
                                    })->first();
            $athlete = new AthleteRanking();
            $athlete->name = $player_name;
            $athlete->club_name = $result_match->club ?? '';
            $athlete->country = $this->getPlayerCountry($player_name);
            $athlete->tournament_id = $tournament_match->tournament_id;
            $athlete->tournament_name = $tournament_match->tournament_name;
            $athlete->title = $tournament_match->title;
            $athlete->t_id = $tournament_match->t_id;
            $athlete->t_name = $tournament_match->t_name;
            $athlete->year = $tournament_match->year;
            $athlete->category = $tournament_match->class;
            $athlete->weight = $tournament_match->weight;
            $athlete->weight_group = $tournament_match->weight_group;
            $athlete->category_group = $tournament_match->category_group;
            $athlete->male_female = $tournament_match->male_female;
            $athlete->official_ranking = $this->calculateOfficialRanking($tournament_match->tournament_id, $tournament_match->t_id, $player_name, $result_match->rank ?? 0, 'official');
            $athlete->ranking1 = $this->calculateOfficialRanking($tournament_match->tournament_id, $tournament_match->t_id, $player_name, $result_match->rank ?? 0, 'ranking1');
            $athlete->ranking2 = $this->calculateOfficialRanking($tournament_match->tournament_id, $tournament_match->t_id, $player_name, $result_match->rank ?? 0, 'ranking2');
            $athlete->win = $this->getTotalWins($player_name, $tournament_match->t_id, $tournament_match->tournament_id);
            $athlete->lose = $this->getTotalLosses($player_name, $tournament_match->t_id, $tournament_match->tournament_id);
            $athlete->difference = $athlete->win - $athlete->lose;
            $points = $this->pointsCalc($player_name, $tournament_match->t_id, $tournament_match->tournament_id);
            $athlete->point_scored = $points['total_points_gained'];
            $athlete->point_suffered = $points['total_points_suffered'];
            $athlete->point_diff = $points['points_difference'];
            $athlete->matches = json_encode($points['matches']);
            if($tournament_match->tournament_name == "Open" || $tournament_match->tournament_name == "Open Internazionali"){
                $athlete->fattore = $tournament_match->fattore;
            }else{
                $official = OfficialRanking::where('tournament_id', $tournament_match->tournament_id)->first();
                $athlete->fattore = $official->fattore;
            }
            $athlete->save();
        }
    }
}
