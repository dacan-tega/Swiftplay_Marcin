<?php

namespace Slotgen\SlotgenBonusJoker\Http\Controllers;

use App\Http\Controllers\AppBaseController as LaravelController;

class AppBaseController extends LaravelController
{
    public function sendResponse($result, $message)
    {
        return $this->makeResponse($message, $result);
    }

    public function sendError($error, $code = 200)
    {
        return $this->makeError($error);
    }

    public function sendSuccess($message)
    {
        return [
            'success' => true,
            'message' => $message,
        ];
    }

    public static function makeResponse($message, $data)
    {
        return [
            'success' => true,
            'data' => $data,
            'message' => $message,
        ];
    }

    /**
     * @param  string  $message
     * @return array
     */
    public static function makeError($message, array $data = [])
    {
        $res = [
            'success' => false,
            'message' => $message,
        ];

        if (! empty($data)) {
            $res['data'] = $data;
        }

        return $res;
    }
}
