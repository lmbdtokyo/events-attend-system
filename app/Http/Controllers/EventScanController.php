<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Eventuser;
use App\Models\Eventqr;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use App\Models\Eventrecord;



class EventScanController extends Controller
{
    protected function jsonScanError(string $message, int $status = 400, $user = null): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'ok' => false,
            'message' => $message,
            'user' => $user,
        ], $status);
    }

    protected function jsonScanSuccess(string $message, $user, int $exitentry): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'ok' => true,
            'message' => $message,
            'user' => $user,
            'exitentry' => $exitentry,
        ], 200);
    }

    public function scan($event, $exitentry)
    {
        if (Auth::check()) {
            return view('events.scan', ['event' => $event, 'exitentry' => $exitentry]);
        } else {
            return redirect()->route('eventuser.login');
        }
    }

    public function userqr($eventId, $qrid , $exitentry , Eventrecord $eventrecord)
    {

        //カスタムヘッダーからユーザーIDを取得
        $userId = request()->header('X-User-ID');

        if (!$userId) {
            return $this->jsonScanError('操作者IDがありません。', 400);
        }

        if ($exitentry != 1 && $exitentry != 2) {
            return $this->jsonScanError('無効なリクエストです。', 400);
        }

        $eventuser = Eventuser::where('event_id', $eventId)->where('qr', $qrid)->first();

        if (!$eventuser) {
            return $this->jsonScanError('無効なQRです。', 404);
        }

        if ($exitentry == 1 && $eventuser->entry_flg == 1) {
            return $this->jsonScanError('すでに入場中です。', 400, $eventuser);
        }

        if ($exitentry == 2 && $eventuser->entry_flg == 0) {
            return $this->jsonScanError('すでに退場済みです。', 400, $eventuser);
        }


        $eventrecord->event_id = $eventId;
        $eventrecord->applicant_id = $eventuser->id;
        $eventrecord->nonuser_id = null;
        $eventrecord->entry_exit = $exitentry;
        $eventrecord->user_id = $userId;
        $eventrecord->save();

        if ($exitentry == 1) {
            $eventuser->entry_flg = 1;
            $eventuser->save();
        }

        if ($exitentry == 2) {
            $eventuser->entry_flg = 0;
            $eventuser->save();
        }

        $msg = $exitentry == 1 ? '入場を記録しました。' : '退場を記録しました。';

        return $this->jsonScanSuccess($msg, $eventuser, (int) $exitentry);
    }

    public function nonuserqr($eventId, $qrid , $exitentry , Eventrecord $eventrecord)
    {


        //カスタムヘッダーからユーザーIDを取得
        $userId = request()->header('X-User-ID');

        if (!$userId) {
            return $this->jsonScanError('操作者IDがありません。', 400);
        }

        if ($exitentry != 1 && $exitentry != 2) {
            return $this->jsonScanError('無効なリクエストです。', 400);
        }

        $eventnonuser = Eventqr::where('event_id', $eventId)->where('qr_id', $qrid)->first();

        if (!$eventnonuser) {
            return $this->jsonScanError('無効なQRです。', 404);
        }

        if ($exitentry == 1 && $eventnonuser->entry_flg == 1) {
            return $this->jsonScanError('すでに入場中です。', 400, $eventnonuser);
        }

        if ($exitentry == 2 && $eventnonuser->entry_flg == 0) {
            return $this->jsonScanError('すでに退場済みです。', 400, $eventnonuser);
        }

        $eventrecord->event_id = $eventId;
        $eventrecord->applicant_id = null;
        $eventrecord->nonuser_id = $eventnonuser->id;
        $eventrecord->entry_exit = $exitentry;
        $eventrecord->user_id = $userId;
        $eventrecord->save();

        if ($exitentry == 1) {
            $eventnonuser->entry_flg = 1;
            $eventnonuser->save();
        }

        if ($exitentry == 2) {
            $eventnonuser->entry_flg = 0;
            $eventnonuser->save();
        }

        $msg = $exitentry == 1 ? '入場を記録しました。' : '退場を記録しました。';

        return $this->jsonScanSuccess($msg, $eventnonuser, (int) $exitentry);
    }
}
