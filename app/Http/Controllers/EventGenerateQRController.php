<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Eventgenerateqr;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use App\Models\Eventbasic;
use App\Models\Eventuser;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Eventqr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Eventpdfimage;


class EventGenerateQRController extends Controller
{
    public function index(Event $event)
    {
        if (Auth::user()->type === 'master' || Auth::user()->organization == $event->organization) {
            $eventGenerateQRs = Eventgenerateqr::where('event_id', $event->id)->paginate(10);
            return view('events.detail.qrindex', compact('eventGenerateQRs', 'event'));
        } else {
            $user = Auth::user();
            if ($user->organization == $event->organization) {

                $eventGenerateQRs = Eventgenerateqr::where('event_id', $event->id)->paginate(10);
                return view('events.detail.qrindex', compact('eventGenerateQRs', 'event'));
                
            } else {
                return redirect()->route('events.index')->with('error', '権限がありません。');
            }
        }
    }

    public function create(Event $event)
    {
        if (Auth::user()->type === 'master' || Auth::user()->organization == $event->organization) {
            return view('events.detail.qrcreate', compact('event'));
        } else {
            $user = Auth::user();
            if ($user->organization == $event->organization) {

                $eventGenerateQRs = Eventgenerateqr::where('event_id', $event->id)->paginate(10);
                return view('events.detail.qrcreate', compact('event'));
                
            } else {
                return redirect()->route('events.index')->with('error', '権限がありません。');
            }
        }
    }

    public function store(Request $request , Eventbasic $eventbasic , Event $event , Eventuser $eventuser , Eventqr $eventqr)
    {
        $request->validate([
            'number' => 'required|integer|min:1|max:50',
        ]);

        if ($eventbasic->limit == 1) {
            $remainingSeats = $eventbasic->limit_number - $eventuser->where('event_id', $event->id)->count() - $eventqr->where('event_id', $event->id)->count();
            if ($request->input('number') > $remainingSeats) {
                return redirect()->back()->withErrors(['number' => '残りの来場者数は' . $remainingSeats . 'です。']);
            }
        }        

        $eventGenerateQR = new Eventgenerateqr();
        $eventGenerateQR->event_id = $event->id;
        $eventGenerateQR->number = $request->input('number');

        $qrCodes = [];
        for ($i = 0; $i < $request->input('number'); $i++) {
            $uuid = (string) Str::uuid();

            $appUrl = config('app.url');
            $qrCodeUrl = $appUrl . '/events/'.$event->id.'/qr/nonuser/' . $uuid;
            $qrCode = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')->size(200)->generate($qrCodeUrl);
            $qrCodes[] = $qrCode;

            $eventqr = new Eventqr();
            $eventqr->event_id = $event->id;
            $eventqr->qr_id = $uuid;
            $eventqr->save();
        }

        $eventpdfimage = Eventpdfimage::where('event_id', $event->id)->first();

        $eventpdfimage_data = null;

        if ($eventpdfimage->image) {
            $eventpdfimage_data = base64_encode(Storage::get($eventpdfimage->image));
        }

        $pdf = PDF::loadView('pdf.generatepdf', ['qrCodes' => $qrCodes, 'eventpdfimage' => $eventpdfimage_data])->setPaper('a4');
        $pdfPath = 'pdfs/' . $uuid . '.pdf';
        Storage::disk('public')->put($pdfPath, $pdf->output());

        $pdfUrl = Storage::disk('public')->url($pdfPath);

        $eventGenerateQR->pdf_path = $pdfUrl;
        $eventGenerateQR->save();

        return redirect()->route('eventsgenerateqr.index', $event->id)->with('success', 'QRコードが生成されました。');
    }

    public function show(Event $event, $id)
    {
        if (Auth::user()->type === 'master' || Auth::user()->organization == $event->organization) {
            $eventGenerateQR = Eventgenerateqr::findOrFail($id);
            return view('events.detail.qrshow', compact('eventGenerateQR', 'event'));
        } else {
            $user = Auth::user();
            if ($user->organization == $event->organization) {
                $eventGenerateQR = Eventgenerateqr::findOrFail($id);
                return view('events.detail.qrshow', compact('eventGenerateQR', 'event'));
            } else {
                return redirect()->route('events.index')->with('error', '権限がありません。');
            }
        }
    }

}
