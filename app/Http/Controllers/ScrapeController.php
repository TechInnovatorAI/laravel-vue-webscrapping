<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;
use Goutte\Client;
use Illuminate\Support\Str;
use App\Models\Result;
use App\Models\ResultTournament;
use App\Models\ResultMatch;
use App\Models\Record;
use App\Models\Tournament;
use App\Models\TournamentMatch;
use App\Models\AthleteRanking;
use App\Models\OfficialRanking;
use App\Models\Ranking1;
use App\Models\Ranking2;
use App\Models\DrawLink;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Psy\Readline\Hoa\Console;

class ScrapeController extends Controller
{
    public $all_data = [];
    public $count_all_data = 0;
    public function homePage()
    {
        $tournaments = ResultTournament::with('result', 'matches')->get();
        return view('welcome', get_defined_vars());
    }

    public function getCategoryGroup($name)
    {
        $trimmed = str_replace(" ", "", $name);
        $trimmed = trim($trimmed);
        $group = "";
        if ($trimmed == "ESORDIENTI") {
            $group = "ESO";
        } elseif ($trimmed === 'u14' || $trimmed === 'U14') {
            $group = 'ESO';
        } elseif ($trimmed === 'u21' || $trimmed === 'U21') {
            $group = 'U21';
        } elseif ($trimmed === ' SENIOR' || $trimmed === 'senior') {
            $group = 'SENIOR';
        } elseif ($trimmed === 'MASTER' || $trimmed === 'master') {
            $group = 'MASTER';
        } elseif ($trimmed == "CADETTI" || $trimmed == "CADETTE" || $trimmed == "CADET" || $trimmed == "Cadet" || $trimmed == "Cadets") {
            $group = "CADET";
        } elseif ($trimmed == "JUNIOR" || $trimmed == "JUNIORES" || $trimmed == "JUNIORS" || $trimmed == "Junior" || $trimmed == "Juniors") {
            $group = "JUNIOR";
        } else {
            $group = strtoupper($trimmed);
        }
        return $group;
    }

    public function getWeightCategory($weight, $gender, $class)
    {
        $trimmed = str_replace(" ", "", $weight);
        $trimmed = trim($trimmed);
        $genderTrimmed = str_replace(" ", "", $gender);
        $genderTrimmed = trim($genderTrimmed);
        $group = "";
        if ($genderTrimmed == "M") {
            if ($this->getCategoryGroup($class) == "ESO") {
                if ($trimmed == "38" || $trimmed == "40") {
                    $group = "38/40";
                } elseif ($trimmed == "43" || $trimmed == "45") {
                    $group = "43/45";
                } elseif ($trimmed == "48" || $trimmed == "50") {
                    $group = "48/50";
                } elseif ($trimmed == "53" || $trimmed == "55") {
                    $group = "53/55";
                } elseif ($trimmed == "58" || $trimmed == "63" || $trimmed == "68" || $trimmed == "75" || $trimmed == "75+" || $trimmed == "55+") {
                    $group = "58/75+";
                } else {
                    $group = $trimmed;
                }
            } elseif ($this->getCategoryGroup($class) == "CADET") {
                if ($trimmed == "47" || $trimmed == "52") {
                    $group = "47/52";
                } elseif ($trimmed == "78" || $trimmed == "70+" || $trimmed == "78+") {
                    $group = "70/78+";
                } else {
                    $group = $trimmed;
                }
            } elseif ($this->getCategoryGroup($class) == "JUNIOR") {
                if ($trimmed == "50" || $trimmed == "55") {
                    $group = "50/55";
                } elseif ($trimmed == "76+" || $trimmed == "86+") {
                    $group = "76+/86+";
                } else {
                    $group = $trimmed;
                }
            } elseif ($this->getCategoryGroup($class) == "U21") {
                $group = $trimmed;
            } else {
                $group = $trimmed;
            }



        } elseif ($genderTrimmed == "F") {
            if ($this->getCategoryGroup($class) == "ESO") {
                if ($trimmed == "35" || $trimmed == "42") {
                    $group = "35/42";
                } elseif ($trimmed == "45" || $trimmed == "47") {
                    $group = "45/47";
                } elseif ($trimmed == "50" || $trimmed == "52") {
                    $group = "50/52";
                } elseif ($trimmed == "53" || $trimmed == "55") {
                    $group = "53/55";
                } elseif ($trimmed == "56" || $trimmed == "62" || $trimmed == "68" || $trimmed == "68+" || $trimmed == "52+") {
                    $group = "56/68+";
                } else {
                    $group = $trimmed;
                }
            } elseif ($this->getCategoryGroup($class) == "CADET") {
                if ($trimmed == "42" || $trimmed == "47") {
                    $group = "42/47";
                } elseif ($trimmed == "61" || $trimmed == "61+" || $trimmed == "68+" || $trimmed == "68") {
                    $group = "61+/68+";
                } else {
                    $group = $trimmed;
                }
            } elseif ($this->getCategoryGroup($class) == "JUNIOR") {
                if ($trimmed == "66+" || $trimmed == "74" || $trimmed == "74+") {
                    $group = "66+/74+";
                } else {
                    $group = $trimmed;
                }
            } elseif ($this->getCategoryGroup($class) == "U21") {
                $group = $trimmed;
            } else {
                $group = $trimmed;
            }
        } else {
            $group = $trimmed;
        }

        return $group;
    }

    public function arrayExistsInMultiArray($searchArray, $multiArray)
    {
        foreach ($multiArray as $subArray) {
            if (count(array_diff($searchArray, $subArray)) === 0) {
                return true;
            }
        }
        return false;
    }

    public function getPageUrl($url)
    {
        $pageUrlSplit = explode("/", $url);
        unset($pageUrlSplit[count($pageUrlSplit) - 1]);
        unset($pageUrlSplit[0]);
        unset($pageUrlSplit[1]);
        $pageUrl = implode("/", $pageUrlSplit);
        return $pageUrl;
    }

