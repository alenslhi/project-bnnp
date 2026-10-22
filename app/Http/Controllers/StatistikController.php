<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StatistikController extends Controller
{
    public function index(Request $request)
    {
        $kategoriAktif = $request->query('kategori', 'rehabilitasi');

        if (!in_array($kategoriAktif, ['rehabilitasi', 'p2m', 'pemberantasan'])) {
            $kategoriAktif = 'rehabilitasi';
        }

        return view('statistik.index', compact('kategoriAktif'));
    }
}
