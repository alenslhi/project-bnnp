<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FaqKontakController extends Controller
{
    /**
     * Menampilkan halaman FAQ dan Kontak Darurat
     */
    public function index()
    {
        return view('publik.faq-kontak');
    }
}