    public function scrapeData(Request $request)
    {
        $request->validate([
            'url' => 'required',
        ]);
        $tourId = $request->type;
        $t_name = $request->name;
        $t_id = $request->t_id;
        $fattore = $request->fattore;
        $tournamet_name = Tournament::find($tourId);
        $pageUrl = $this->getPageUrl($request->url);
        $client = new Client();
        $results_link = "";
        $explodedUrl = explode("#", $request->url);
        if (!strpos($explodedUrl[0], '&ver_info_action=catauslist')) {
            $explodedUrl[0] .= '&ver_info_action=catauslist';
        }
        $pageLink = implode("#", $explodedUrl);
        $crawler = $client->request('GET', $pageLink);
        $title = $crawler->filter('.newsheader_eventhead')->first()->text();
        preg_match('/\b\d{4}\b/', $title, $matches);
        $year = $matches[0];
        $menu_node = $crawler->filter('.menu_event')->first();
        $menu_links = $menu_node->filter('li');
        $secondLastLink = $menu_links->eq($menu_links->count() - 2);
        $link = $secondLastLink->filter('a')->first();
        if ($link && $link->count() > 0) {
            $href = $link->attr('href');
            if (strpos($href, 'popup_action=results')) {
                $results_link = $href;
            }
        }
        if ($results_link) {
            $result_url = $pageUrl . "/$results_link";
            $checkResult = Result::where('link', $result_url)->orWhere('title', $title)->first();
            if (!$checkResult) {
                $result = new Result();
                $result->title = $title;
                $result->link = $result_url;
                $result->tournament_id = $t_id;
                $result->tournament_name = $t_name;
                $result->tournament_type = $request->type;
                $result->save();
                $this->scrapeResults($result->id, $tourId, $year, $t_name, $fattore, $t_id);
            } else {
                return response()->json(["message" => "($title) already exists"], 422);
            }
        }

        $hasDrawsHeader = $crawler->filter('.general_inner.table-responsive table.moduletable tr.dctabheader th')->first();
        if ($hasDrawsHeader->count() > 0 && $hasDrawsHeader->text() == "Draws") {
            $draws_links = [];
            $url = $request->url;
            $links = $crawler->filter('.general_inner.table-responsive table.moduletable tr.dctabrowwhite, .general_inner.table-responsive table.moduletable tr.dctabrowgreen')->each(function ($row) use (&$draws_links, $pageUrl, $url) {
                $link = $row->filter('td a')->first();
                $href = $link->attr('href');
                $title = $link->attr('title');
                if (strpos($title, 'KUMITE') !== false || strpos($title, 'Kumite') !== false) {
                    // if(count($draws_links) < 1){ // Remove This Condition When Deploy The System
                    array_push($draws_links, [
                        'href' => $pageUrl . "/$href",
                        'title' => $title,
                    ]);
                    // }
                }
            });
            foreach ($draws_links as $drawlink) {
                $dlink = new DrawLink();
                $dlink->title = $drawlink['title'];
                $dlink->link = $drawlink['href'];
                $dlink->url = $url;
                $dlink->tourId = $tourId;
                $dlink->year = $year;
                $dlink->t_name = $t_name;
                $dlink->fattore = $fattore;
                $dlink->t_id = $t_id;
                $dlink->save();
            }
            $all_links = DrawLink::where('t_id', $t_id)->get();
            // $this->scrapeDraws($draws_links, $url, $tourId, $year, $t_name, $fattore, $t_id);
            // $this->createAthleteRankings($t_id, $tourId);
            return response()->json(["message" => "Date Scraped Successfully", "links" => $all_links], 200);
        } else {
            return response()->json(["message" => "No draws found"], 422);
        }
    }

