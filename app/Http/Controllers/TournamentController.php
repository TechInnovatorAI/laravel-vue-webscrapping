<?php

namespace App\Http\Controllers;

use App\Models\ResultMatch;
use Illuminate\Http\Request;
use App\Models\Tournament;
use App\Models\TournamentMatch;
use App\Models\OfficialRanking;
use App\Models\Ranking1;
use App\Models\Ranking2;
use App\Models\Result;
use App\Models\AthleteRanking;
use App\Models\DrawLink;
use App\Models\Player;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\ScrapeController;

class TournamentController extends Controller
{
    public function all()
    {
        $tournaments = Tournament::orderBy('id', 'DESC')->get();
        return response()->json($tournaments, 200);
    }

    public function archive()
    {
        $archives = Result::with('tournaments')->get();
        //dd($archives);
        return response()->json($archives, 200);
    }

    public function delete_archive($id)
    {
        Result::where('tournament_id', $id)->delete();
        AthleteRanking::where('t_id', $id)->delete();
        DrawLink::where('t_id', $id)->delete();
        Player::where('t_id', $id)->delete();
        TournamentMatch::where('t_id', $id)->delete();
        ResultMatch::where('t_id', $id)->delete();
        $archives = Result::all();

        return response()->json($archives, 200);
    }

    public function getTournamentTypes()
    {
        $tournamentTypes = Tournament::all()->pluck('tournament_name');
        return response()->json($tournamentTypes, 200);
    }




    public function updateFilter()
    {
        $years = AthleteRanking::select('year')->groupBy('year')->pluck('year');
        $weight = AthleteRanking::select('weight')->groupBy('weight')->pluck('weight');
        $weightGroups = AthleteRanking::select('weight_group')->groupBy('weight_group')->pluck('weight_group');
        $countries = AthleteRanking::select('country')->groupBy('country')->pluck('country');
        $tournamentTypes = Tournament::all()->pluck('tournament_name');
        return response()->json(['years' => $years, 'weights' => $weight, 'weightGroups' => $weightGroups, "countries" => $countries, 'tournamentTypes' => $tournamentTypes], 200);
    }
    public function getWeightByCategory($category)
    {
        try {
            $weights = AthleteRanking::where('category_group', $category)
                ->distinct('weight')->pluck('weight');
            return response()->json(['weights' => $weights], 200);
        } catch (\Exception $e) {

            Log::error("Error in getWeightByCategory: " . $e->getMessage());
            return response()->json(['error' => 'Server error occurred.'], 500);
        }
    }

    public function getWeightGroupByCategory($category)
    {
        try {
            $weightGroups = AthleteRanking::where('category_group', $category)
                ->distinct('weight_group')->pluck('weight_group');
            return response()->json(['weightGroups' => $weightGroups], 200);
        } catch (\Exception $e) {

            Log::error("Error in getWeightByCategory: " . $e->getMessage());
            return response()->json(['error' => 'Server error occurred.'], 500);
        }
    }

    function custom_trim($string)
    {
        return preg_replace('/^\s+|\s+$/u', '', $string);
    }

