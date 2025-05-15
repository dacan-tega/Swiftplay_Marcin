<?php

namespace Slotgen\SlotgenBonusJoker\Http\Controllers\Site;

use File;
use Illuminate\Http\Request;
use Nhutcorp\SlotgenRtpcore\Repositories\Api\RtpcoreGameRepository;
use Slotgen\SlotgenBonusJoker\Http\Controllers\AppBaseController;
use Slotgen\SlotgenBonusJoker\SlotgenBonusJoker;

class GameController extends AppBaseController
{
    /** @var RtpcoreGameRepository */
    private $gameRepository;

    private $authTokenName;

    private $gameLocation;

    // public static function launchGame(Request $req)
    public static function launchGame()
    {
        $AppBaseController = new AppBaseController();
        $gameFile = null;
        $gamePrivateFolder = storage_path('app/private/bonus_joker');
        if (!File::exists($gamePrivateFolder)) {
            return $AppBaseController->sendError('error', 'Invalid Launch Game');
        }
        $player = auth()->user();
        $playerUsername = isset($player->user_name) ? $player->user_name : 'Guest Player';
        $launchData = SlotgenBonusJoker::checkPlayer($player);
        $launchGameRes = SlotgenBonusJoker::LaunchGame($launchData);
        if ($launchGameRes['success']) {
            $resData = SlotgenBonusJoker::LaunchGameRes($launchGameRes);
            if ($resData['success']) {
                return $AppBaseController->sendResponse($resData['data'], 'Launch game success');
            } else {
                return $AppBaseController->sendError('error', 'Can Not Launch Game');
            }
        } else {
            return $AppBaseController->sendError('error', 'Invalid Launch Game');
        }
    }

    public static function launchGameApi($user)
    {
        $AppBaseController = new AppBaseController();
        $gameFile = null;
        $gamePrivateFolder = storage_path('app/private/bonus_joker');
        if (!File::exists($gamePrivateFolder)) {
            return $AppBaseController->sendError('error', 'Invalid Launch Game');
        }
        $player = $user;
        $playerUsername = isset($player->user_name) ? $player->user_name : 'Guest Player';
        $launchData = SlotgenBonusJoker::checkPlayer($player);
        $launchGameRes = SlotgenBonusJoker::LaunchGameApi($launchData);
        if ($launchGameRes['success']) {
            $resData = SlotgenBonusJoker::LaunchGameRes($launchGameRes);
            if ($resData['success']) {
                return $AppBaseController->sendResponse($resData['data'], 'Launch game success');
            } else {
                return $AppBaseController->sendError('error', 'Can Not Launch Game');
            }
        } else {
            return $AppBaseController->sendError('error', 'Invalid Launch Game');
        }
    }
}
