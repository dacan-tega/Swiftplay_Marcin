<?php

namespace Slotgen\SlotgenLucky81\Http\Controllers\Site;

use File;
use Illuminate\Http\Request;
use Nhutcorp\SlotgenRtpcore\Repositories\Api\RtpcoreGameRepository;
use Slotgen\SlotgenLucky81\Http\Controllers\AppBaseController;
use Slotgen\SlotgenLucky81\SlotgenLucky81;

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
        $gamePrivateFolder = storage_path('app/private/lucky_81');
        if (!File::exists($gamePrivateFolder)) {
            return $AppBaseController->sendError('error', 'Invalid Launch Game');
        }
        $player = auth()->user();
        $playerUsername = isset($player->user_name) ? $player->user_name : 'Guest Player';
        $launchData = SlotgenLucky81::checkPlayer($player);
        $launchGameRes = SlotgenLucky81::LaunchGame($launchData);
        if ($launchGameRes['success']) {
            $resData = SlotgenLucky81::LaunchGameRes($launchGameRes);
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
        $gamePrivateFolder = storage_path('app/private/lucky_81');
        if (!File::exists($gamePrivateFolder)) {
            return $AppBaseController->sendError('error', 'Invalid Launch Game');
        }
        $player = $user;
        $playerUsername = isset($player->user_name) ? $player->user_name : 'Guest Player';
        $launchData = SlotgenLucky81::checkPlayer($player);
        $launchGameRes = SlotgenLucky81::LaunchGameApi($launchData);
        if ($launchGameRes['success']) {
            $resData = SlotgenLucky81::LaunchGameRes($launchGameRes);
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