    public function scrapeDraw(Request $request)
    {
        $draw_link = $request->link;
        $tourId = $request->tourId;
        $year = $request->year;
        $t_name = $request->t_name;
        $fattore = $request->fattore;
        $t_id = $request->t_id;
        $scraped_draws = [];
        $players_count = 0;
        $client = new Client();
        // $draw_link = $draw['href'];
        $crawler = $client->request("GET", "https://$draw_link");
        $mainModule = $crawler->filter('#center_outer_middle_popup_draw');
        $mainIndex = 0;
        $isCounted = false;
        $pool_title = "";
        $mainModule->filter('table.moduletable')->each(function ($table) use ($tourId, &$scraped_draws, &$players_count, &$isCounted, &$pool_title) {
            $rows = $table->filter('tr');
            if ($rows->count() == 1) {
                $pool_title = $rows->text();
                $checkContainer = $table->nextAll('.container')->first();
                if ($checkContainer->count() > 0) {
                    $poolsContainer = $table->nextAll('.container .tournament-bracket-16.tournament-bracket--rounded')->first();
                    $pool_rounds = $poolsContainer->filter('.tournament-bracket__round');
                    $allPools = [];
                    $poolIndex = 0;
                    $lastPlayer = [];
                    $pool_rounds->each(function ($pool_round) use ($tourId, &$scraped_draws, &$players_count, &$allPools, &$poolIndex, &$lastPlayer, $pool_title) {
                        $title = $pool_round->filter('.tournament-bracket__round-title')->first();
                        $currentPoolMatches = [];
                        if ($title->count() > 0) {
                            $matches_list = $pool_round->filter('ul.tournament-bracket__list li.tournament-bracket__item');
                            $match_data = [];
                            $index = 1;
                            $matches_list->each(function ($single_match) use (&$index, &$match_data, $tourId, &$scraped_draws, &$players_count, &$currentPoolMatches, &$lastPlayer, $pool_title) {
                                $playerName = $single_match->filter('.tournament-bracket__match .tournament-bracket__table .tournament-bracket__caption .tournament-bracket__table .tournament-bracket__caption_info')->first();
                                if ($playerName->count() > 0 && $playerName->text()) {
                                    $playerInfo = $playerName->filter('.tournament-bracket__caption_info2')->first();
                                    $player_name = $playerName->text();
                                    $player_name = str_replace($playerInfo->text(), "", $player_name);
                                    $player_info = explode(",", $playerInfo->text());
                                    $info = $player_info[0];
                                    $country = $player_info[1];
                                    $scoreCard = $single_match->filter('.tournament-bracket__match .tournament-bracket__table .tournament-bracket__content .tournament-bracket__team')->first();
                                    $scores = $scoreCard->filter('.tournament-bracket__score')->first();
                                    $score = $scores->text();
                                    if (!$score) {
                                        $score = 0;
                                    }
                                    $flag = $scoreCard->filter('.tournament-bracket__country .tournament-bracket__flag img')->attr('src');
                                    $single_player = [
                                        "player_name" => $player_name,
                                        "score" => $score,
                                        "info" => $info,
                                        "country" => $country,
                                        "title" => $pool_title,
                                    ];
                                    $players_count += 1;
                                    array_push($match_data, $single_player);
                                    $lastPlayer = $single_player;
                                    if ($index % 2 == 0) {
                                        array_push($currentPoolMatches, [$match_data[0], $match_data[1]]);
                                        $match_data = [];
                                    }
                                    $index++;
                                }
                            });
                        }
                        $allPools[$poolIndex] = $currentPoolMatches;
                        $poolIndex++;
                    });
                    $allPools = $this->addIsWinnerIndex($allPools, $lastPlayer);
                    $scraped_draws = $this->poolsToScraped($scraped_draws, $allPools);
                }
            }
        });
        // $repechageAll = $mainModule->filter('table.moduletable');
        // $repechageAll->each(function ($checkRepechage) use (&$pool_title) {
        //     $rows = $checkRepechage->filter('tr');
        //     if ($rows->count() == 1) {
        //         if ($this->isFound($rows->text(), "Repechage")) {
        //             $pool_title = $rows->text();
        //         }
        //     }
        // });


        // $repechagePools = $mainModule->filter('.general_inner')->slice(1);
        // Filter elements with class '.general_inner'
        $filteredElements = $mainModule->filter('.general_inner');
        // Slice the filtered elements starting from index 1
        $repechagePools = $filteredElements->slice(1);
        $repechagePools->each(function ($general) use (&$scraped_draws, &$players_count, $pool_title) {
            $drawTableRows = $general->filter('.moduletable_draw tr');
            $match_data = [];
            $combination = [
                [0, 2],
                [1, 4],
                [3, 6],
                [5, 8],
                [7, 10],
            ];
            $remainings = [
                "3" => 1,
                "5" => 3,
                "7" => 5,
                "9" => 7,
                "11" => 9,
            ];
            $index = 0;
            $roundId = 0;
            $drawTableRows->each(function ($row) use (&$index, &$match_data, $pool_title) {
                $columns = $row->filter('td');
                if ($columns->count() > 8) {

                    $columns->each(function ($single_match) use (&$index, &$match_data, $pool_title) {
                        $check_match = $single_match->filter('.tournament-bracket__round .tournament-bracket__match');
                        if ($check_match->count() > 0) {
                            $playerName = $single_match->filter('.tournament-bracket__round .tournament-bracket__match .tournament-bracket__table .tournament-bracket__caption .tournament-bracket__table .tournament-bracket__caption_info')->first();
                            if ($playerName->count() > 0 && $playerName->text()) {
                                $playerInfo = $playerName->filter('.tournament-bracket__caption_info2')->first();
                                $player_name = $playerName->text();
                                $player_name = str_replace($playerInfo->text(), "", $player_name);
                                $player_info = explode(",", $playerInfo->text());
                                $info = $player_info[0];
                                $country = $player_info[1];
                                $scoreCard = $single_match->filter('.tournament-bracket__match .tournament-bracket__table .tournament-bracket__content .tournament-bracket__team')->first();
                                $scores = $scoreCard->filter('.tournament-bracket__score')->first();
                                $score = $scores->text();
                                if (!$score) {
                                    $score = 0;
                                }
                                $flag = $scoreCard->filter('.tournament-bracket__country .tournament-bracket__flag img')->attr('src');
                                $single_player = [
                                    "player_name" => $player_name,
                                    "score" => $score,
                                    "info" => $info,
                                    "country" => $country,
                                    "title" => $pool_title,
                                ];
                                array_push($match_data, $single_player);
                            }
                        }
                    });
                }
            });

            $allPools = [];
            $added = [];

            foreach ($combination as $combo) {
                if (isset ($match_data[$combo[0]]) && isset ($match_data[$combo[1]])) {
                    $checkArray = [
                        $match_data[$combo[0]],
                        $match_data[$combo[1]],
                    ];
                    if (!$this->subArrayExists($checkArray, $added)) {
                        array_push($added, $checkArray);
                        $allPools[$index][0] = $checkArray;
                        $index++;
                    }
                }
            }
            if (isset ($remainings[count($match_data)])) {
                $lastPlayer = $match_data[$remainings[count($match_data)]];
                $allPools = $this->addIsWinnerIndex1($allPools, $lastPlayer);
                $players_count += count($match_data);
                $scraped_draws = $this->poolsToScraped($scraped_draws, $allPools);
            }

        });
        // return ["t_id" => $t_id, "tourId" => $tourId, "msg" => $scraped_draws];
        foreach ($scraped_draws as $draw) {
            $this->createMatch($draw[0], $draw[1], $tourId, $players_count, $year, $t_name, $fattore, $t_id);
        }
        return ["t_id" => $t_id, "tourId" => $tourId, "msg" => $scraped_draws];
    }

