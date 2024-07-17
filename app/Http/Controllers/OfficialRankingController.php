<?php

namespace App\Http\Controllers;

use App\Models\ResultMatch;
use Illuminate\Http\Request;
use App\Models\OfficialRanking;
use App\Models\Ranking1;
use App\Models\Ranking2;
use App\Models\Tournament;
use App\Models\AthleteRanking;
use App\Models\Player;
use App\Models\TournamentMatch;

use Illuminate\Support\Facades\Log;

class OfficialRankingController extends Controller
{
    public function getRankings()
    {
        $rankings = OfficialRanking::with('tournament')->get();
        $rankings1 = Ranking1::with('tournament')->get();
        $rankings2 = Ranking2::with('tournament')->get();
        $data = [
            "rankings" => $rankings,
            "rankings1" => $rankings1,
            "rankings2" => $rankings2,
        ];
        return response()->json($data, 200);
    }

    public function update(Request $request)
    {
        $rankings = $request->rankings;
        $official = $request->update;
        $aaa = [];
        foreach ($rankings as $rank) {

            if ($request->update == 1) {
                $ranking = OfficialRanking::find($rank['id']);
            } elseif ($request->update == 2) {
                $ranking = Ranking1::find($rank['id']);
            } elseif ($request->update == 3) {
                $ranking = Ranking2::find($rank['id']);
            }
            $ranking->posto_1 = $rank['posto_1'];
            $ranking->posto_2 = $rank['posto_2'];
            $ranking->posto_3 = $rank['posto_3'];
            $ranking->posto_5 = $rank['posto_5'];
            $ranking->posto_7 = $rank['posto_7'];
            $ranking->posto_9 = $rank['posto_9'];
            $ranking->posto_11 = $rank['posto_11'];
            $ranking->finalist_quarti = $rank['finalist_quarti'];
            $ranking->incontri_vinti = $rank['incontri_vinti'];
            $ranking->partecipazione = $rank['partecipazione'];

            if ($rank['id'] != 3 && $rank['id'] != 6) {
                $ranking->fattore = $rank['fattore'];
            } elseif ($rank['id'] == 3) {
                $open_fattore = TournamentMatch::where('tournament_id', 8)->first();
                if ($open_fattore) {
                    $ranking->fattore = $open_fattore->fattore;
                }

            } else {
                $open_fattore = TournamentMatch::where('tournament_id', 11)->first();
                if ($open_fattore) {
                    $ranking->fattore = $open_fattore->fattore;
                }
            }
            $ranking->save();

            $this->update_Athlete_OfficialRanking($ranking, $official);
            // $aaa = $this->update_Athlete_OfficialRanking($ranking, $official);

            array_push($aaa, $this->update_Athlete_OfficialRanking($ranking, $official));
        }

        return response()->json(["message" => $rankings], 200);
    }
    public function update_Athlete_OfficialRanking($ranking, $official)
    {
        $a = $ranking->partecipazione;
        $athleteRanking_gorups = $this->getAthleteRankingsByTournament($ranking['tournament_id'], $official);


        $result = [];
        foreach ($athleteRanking_gorups as $athlete_rank) {

            $player_name = $athlete_rank['name'];
            $t_id = $athlete_rank['t_id'];
            $tournament_id = $athlete_rank['tournament_id'];
            $b = $this->getTotalWins($player_name, $t_id, $tournament_id) * 10;

            $result_match = ResultMatch::where(['name' => $player_name, 'tournament_id' => $tournament_id])->first();



            $c = 0;
            if ($result_match) {
                $rank = $result_match->rank;
                $c = $this->rankPosto($ranking, $rank);
            }

            $f = $ranking['fattore'];
            $cal_ranking = ($a + $b + $c) * $f;
            $athlete_rank->official_ranking = $cal_ranking;
            $athlete_rank->save();
            array_push($result, ['result' => $result_match, 'a' => $a, 'b' => $b, 'c' => $c, 'f' => $f, 'cal_ranking' => $cal_ranking]);
        }
        return ['a' => $ranking['tournament_id'], 'b' => $official, 'c' => $athleteRanking_gorups, 'd' => $result];
    }

    public function getAthleteRankingsByTournament($tournamentId, $official)
    {
        if ($official == 1) {
            $athleteRankingGroups = AthleteRanking::where('tournament_id', $tournamentId)->where('tournament_id', '!=', 8)->where('tournament_id', '!=', 11)->get();
        } elseif ($official == 2) {
            $athleteRankingGroups = Ranking1::where('tournament_id', $tournamentId)->where('tournament_id', '!=', 8)->where('tournament_id', '!=', 11)->get();
        } elseif ($official == 3) {
            $athleteRankingGroups = Ranking2::where('tournament_id', $tournamentId)->where('tournament_id', '!=', 8)->where('tournament_id', '!=', 11)->get();
        }
        return $athleteRankingGroups;
    }

    public function getTotalWins($player_name, $t_id, $tournament_id)
    {
        $matches = TournamentMatch::where('t_id', $t_id)
            ->where('tournament_id', $tournament_id)
            ->where(function ($query) use ($player_name) {
                $query->where('player1_name', $player_name)->orWhere('player2_name', $player_name);
            })->get();
        $total_wins = 0;
        foreach ($matches as $match) {

            if ($match->player1_name == $player_name && $match->player1_is_win == 1) {
                $total_wins++;
            } elseif ($match->player2_name == $player_name && $match->player2_is_win == 1) {
                $total_wins++;
            }

            if ($match->player1_name == $player_name && $match->player1_is_free_win == 1) {
                $total_wins++;
            } elseif ($match->player2_name == $player_name && $match->player2_is_free_win == 1) {
                $total_wins++;
            }

        }

        return $total_wins;
    }
    public function rankPosto($rank_input, $ranking)
    {
        $posto = 0;
        if ($ranking == 1) {
            $posto = $rank_input['posto_1'];
        } else if ($ranking == 2) {
            $posto = $rank_input['posto_2'];
        } else if ($ranking == 3) {
            $posto = $rank_input['posto_3'];
        } else if ($ranking == 5) {
            $posto = $rank_input['posto_5'];
        } else if ($ranking == 7) {
            $posto = $rank_input['posto_7'];
        } else if ($ranking == 9) {
            $posto = $rank_input['posto_9'];
        } else if ($ranking == 11 || $ranking == 15) {
            $posto = $rank_input['posto_11'];
        }

        return $posto;
    }
}
