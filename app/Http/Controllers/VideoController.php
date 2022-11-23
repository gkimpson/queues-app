<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVideoRequest;
use App\Jobs\ConvertVideo;
use App\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VideoController extends Controller
{

    /**
     * Return video blade view and pass videos to it.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        // $videos = Video::orderBy('created_at', 'DESC')->get();
        // return view('videos')->with('videos', $videos);
        return view('videos');
    }

    /**
     * Return uploader form view for uploading videos
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function uploader(){
        return view('uploader');
    }

    /**
     * Handles form submission after uploader form submits
     * @param StoreVideoRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreVideoRequest $request)
    {
        $filename = Str::random(16) . '-' . Str::random(16);
        $path = $filename . '.' . $request->video->getClientOriginalExtension();
        $request->video->storeAs('public', $path);

        $video = [
            'disk'          => 'public',
            'original_name' => $request->video->getClientOriginalName(),
            'path'          => $path,
        ];

        for ($i = 0; $i < 25; $i++) {
            ConvertVideo::dispatch($video);
        }

        // simply change the 2nd parameter to run to a larger number to run this multiple times e.g 10
        // foreach(range(1, 5) as $i) {
        // }

        return redirect('/');
    }
}