    public function scrapeDraws($draws_links, $url, $tourId, $year, $t_name, $fattore, $t_id)
    {
        $draws = $draws_links;
        foreach ($draws as $draw) {
            $scraped_draws = [];
            $players_count = 0;
            $client = new Client();
            $draw_link = $draw['href'];
            $crawler = $client->request("GET", "https://$draw_link");
            $mainModule = $crawler->filter('#center_outer_middle_popup_draw');
            $mainIndex = 0;
            $isCounted = false;
            $pool_title = "";
            $mainModule->filter('table.moduletable')->each(function ($table) use ($tourId, &$scraped_draws, &$players_count, &$isCounted, &$pool_title) {
                $rows = $table->filter('tr');
                if ($rows->count() == 1) {
                    $pool_title = $rows->text();
                    $checkContainer = $table->nextAll('.container')->first();
                    if ($checkContainer->count() > 0) {
                        $poolsContainer = $table->nextAll('.container .tournament-bracket-16.tournament-bracket--rounded')->first();
                        $pool_rounds = $poolsContainer->filter('.tournament-bracket__round');
                        $allPools = [];
                        $poolIndex = 0;
                        $lastPlayer = [];
                        $pool_rounds->each(function ($pool_round) use ($tourId, &$scraped_draws, &$players_count, &$allPools, &$poolIndex, &$lastPlayer, $pool_title) {
                            $title = $pool_round->filter('.tournament-bracket__round-title')->first();
                            $currentPoolMatches = [];
                            if ($title->count() > 0) {
                                $matches_list = $pool_round->filter('ul.tournament-bracket__list li.tournament-bracket__item');
                                $match_data = [];
                                $index = 1;
                                $matches_list->each(function ($single_match) use (&$index, &$match_data, $tourId, &$scraped_draws, &$players_count, &$currentPoolMatches, &$lastPlayer, $pool_title) {
                                    $playerName = $single_match->filter('.tournament-bracket__match .tournament-bracket__table .tournament-bracket__caption .tournament-bracket__table .tournament-bracket__caption_info')->first();
                                    if ($playerName->count() > 0 && $playerName->text()) {
                                        $playerInfo = $playerName->filter('.tournament-bracket__caption_info2')->first();
                                        $player_name = $playerName->text();
                                        $player_name = str_replace($playerInfo->text(), "", $player_name);
                                        $player_info = explode(",", $playerInfo->text());
                                        $info = $player_info[0];
                                        $country = $player_info[1];
                                        $scoreCard = $single_match->filter('.tournament-bracket__match .tournament-bracket__table .tournament-bracket__content .tournament-bracket__team')->first();
                                        $scores = $scoreCard->filter('.tournament-bracket__score')->first();
                                        $score = $scores->text();
                                        if (!$score) {
                                            $score = 0;
                                        }
                                        $flag = $scoreCard->filter('.tournament-bracket__country .tournament-bracket__flag img')->attr('src');
                                        $single_player = [
                                            "player_name" => $player_name,
                                            "score" => $score,
                                            "info" => $info,
                                            "country" => $country,
                                            "title" => $pool_title,
                                        ];
                                        $players_count += 1;
                                        array_push($match_data, $single_player);
                                        $lastPlayer = $single_player;
                                        if ($index % 2 == 0) {
                                            array_push($currentPoolMatches, [$match_data[0], $match_data[1]]);
                                            $match_data = [];
                                        }
                                        $index++;
                                    }
                                });
                            }
                            $allPools[$poolIndex] = $currentPoolMatches;
                            $poolIndex++;
                        });
                        $allPools = $this->addIsWinnerIndex($allPools, $lastPlayer);
                        $scraped_draws = $this->poolsToScraped($scraped_draws, $allPools);
                    }
                }
            });
            $repechageAll = $mainModule->filter('table.moduletable');
            $repechageAll->each(function ($checkRepechage) use (&$pool_title) {
                $rows = $checkRepechage->filter('tr');
                if ($rows->count() == 1) {
                    if ($this->isFound($rows->text(), "Repechage")) {
                        $pool_title = $rows->text();
                    }
                }
            });
            $repechagePools = $mainModule->filter('.general_inner')->slice(1);
            $repechagePools->each(function ($general) use (&$scraped_draws, &$players_count, $pool_title) {
                $drawTableRows = $general->filter('.moduletable_draw tr');
                $match_data = [];
                $combination = [
                    [0, 2],
                    [1, 4],
                    [3, 6],
                    [5, 8],
                    [7, 10],
                ];
                $remainings = [
                    "3" => 1,
                    "5" => 3,
                    "7" => 5,
                    "9" => 7,
                    "11" => 9,
                ];
                $index = 0;
                $roundId = 0;
                $drawTableRows->each(function ($row) use (&$index, &$match_data, $pool_title) {
                    $columns = $row->filter('td');
                    if ($columns->count() > 8) {
                        $columns->each(function ($single_match) use (&$index, &$match_data, $pool_title) {
                            $check_match = $single_match->filter('.tournament-bracket__round .tournament-bracket__match');
                            if ($check_match->count() > 0) {
                                $playerName = $single_match->filter('.tournament-bracket__round .tournament-bracket__match .tournament-bracket__table .tournament-bracket__caption .tournament-bracket__table .tournament-bracket__caption_info')->first();
                                if ($playerName->count() > 0 && $playerName->text()) {
                                    $playerInfo = $playerName->filter('.tournament-bracket__caption_info2')->first();
                                    $player_name = $playerName->text();
                                    $player_name = str_replace($playerInfo->text(), "", $player_name);
                                    $player_info = explode(",", $playerInfo->text());
                                    $info = $player_info[0];
                                    $country = $player_info[1];
                                    $scoreCard = $single_match->filter('.tournament-bracket__match .tournament-bracket__table .tournament-bracket__content .tournament-bracket__team')->first();
                                    $scores = $scoreCard->filter('.tournament-bracket__score')->first();
                                    $score = $scores->text();
                                    if (!$score) {
                                        $score = 0;
                                    }
                                    $flag = $scoreCard->filter('.tournament-bracket__country .tournament-bracket__flag img')->attr('src');
                                    $single_player = [
                                        "player_name" => $player_name,
                                        "score" => $score,
                                        "info" => $info,
                                        "country" => $country,
                                        "title" => $pool_title,
                                    ];
                                    array_push($match_data, $single_player);
                                }
                            }
                        });
                    }
                });
                $allPools = [];
                $added = [];
                $index = 0;
                foreach ($combination as $combo) {
                    if (isset ($match_data[$combo[0]]) && isset ($match_data[$combo[1]])) {
                        $checkArray = [
                            $match_data[$combo[0]],
                            $match_data[$combo[1]],
                        ];
                        if (!$this->subArrayExists($checkArray, $added)) {
                            array_push($added, $checkArray);
                            $allPools[$index][0] = $checkArray;
                            $index++;
                        }
                    }
                }
                if (isset ($remainings[count($match_data)])) {
                    $lastPlayer = $match_data[$remainings[count($match_data)]];
                    $allPools = $this->addIsWinnerIndexRe($allPools, $lastPlayer);
                    $players_count += count($match_data);
                    $scraped_draws = $this->poolsToScraped($scraped_draws, $allPools);
                }
            });

            foreach ($scraped_draws as $draw) {
                $this->createMatch($draw[0], $draw[1], $tourId, $players_count, $year, $t_name, $fattore, $t_id);
            }
        }
    }