    public function athleteFilter(Request $request)
    {
        $results = AthleteRanking::all();
        $nameList = Player::all();

        // $results->where('name', "ANGEI FERRARIO LUCA");
        // Apply filters based on request parameters
        $results->when($request->year, function ($query, $year) {
            return $query->whereIn('year', $year);
        });

        $results->when($request->tournamentType, function ($query, $tournamentType) {
            return $query->whereIn('tournament_name', $tournamentType);
        });

        $results->when($request->category, function ($query, $category) {
            return $query->whereIn('category_group', $category);
        });

        $results->when($request->weight, function ($query, $weight) {
            return $query->whereIn('weight', $weight);
        });

        $results->when($request->weightGroups, function ($query, $weightGroup) {
            return $query->whereIn('weight_group', $weightGroup);
        });

        $results->when($request->country, function ($query, $country) {
            return $query->whereIn('country', $country);
        });

        $results->when($request->gender, function ($query, $gender) {
            return $query->whereIn('male_female', $gender);
        });

        // Access the result_tournament relationship for each ResultMatch instance
        // Initialize an array to store merged results

        $count_of_toptournaments = $request->input('topOpentounaments');
        $groupedData = [];

        // Iterate through the original list
        foreach ($nameList as $name) {
            // Check if the player name already exists as a key in the groupedData array
            if (!isset($groupedData[$name['player_name']])) {
                // If not, initialize an empty array for that player name
                $groupedData[$name['player_name']] = [];
            }
            // Add the name to the array corresponding to the player name
            $groupedData[$name['player_name']][] = $name;
        }
        // Check if $groupedData is a string containing JSON data
        if (is_string($groupedData)) {
            // It's a string, so we can decode it
            $groupedData1 = json_decode($groupedData, true);
        } elseif (is_array($groupedData)) {
            // It's already an array, so no need to decode
            $groupedData1 = $groupedData;
        }


        $topOpen_list = [];
        foreach ($groupedData1 as $groups) {
            $count = 0;
            foreach ($groups as $group) {
                // Retrieve and trim player name.
                $goodName = $this->custom_trim($this->normalizeName($group->player_name));
                $goodId = $group->t_id;
                // Retrieve t_id and find the corresponding ranking.
                $ranking = AthleteRanking::where('name', $goodName)->where('t_id', $goodId)->get();

                if (count($ranking)) { // Ensure that the ranking exists before continuing.
                    // $topOpen_list[] = $ranking;
                    $matches = json_decode($ranking[0]->matches, true);
                    $totalMatches = is_array($matches) ? count($matches) : 0;
                    // Check if the tournament ID is one of the specified IDs and count is within limit.
                    if (
                        ($count < $count_of_toptournaments ) &&
                        (($group['tournament_id'] == 8 || $group['tournament_id'] == 11))
                    ) {
                        $this->addToTopList($topOpen_list, $goodName, $ranking, $totalMatches);
                        $count++;
                    } elseif (!in_array($group['tournament_id'], [8, 11])) {
                        $this->addToTopList($topOpen_list, $goodName, $ranking, $totalMatches);
                    }
                }
            }


        }
        $finalOutput = [];
        foreach ($topOpen_list as $item) {
            array_push($finalOutput, $item);
        }

        return response()->json($finalOutput);
    }
    function addToTopList(&$topOpen_list, $goodName, $ranking, $totalMatches)
    {
        $fieldsToUpdate = ['official_ranking', 'difference', 'lose', 'win', 'point_diff', 'point_scored', 'point_suffered', 'ranking1', 'ranking2', 'total_matches'];

        // If the athlete already exists in the list, increment their stats.
        if (array_key_exists($goodName, $topOpen_list)) {
            foreach ($fieldsToUpdate as $field) {
                $topOpen_list[$goodName][$field] += $ranking[0]->$field;
            }
            $topOpen_list[$goodName]['total_matches'] += $totalMatches;
        } else {
            // Otherwise, initialize their stats based on the current ranking record.
            $topOpen_list[$goodName] = collect($ranking[0]->toArray())
                ->only(array_merge($fieldsToUpdate, ['id', 'male_female', 'weight_group', 'weight']))
                ->put('name', $goodName)
                ->put('total_matches', $totalMatches)
                ->all();
        }
    }



    public function filter(Request $request)
    {

        $results = ResultMatch::query();

        $results->when($request->year, function ($query, $year) {
            return $query->whereIn('year', $year);
        });

        $results->when($request->tournamentType, function ($query, $tournamentType) {
            return $query->whereIn('tournament_name', $tournamentType);
        });

        $results->when($request->category, function ($query, $category) {
            return $query->where(function ($query) use ($category) {
                foreach ($category as $cat) {
                    $query->orWhere('category_group', $cat);
                }
            });
        });

        $results->when($request->weight, function ($query, $weight) {
            return $query->whereIn('weight', $weight);
        });
        $results->when($request->weightGroups, function ($query, $weightGroup) {
            return $query->whereIn('weight_group', $weightGroup);
        });

        $results->when($request->gender, function ($query, $gender) {
            return $query->whereIn('male_female', $gender);
        });

        // Execute the query and get the results
        $results = $results->get();

        // dd($results->toArray());

        $filtered = [];
        foreach ($results as $result) {
            // $index = $result->name;
            $index = $result->name;
            if (isset($filtered[$index])) {
                array_push($filtered[$index]["results"], $result->toArray());
                $filtered[$index]["total_scores"] += $result->pti;
                if (!$this->isFound($filtered[$index]["tournament_name"], $result->tournament_name)) {
                    $filtered[$index]["tournament_name"] .= ", " . $result->tournament_name;
                }
                if (!$this->isFound($filtered[$index]["class"], $result->class)) {
                    $filtered[$index]["class"] .= ", " . $result->category_group;
                }
                if (!$this->isFound($filtered[$index]["year"], $result->year)) {
                    $filtered[$index]["year"] .= ", " . $result->year;
                }
                if (!$this->isFound($filtered[$index]["weight"], $result->weight)) {
                    $filtered[$index]["weight"] .= ", " . $result->weight;
                }
                if (!$this->isFound($filtered[$index]["weight_group"], $result->weight_group)) {
                    $filtered[$index]["weight_group"] .= ", " . $result->weight_group;
                }
            } else {
                $filtered[$index]["results"] = [$result->toArray()];
                $filtered[$index]["total_scores"] = $result->pti;
                $filtered[$index]["name"] = $result->name;
                $filtered[$index]["club"] = $result->club;
                $filtered[$index]["male_female"] = $result->male_female;
                $filtered[$index]["tournament_name"] = $result->tournament_name;
                $filtered[$index]["class"] = $result->category_group;
                $filtered[$index]["year"] = $result->year;
                $filtered[$index]["weight"] = $result->weight;
                $filtered[$index]["weight_group"] = $result->weight_group;
            }
        }
        $filtered_results = [];
        foreach ($filtered as $res) {
            array_push($filtered_results, $res);
        }
        // Return the results as JSON
        return response()->json($filtered_results);
    }

