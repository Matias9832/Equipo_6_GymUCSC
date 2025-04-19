<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Noticia;
use App\Models\Eventos;

class WelcomeController extends Controller
{
    public function index()
    {
        $noticias = Noticia::latest()->take(3)->get();
        $actividades = Eventos::whereDate('fecha', '>=', now())->orderBy('fecha')->take(3)->get();

        return view('home', compact('noticias', 'actividades'));
    }
}

