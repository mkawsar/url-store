<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateURLFormRequest;
use Illuminate\Http\Request;

class UrlController extends Controller
{
    public function create()
    {
        return view('add');
    }

    public function store(Request $request)
    {
        $regex = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
        $urls = explode(' ', $request->url);
        $validURLs = [];

        foreach ($urls as $key => $url) {
            if (!preg_match($regex, $url)) {
                return redirect()->back()->with('error', 'We found some invalid url');
            }
            $parse = parse_url($url);
            $validURLs[$key]['host'] = $parse['host'];
            $validURLs[$key]['url'] = $url;
        }

        return $validURLs;
    }
}
