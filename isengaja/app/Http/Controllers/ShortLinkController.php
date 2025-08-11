<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\ShortLink;
use Illuminate\Support\Str;

class ShortLinkController extends Controller
{
    // Menyimpan shortlink baru
    public function store(Request $request)
    {
        $request->validate([
            'original_url' => 'required|url',
            'alias' => 'nullable|alpha_num|unique:short_links,alias',
        ]);

        $alias = $request->alias;
        if (!$alias) {
            // Generate alias random jika tidak diisi
            do {
                $alias = Str::random(6);
            } while (ShortLink::where('alias', $alias)->exists());
        }

        $shortLink = ShortLink::create([
            'original_url' => $request->original_url,
            'alias' => $alias,
        ]);

        return response()->json([
            'short_url' => url($alias),
            'alias' => $alias,
        ]);
    }

    // Redirect dari alias ke original_url
    public function show($alias)
    {
        $shortLink = ShortLink::where('alias', $alias)->firstOrFail();
        $shortLink->increment('clicks');
        return redirect($shortLink->original_url);
    }

    // Cek ketersediaan alias (opsional, untuk validasi frontend)
    public function checkAlias(Request $request)
    {
        $request->validate([
            'alias' => 'required|alpha_num',
        ]);
        $exists = ShortLink::where('alias', $request->alias)->exists();
        return response()->json(['available' => !$exists]);
    }
}
