<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateURLFormRequest;
use App\Jobs\UrlDataStore;
use App\Models\Url;
use Illuminate\Http\Request;

class UrlController extends Controller
{
    public function create()
    {
        return view('add');
    }

    public function store(CreateURLFormRequest $request)
    {
        $regex = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
        $urls = preg_split('/\r\n|\r|\n/', $request->url);
        $validURLs = [];
        $hasDuplicates = count($urls) > count(array_unique($urls));

        if ($hasDuplicates === true) {
            return redirect()->back()->with('error', 'We found some duplicate url');
        }

        foreach ($urls as $key => $url) {
            if (!preg_match($regex, $url)) {
                return redirect()->back()->with('error', 'We found some invalid url');
            }
            $parse = parse_url($url);
            $existingUrlCheck = Url::query()->where('url', '=', $url)->first();
            if (!empty($existingUrlCheck)) {
                return redirect()->back()->with('error', 'We found some duplicate url');
            }
            $validURLs[$key]['host'] = $parse['host'];
            $validURLs[$key]['url'] = $url;
        }

        dispatch(new UrlDataStore($validURLs));
        return redirect()->back()->with('success', 'Your action has been created successfully');
    }
}
