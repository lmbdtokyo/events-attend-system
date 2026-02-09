<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Eventuser;
use Illuminate\Support\Facades\Auth;
use App\Mail\ApprovalStatusChangedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;


class EventApprovalController extends Controller
{
    public function index(Event $event)
    {
        $user = Auth::user();
        if ($user->organization_id === $event->organization_id) {
            $eventUsers = Eventuser::where('event_id', $event->id)->paginate(50);
            return view('events.user.approval', compact('eventUsers','event'));
        } else {
            return redirect()->route('events.index')->with('error', '権限がありません');
        }
    }

    public function update(Event $event , Request $request, $id)
    {

        $eventUser = Eventuser::findOrFail($request->input('eventuser_id'));
        $approvalStatus = $request->input('approval');
        $eventUser->approval = $approvalStatus;
        $eventUser->save();

        // イベント情報を取得
        $eventData = Event::findOrFail($eventUser->event_id);

        // メール送信（削除前に送信）
        Mail::to($eventUser->mail)->send(new ApprovalStatusChangedMail($eventUser, $eventData));

        // 非承認の場合はレコードとPDFファイルを削除
        if ($approvalStatus == 0 || $approvalStatus == 2) {
            // PDFファイルを削除
            if ($eventUser->pdf_name && Storage::exists($eventUser->pdf_name)) {
                Storage::delete($eventUser->pdf_name);
            }

            // ユーザーレコードを削除（関連するeventrecordsも自動削除される）
            $eventUser->delete();

            return redirect()->route('event.approval', $eventData->id)->with('success', '申込者を非承認にし、データを削除しました');
        }

        return redirect()->route('event.approval', $eventUser->event_id)->with('success', '申込者の承認状況が更新されました');
    }
}