    public function isFound($string, $search)
    {
        if (strpos($string, $search) !== false) {
            return true;
        } else {
            return false;
        }
    }

    public function subArrayExists($searchArray, $multiArray)
    {
        foreach ($multiArray as $array) {
            if (is_array($array) && count($searchArray) === count($array) && $this->multidimensionalArrayCompare($searchArray, $array)) {
                return true;
            }
        }
        return false;
    }

    public function multidimensionalArrayCompare($array1, $array2)
    {
        ksort($array1);
        ksort($array2);
        return $array1 === $array2;
    }

    public function explodedTitle($title)
    {
        // Possible class values
        $possibleClasses = ["ESORDIENTI", "U14", "CADETTI", "CADETTE", "CADET", "Cadet", "Cadets", "Junior", "JUNIORES", "JUNIOR", "U21", "Master", "master", "Senior", "SENIOR"];

        // Initialize default values
        $class = "";
        $gender = "";
        $weight = "";

        // Normalize title
        $title = strtoupper($title);

        // Extract class
        foreach ($possibleClasses as $possibleClass) {
            if (strpos($title, strtoupper($possibleClass)) !== false) {
                $class = $possibleClass;
                break;
            }
        }

        // Extract gender
        if (strpos($title, ' F ') !== false || strpos($title, ' FEMALE') !== false) {
            $gender = 'F';
        } elseif (strpos($title, ' M ') !== false || strpos($title, ' MALE') !== false) {
            $gender = 'M';
        }

        // Extract weight
        if (preg_match('/\-\d+/', $title, $matches)) { // Prioritize this pattern
            $weight = ltrim($matches[0], '-');
        } elseif (preg_match('/\d+\-\d+/', $title, $matches)) {
            $weight = explode('-', $matches[0])[1];
        } elseif (preg_match('/\+\d+/', $title, $matches)) { // Check for '+' before the number
            $weight = ltrim($matches[0], '+') . '+'; // Remove '+' from the beginning and append it to the end
        } elseif (preg_match('/\d+\+/', $title, $matches)) { // Check for '+' after the number
            $weight = $matches[0]; // Keep the weight as it is, as '+' is already at the end
        } elseif (preg_match('/\d+/', $title, $matches)) {
            $weight = $matches[0];
        }




        return [
            "class" => $class,
            "gender" => $gender,
            "weight" => $weight,
        ];
    }



    public function createMatch($player1, $player2, $tour_id, $total_players, $year, $t_name, $fattore, $t_id)
    {
        $pool_title = $player1['title'];
        if ($pool_title) {

            $difference1 = $player1['score'] - $player2['score'];
            $difference2 = $player2['score'] - $player1['score'];
            $player1_result = ResultMatch::where('name', $player1['player_name'])->first();
            $player1_club = "";

            if ($player1_result) {
                $player1_club = $player1_result->club;
            }

            $player2_result = ResultMatch::where('name', $player2['player_name'])->first();
            $player2_club = "";

            if ($player2_result) {
                $player2_club = $player2_result->club;
            }

            $tournament = Tournament::find($tour_id);
            $pool = $this->explodedTitle($pool_title);
            $match = new TournamentMatch();
            $match->tournament_id = $tour_id;
            $match->tournament_name = $tournament->tournament_name;
            $match->t_id = $t_id;
            $match->t_name = $t_name;
            $match->fattore = $fattore ? $fattore : 0;
            $match->year = $year;
            $match->title = $pool_title;
            $match->class = $pool['class'];
            $match->weight = $pool['weight'];
            $match->male_female = $pool['gender'];
            $match->total_players = $total_players;
            $match->player1_name = $player1['player_name'];
            $match->player1_club = $player1_club;
            $match->player1_score = $player1['score'];
            $match->player1_is_win = $player1['is_winner'];
            $match->player1_is_free_win = $player1['is_free_win'] ?? 0;
            $match->player1_points_diff = $difference1;
            $match->player1_country = $player1['country'];
            $match->player2_name = $player2['player_name'];
            $match->player2_club = $player2_club;
            $match->player2_score = $player2['score'];
            $match->player2_is_win = $player2['is_winner'];
            $match->player2_is_free_win = $player2['is_free_win'] ?? 0;
            $match->player2_points_diff = $difference2;
            $match->player2_country = $player2['country'];
            $match->category_group = $this->getCategoryGroup($pool['class']);
            $match->weight_group = $this->getWeightCategory($pool['weight'], $pool['gender'], $pool['class']);
            $match->save();
            $this->addNewPlayer($player1['player_name'], $t_id, $tour_id);
            $this->addNewPlayer($player2['player_name'], $t_id, $tour_id);
        }
    }

    public function addNewPlayer($player_name, $t_id, $tournament_id)
    {
        $checkPlayer = Player::where('t_id', $t_id)->where('tournament_id', $tournament_id)->where('player_name', $player_name)->first();
        if (!$checkPlayer) {
            $player = new Player();
            $player->tournament_id = $tournament_id;
            $player->t_id = $t_id;
            $player->player_name = $player_name;
            $player->save();
        }
    }

