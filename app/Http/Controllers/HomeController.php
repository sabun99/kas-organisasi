<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function index()
    {
        try {
            // Kita gunakan API Quotable yang lebih stabil
            $response = Http::withoutVerifying()->get('https://api.quotable.io/random');

            if ($response->successful()) {
                $data = $response->json();
                $random = [
                    'quote'  => $data['content'], // Quotable menggunakan 'content'
                    'author' => $data['author']
                ];
            } else {
                throw new \Exception("Gagal mengambil data");
            }
        } catch (\Exception $e) {
            // Data cadangan jika API bermasalah
            $random = [
                'quote'  => 'Manajemen keuangan adalah kunci keberlanjutan organisasi.',
                'author' => 'Kasku Admin'
            ];
        }

        return view('pages.home', compact('random'));
    }
}