    public function isFound($string, $search)
    {
        if (strpos($string, $search) !== false) {
            return true;
        } else {
            return false;
        }
    }

    public function save(Request $request)
    {
        $request->validate([
            'tournament_name' => 'required',
        ]);
        if ($request->id) {
            $tournament = Tournament::find($request->id);
        } else {
            $tournament = new Tournament();
        }
        $tournament->tournament_name = $request->tournament_name;
        $tournament->save();

        $official_raking = new OfficialRanking();
        $official_raking->tournament_id = $tournament->id;
        $official_raking->save();

        $raking1 = new Ranking1();
        $raking1->tournament_id = $tournament->id;
        $raking1->save();

        $raking2 = new Ranking2();
        $raking2->tournament_id = $tournament->id;
        $raking2->save();

        $tournaments = Tournament::orderBy('id', 'DESC')->get();
        return response()->json($tournaments, 200);
    }

    public function delete($id)
    {
        $tournament = Tournament::find($id);
        $tournament->save();
        $tournaments = Tournament::orderBy('id', 'DESC')->get();
        return response()->json($tournaments, 200);
    }

    public function getAtheleteRankings()
    {

        $namesWithDuplicates = AthleteRanking::select('name')
            ->groupBy('name')
            ->havingRaw('COUNT(*) > 1')
            ->pluck('name');

        $results = AthleteRanking::whereIn('name', $namesWithDuplicates)->get();


        return response()->json($results);

    }
    public function fetchTournamentDetails(Request $request)
    {
        // dd($request->all());
        $filters = $request->filters;
        try {
            // $athleteData = AthleteRanking::where('name', $request->name)->get();

            $results = AthleteRanking::query();

            $results->where('name', $request->name);
            // Apply filters based on request parameters
            $results->when($filters['year'], function ($query, $year) {
                return $query->whereIn('year', $year);
            });

            $results->when($filters['tournamentType'], function ($query, $tournamentType) {
                return $query->whereIn('tournament_name', $tournamentType);
            });

            $results->when($filters['category'], function ($query, $category) {
                return $query->whereIn('category_group', $category);
            });

            $results->when($filters['weight'], function ($query, $weight) {
                return $query->whereIn('weight', $weight);
            });

            $results->when($filters['weightGroups'], function ($query, $weightGroup) {
                return $query->whereIn('weight_group', $weightGroup);
            });

            $results->when($filters['country'], function ($query, $country) {
                return $query->whereIn('country', $country);
            });

            $results->when($filters['gender'], function ($query, $gender) {
                return $query->whereIn('male_female', $gender);
            });

            $results = $results->get();

            $athleteData = $results;

            // $resultMatchesData = ResultMatch::where('name', $name)->get();

            $data = [
                'athleteRankings' => $athleteData,
            ];

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
    function normalizeName($string)
    {
        $replace = array(
            'À' => 'A',
            'Á' => 'A',
            'Â' => 'A',
            'Ã' => 'A',
            'Ä' => 'A',
            'Å' => 'A',
            'Æ' => 'AE',
            'Ç' => 'C',
            'È' => 'E',
            'É' => 'E',
            'Ê' => 'E',
            'Ë' => 'E',
            'Ì' => 'I',
            'Í' => 'I',
            'Î' => 'I',
            'Ï' => 'I',
            'Ð' => 'D',
            'Ñ' => 'N',
            'Ò' => 'O',
            'Ó' => 'O',
            'Ô' => 'O',
            'Õ' => 'O',
            'Ö' => 'O',
            'Ø' => 'O',
            'Ù' => 'U',
            'Ú' => 'U',
            'Û' => 'U',
            'Ü' => 'U',
            'Ý' => 'Y',
            'Þ' => 'B',
            'ß' => 'Ss',
            'à' => 'a',
            'á' => 'a',
            'â' => 'a',
            'ã' => 'a',
            'ä' => 'a',
            'å' => 'a',
            'æ' => 'ae',
            'ç' => 'c',
            'è' => 'e',
            'é' => 'e',
            'ê' => 'e',
            'ë' => 'e',
            'ì' => 'i',
            'í' => 'i',
            'î' => 'i',
            'ï' => 'i',
            'ð' => 'o',
            'ñ' => 'n',
            'ò' => 'o',
            'ó' => 'o',
            'ô' => 'o',
            'õ' => 'o',
            'ö' => 'o',
            'ø' => 'o',
            'ù' => 'u',
            'ú' => 'u',
            'û' => 'u',
            'ü' => 'u',
            'ý' => 'y',
            'þ' => 'b',
            'ÿ' => 'y'
        );
        return strtr($string, $replace);
    }


}
