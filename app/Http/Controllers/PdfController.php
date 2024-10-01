<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use App\Models\Eventpdfimage;



class PdfController extends Controller
{
    public function show(Eventpdfimage $eventpdfimage)
    {



        $eventpdfimage = Eventpdfimage::where('event_id', 1)->first();
        return view('pdf.pdf', compact('eventpdfimage'));
    }
}