<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Eventuser;
use App\Models\Eventsection;
use Illuminate\Support\Facades\Auth;
use App\Mail\ApprovalStatusChangedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;


class EventApprovalController extends Controller
{
    private const PER_PAGE = 50;

    public function index(Event $event)
    {
        $user = Auth::user();
        if ($user->organization_id === $event->organization_id) {
            $queryBase = fn () => Eventuser::where('event_id', $event->id)->orderBy('created_at', 'desc');

            $pendingUsers = $queryBase()
                ->where('approval', 0)
                ->paginate(self::PER_PAGE, ['*'], 'pending_page')
                ->withQueryString();

            $approvedUsers = $queryBase()
                ->where('approval', 1)
                ->paginate(self::PER_PAGE, ['*'], 'approved_page')
                ->withQueryString();

            $hasAnyApplicants = Eventuser::where('event_id', $event->id)->exists();

            $eventSections = Eventsection::where('event_id', $event->id)->get()->keyBy('id');

            return view('events.user.approval', compact(
                'pendingUsers',
                'approvedUsers',
                'hasAnyApplicants',
                'event',
                'eventSections'
            ));
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

            return $this->redirectToApprovalScreen($eventData->id, $request)
                ->with('success', '申込者を非承認にし、データを削除しました');
        }

        return $this->redirectToApprovalScreen($eventUser->event_id, $request)
            ->with('success', '申込者の承認状況が更新されました');
    }

    private function redirectToApprovalScreen(int|string $eventId, Request $request)
    {
        $baseUrl = route('event.approval', ['event' => $eventId]);
        $query = array_filter(
            $request->only(['pending_page', 'approved_page']),
            fn ($v) => $v !== null && $v !== ''
        );

        return redirect()->to($query !== [] ? $baseUrl.'?'.http_build_query($query) : $baseUrl);
    }
}