    public function deleteRecord($record_url)
    {
        $record = Record::where('link', $record_url)->first();
        if ($record && count($record->draws) > 0) {
            $record->draws()->each(function ($draw) {
                $pools = $draw->pools;
                if (count($pools) > 0) {
                    $pools->each(function ($pool) {
                        $pool->pool_rounds()->each(function ($pool_round) {
                            $pool_round->pool_round_matches()->delete();
                            $pool_round->pool_round_records()->delete();
                            $pool_round->delete();
                        });
                        $pool->delete();
                    });
                }
                $draw->delete();
            });
            $record->delete();
        }
    }

    public function getRecord($record_id)
    {
        $record = Record::with('draws.pools.pool_rounds.pool_round_matches.player1_info', 'draws.pools.pool_rounds.pool_round_matches.player2_info')->find($record_id);
        return $record;
    }

    public function scrapeResults($result_id, $tour_id, $year, $t_name, $fattore, $t_id)
    {
        $result = Result::find($result_id);
        $tournament = Tournament::find($tour_id);
        $client = new Client();
        $crawler = $client->request("GET", "https://$result->link");
        $results_table = $crawler->filter('.general_inner.table-responsive')->first();
        $table_rows = $results_table->filter('tr');
        $last_tournamet_id = 0;
        $table_rows->each(function ($tr) use ($result_id, $tournament, $year, $t_name, $fattore, $t_id) {
            $checkCols = $tr->filter('th');
            if (!($checkCols->count() > 0)) {
                $title = $tr->filter('td')->eq(0)->text();
                if ($title) {
                    if (strpos($title, 'KUMITE') !== false || strpos($title, 'Kumite') !== false) {
                        // dd($tr->html());
                        if ($tournament->tournament_name == "Nazionali" || $tournament->tournament_name == "Regionali") {
                            $pool = $this->explodedTitle($title);
                            $match = new ResultMatch();
                            $match->tournament_id = $tournament->id;
                            $match->tournament_name = $tournament->tournament_name;
                            $match->t_id = $t_id;
                            $match->t_name = $t_name;
                            $match->fattore = $fattore ?? '';
                            $match->year = $year;
                            $match->title = $title;
                            $match->class = $pool['class'];
                            $match->male_female = $pool['gender'];
                            $match->weight = $pool['weight'];
                            $match->rank = $tr->filter('td')->eq(1)->text();
                            $match->name = $tr->filter('td')->eq(2)->text();
                            $match->club = $tr->filter('td')->eq(4)->text();
                            $match->matchId = $tr->filter('td')->eq(5)->text();
                            $match->pti = $tr->filter('td')->eq(6)->text();
                            $match->category_group = $this->getCategoryGroup($pool['class']);
                            $match->weight_group = $this->getWeightCategory($pool['weight'], $pool['gender'], $pool['class']);
                            $match->save();
                        } else {
                            $pool = $this->explodedTitle($title);
                            $match = new ResultMatch();
                            $match->tournament_id = $tournament->id;
                            $match->tournament_name = $tournament->tournament_name;
                            $match->t_id = $t_id;
                            $match->t_name = $t_name;
                            $match->fattore = $fattore ?? '';
                            $match->year = $year;
                            $match->class = $pool['class'];
                            $match->male_female = $pool['gender'];
                            $match->weight = $pool['weight'];
                            $match->rank = $tr->filter('td')->eq(1)->text();
                            $match->name = $tr->filter('td')->eq(2)->text();
                            $match->club = $tr->filter('td')->eq(4)->text();
                            $match->matchId = "";
                            $match->pti = "";
                            $match->category_group = $this->getCategoryGroup($pool['class']);
                            $match->weight_group = $this->getWeightCategory($pool['weight'], $pool['gender'], $pool['class']);
                            $match->save();
                        }
                    }
                }
            }
        });
        // dd("Exit");
    }

    function addIsWinnerIndexRe($allPools, $lastPlayer)
    {
        $totalRounds = count($allPools);
        for ($roundIndex = 0; $roundIndex < $totalRounds; $roundIndex++) {
            $currentRound = $allPools[$roundIndex];
            if ($roundIndex == $totalRounds - 1) {
                foreach ($currentRound[0] as $playerIndex => $player) {
                    if ($player['player_name'] == $lastPlayer['player_name']) {
                        $allPools[$roundIndex][0][$playerIndex]['is_winner'] = 1;
                    } else {
                        $allPools[$roundIndex][0][$playerIndex]['is_winner'] = 0;
                    }
                }
            } else {
                if ($roundIndex < $totalRounds - 1) {
                    $nextRound = $allPools[$roundIndex + 1];

                    foreach ($currentRound as $matchIndex => $match) {
                        foreach ($match as $playerIndex => $player) {
                            $playerExistsInNextRound = false;

                            foreach ($nextRound as $nextMatch) {
                                foreach ($nextMatch as $nextPlayer) {
                                    if ($player['player_name'] == $nextPlayer['player_name']) {
                                        $playerExistsInNextRound = true;
                                        break;
                                    }
                                }
                                if ($playerExistsInNextRound) {
                                    break;
                                }
                            }

                            $allPools[$roundIndex][$matchIndex][$playerIndex]['is_winner'] = $playerExistsInNextRound ? 1 : 0;
                        }
                    }
                } else {
                    foreach ($currentRound as $matchIndex => $match) {
                        foreach ($match as $playerIndex => $player) {
                            $allPools[$roundIndex][$matchIndex][$playerIndex]['is_winner'] = 1;
                        }
                    }
                }
            }
        }

        return $allPools;
    }

