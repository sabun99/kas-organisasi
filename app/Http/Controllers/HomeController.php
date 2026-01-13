<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function index()
    {
        $random = null;

        try {
            // Coba API utama: Quotable
            $response = Http::timeout(10)->withoutVerifying()->get('https://api.quotable.io/random');

            if ($response->successful()) {
                $data = $response->json();
                $random = [
                    'quote'  => $data['content'],
                    'author' => $data['author']
                ];
            } else {
                throw new \Exception("Quotable API gagal dengan status: " . $response->status());
            }
        } catch (\Exception $e) {
            // Log error untuk debug
            \Log::error('Quotable API gagal: ' . $e->getMessage());

            try {
                // Fallback ke API alternatif: ZenQuotes
                $responseAlt = Http::timeout(10)->withoutVerifying()->get('https://zenquotes.io/api/random');

                if ($responseAlt->successful()) {
                    $dataAlt = $responseAlt->json();
                    $random = [
                        'quote'  => $dataAlt[0]['q'], // ZenQuotes menggunakan array, ambil index 0
                        'author' => $dataAlt[0]['a']
                    ];
                } else {
                    throw new \Exception("ZenQuotes API gagal dengan status: " . $responseAlt->status());
                }
            } catch (\Exception $eAlt) {
                // Log error fallback
                \Log::error('ZenQuotes API gagal: ' . $eAlt->getMessage());

                // Data cadangan jika semua API gagal
                $random = [
                    'quote'  => 'Manajemen keuangan adalah kunci keberlanjutan organisasi.',
                    'author' => 'Kasku Admin'
                ];
            }
        }

        return view('pages.home', compact('random'));
    }
}
