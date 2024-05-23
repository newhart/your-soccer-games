<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function changeLanguage(Request $request): RedirectResponse
    {
        $locale = $request->input('locale');
        if (array_key_exists($locale, config('app.supported_locales'))) {
            session(['locale' => $locale]);
        }

        return redirect()->back();
    }
}