    function addIsWinnerIndex1($allPools, $lastPlayer)
    {
        $totalRounds = count($allPools);
        for ($roundIndex = 0; $roundIndex < $totalRounds; $roundIndex++) {
            $currentRound = $allPools[$roundIndex];
            // if (count($currentRound) == 1) {
            //     foreach ($currentRound[0] as $playerIndex => $player) {
            //         if ($player['player_name'] == $lastPlayer['player_name']) {
            //             $allPools[$roundIndex][0][$playerIndex]['is_winner'] = 1;
            //             $allPools[$roundIndex][0][$playerIndex]['is_free_win'] = 0;
            //         } else {
            //             $allPools[$roundIndex][0][$playerIndex]['is_winner'] = 0;
            //             $allPools[$roundIndex][0][$playerIndex]['is_free_win'] = 0;
            //         }
            //     }
            // }
            if(($roundIndex + 1) < $totalRounds) {
                $nextRound = $allPools[$roundIndex + 1];
                foreach ($currentRound as $matchIndex => $match) {
                    foreach ($match as $playerIndex => $player) {
                        $playerExistsInNextRound = false;

                        foreach ($nextRound as $nextMatch) {
                            foreach ($nextMatch as $nextPlayer) {
                                if ($player['player_name'] == $nextPlayer['player_name']) {
                                    $playerExistsInNextRound = true;
                                    break;
                                }
                            }
                            if ($playerExistsInNextRound) {
                                break;
                            }
                        }

                        $allPools[$roundIndex][$matchIndex][$playerIndex]['is_winner'] = $playerExistsInNextRound ? 1 : 0;
                        $allPools[$roundIndex][$matchIndex][$playerIndex]['is_free_win'] = 0;
                    }
                }

            }else{
                foreach ($currentRound[0] as $playerIndex => $player) {
                    if ($player['player_name'] == $lastPlayer['player_name']) {
                        $allPools[$roundIndex][0][$playerIndex]['is_winner'] = 1;
                        $allPools[$roundIndex][0][$playerIndex]['is_free_win'] = 0;
                    } else {
                        $allPools[$roundIndex][0][$playerIndex]['is_winner'] = 0;
                        $allPools[$roundIndex][0][$playerIndex]['is_free_win'] = 0;
                    }
                }
            }
        }

        return $allPools;
    }
    function
    addIsWinnerIndex($allPools, $lastPlayer)
    {
        $totalRounds = count($allPools);
        for ($roundIndex = 0; $roundIndex < $totalRounds; $roundIndex++) {
            $currentRound = $allPools[$roundIndex];
            if (count($currentRound) == 1) {
                foreach ($currentRound[0] as $playerIndex => $player) {
                    if ($player['player_name'] == $lastPlayer['player_name']) {
                        $allPools[$roundIndex][0][$playerIndex]['is_winner'] = 1;
                        $allPools[$roundIndex][0][$playerIndex]['is_free_win'] = 0;
                    } else {
                        $allPools[$roundIndex][0][$playerIndex]['is_winner'] = 0;
                        $allPools[$roundIndex][0][$playerIndex]['is_free_win'] = 0;
                    }
                }
            } else {
                if ($roundIndex < $totalRounds - 1) {
                    $nextRound = $allPools[$roundIndex + 1];

                    foreach ($currentRound as $matchIndex => $match) {
                        foreach ($match as $playerIndex => $player) {
                            $playerExistsInNextRound = false;

                            foreach ($nextRound as $nextMatch) {
                                foreach ($nextMatch as $nextPlayer) {
                                    if ($player['player_name'] == $nextPlayer['player_name']) {
                                        $playerExistsInNextRound = true;
                                        break;
                                    }
                                }
                                if ($playerExistsInNextRound) {
                                    break;
                                }
                            }

                            $allPools[$roundIndex][$matchIndex][$playerIndex]['is_winner'] = $playerExistsInNextRound ? 1 : 0;
                            // $allPools[$roundIndex][$matchIndex][$playerIndex]['is_free_win'] = 0;
                        }
                    }
                    foreach ($nextRound as $matchIndex => $match) {
                        foreach ($match as $playerIndex => $player) {
                            $playerExistsInCurrentRound = false;

                            foreach ($currentRound as $currentMatch) {
                                foreach ($currentMatch as $currentPlayer) {
                                    if ($player['player_name'] == $currentPlayer['player_name']) {
                                        $playerExistsInCurrentRound = true;
                                        break;
                                    }
                                }
                                if ($playerExistsInCurrentRound) {
                                    break;
                                }
                            }

                            $allPools[$roundIndex + 1][$matchIndex][$playerIndex]['is_free_win'] = $playerExistsInCurrentRound ? 0 : 1;
                        }
                    }
                } else {
                    foreach ($currentRound as $matchIndex => $match) {
                        foreach ($match as $playerIndex => $player) {
                            $allPools[$roundIndex][$matchIndex][$playerIndex]['is_winner'] = 1;
                            $allPools[$roundIndex][$matchIndex][$playerIndex]['is_free_win'] = 0;
                        }
                    }
                }
            }
        }

        return $allPools;
    }

    function poolsToScraped($scraped_draws, $allPools)
    {
        $all_draws = $scraped_draws;
        foreach ($allPools as $pool) {
            foreach ($pool as $match) {
                array_push($all_draws, $match);
            }
        }
        return $all_draws;
    }

    function custom_trim($string)
    {
        return preg_replace('/^\s+|\s+$/u', '', $string);
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

    public function pointsCalc($player_name, $t_id, $tournament_id)
    {
        $matches = TournamentMatch::where('t_id', $t_id)
            ->where('tournament_id', $tournament_id)
            ->where(function ($query) use ($player_name) {
                $query->where('player1_name', $player_name)->orWhere('player2_name', $player_name);
            })->get();

        $total_points_gained = 0;
        $total_points_suffered = 0;
        $matches_list = [];

        foreach ($matches as $match) {
            if ($match->player1_name == $player_name) {
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

    public function getTotalLosses($player_name, $t_id, $tournament_id)
    {
        $matches = TournamentMatch::where('t_id', $t_id)
            ->where('tournament_id', $tournament_id)
            ->where(function ($query) use ($player_name) {
                $query->where('player1_name', $player_name)->orWhere('player2_name', $player_name);
            })->get();
        $total_losses = 0;
        foreach ($matches as $match) {
            if ($match->player1_name == $player_name && $match->player1_is_win == 0) {
                $total_losses++;
            } elseif ($match->player2_name == $player_name && $match->player2_is_win == 0) {
                $total_losses++;
            }
        }

        return $total_losses;
    }

    public function rankPosto($rank, $tour_id, $ranking)
    {
        if ($ranking == 'official') {
            $official = OfficialRanking::where('tournament_id', $tour_id)->first();
        } else if ($ranking == 'ranking1') {
            $official = Ranking1::where('tournament_id', $tour_id)->first();
        } else if ($ranking == 'ranking2') {
            $official = Ranking2::where('tournament_id', $tour_id)->first();
        }
        $posto = 0;
        if ($rank == 1) {
            $posto = $official->posto_1;
        } else if ($rank == 2) {
            $posto = $official->posto_2;
        } else if ($rank == 3) {
            $posto = $official->posto_3;
        } else if ($rank == 5) {
            $posto = $official->posto_5;
        } else if ($rank == 7) {
            $posto = $official->posto_7;
        } else if ($rank == 9) {
            $posto = $official->posto_9;
        } else if ($rank == 11 || $rank == 15) {
            $posto = $official->posto_11;
        }

        return $posto;
    }

    public function calculateOfficialRanking($tournament_id, $t_id, $player_name, $rank, $ranking)
    {
        $tournament = Tournament::find($tournament_id);
        $tournament_match = TournamentMatch::where('t_id', $t_id)
                ->where('tournament_id', $tournament_id)
                ->where(function ($query) use ($player_name) {
                    $query->where('player1_name', $player_name)->orWhere('player2_name', $player_name);
                })->first();
        if ($ranking == 'official') {
            $official = OfficialRanking::where('tournament_id', $tournament_id)->first();
        } else if ($ranking == 'ranking1') {
            $official = Ranking1::where('tournament_id', $tournament_id)->first();
        } else if ($ranking == 'ranking2') {
            $official = Ranking2::where('tournament_id', $tournament_id)->first();
        }
        $a = $official->partecipazione;
        $b = $this->getTotalWins($player_name, $t_id, $tournament_id) * 10;
        $c = $this->rankPosto($rank, $tournament_id, $ranking);
        if ($tournament_id != 8 && $tournament_id != 11) {
            $f = $official->fattore;
        } else {
            $f = $tournament_match->fattore;
        }
        $cal_ranking = ($a + $b + $c) * $f;

        return $cal_ranking;
    }
    public function getPlayerCountry($player_name)
    {
        $tournament_match = TournamentMatch::where('player1_name', $player_name)
            ->orWhere('player2_name', $player_name)
            ->first();

        if ($tournament_match) {
            return ($tournament_match->player1_name == $player_name)
                ? $tournament_match->player1_country
                : $tournament_match->player2_country;
        }

        return 'Player country not found'; // Example default value
    }

    // public function getPlayerCountry($player_name){
    //     $tournament_match = TournamentMatch::where('player1_name', $player_name)->orWhere('player2_name', $player_name)->first();
    //     if($tournament_match){
    //         if($tournament_match->player1_name == $player_name){
    //             return $tournament_match->player1_country;
    //         }elseif($tournament_match->player2_name == $player_name){
    //             return $tournament_match->player2_country;
    //         }
    //     }
    // }
    public function allPlayers($t_id, $tournament_id)
    {
        $players = Player::where('t_id', $t_id)->where('tournament_id', $tournament_id)->get();
        return $players;
    }
    public function athletePlayerRankings($from, $to)
    {
        $players = Player::where('id', ">=", $from)->where('id', "<=", $to)->get();
        foreach ($players as $player) {
            $tournament_id = $player->tournament_id;
            $t_id = $player->t_id;
            $player_name = $player->player_name;
            $result_match = ResultMatch::where('t_id', $t_id)->where('tournament_id', $tournament_id)->where('name', $player_name)->first();
            $tournament_match = TournamentMatch::where('t_id', $t_id)
                ->where('tournament_id', $tournament_id)
                ->where(function ($query) use ($player_name) {
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
            if ($tournament_match->tournament_name == "Open" || $tournament_match->tournament_name == "Open Internazionali") {
                $athlete->fattore = $tournament_match->fattore;
            } else {
                $official = OfficialRanking::where('tournament_id', $tournament_match->tournament_id)->first();
                $athlete->fattore = $official->fattore;
            }

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



            $athlete->save();
            // if($player_name == "BOUSSAIRI FADWA"){
            //     return ["message" => $athlete];
            // }

        }

        // $athleteRanking = AthleteRanking::all();
        // return count($athleteRanking);
        return ["message" => "Data Scraped"];
    }

    public function createAthleteRankings($t_id, $tournament_id)
    {
        dispatch(new \App\Jobs\CreateAthleteRankingsJob($t_id, $tournament_id));
        $player_name = "NASSER DIEGO";
        $result_match = ResultMatch::where('t_id', $t_id)->where('tournament_id', $tournament_id)->where('name', $player_name)->first();
        $tournament_match = TournamentMatch::where('t_id', $t_id)
            ->where('tournament_id', $tournament_id)
            ->where(function ($query) use ($player_name) {
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
        // return $athlete;
        if ($tournament_match->tournament_name == "Open" || $tournament_match->tournament_name == "Open Internazionali") {
            $athlete->fattore = $tournament_match->fattore;
        } else {
            $official = OfficialRanking::where('tournament_id', $tournament_match->tournament_id)->first();
            $athlete->fattore = $official->fattore;
        }
        $athlete->save();

        return ["message" => "Data is scraped successfully"];
    }

    public function allAtheleteRankings()
    {
        dd("Something");
        // $rankings = AthleteRanking::all();
        // return $rankings;
    }
}
