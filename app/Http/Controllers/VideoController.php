<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use Storage;


class VideoController extends Controller
{
    public function index(){
        $videoFiles = Storage::disk('public')->files('secret');
        return view('create', compact('videoFiles'));
    }

    public function store(Request $request){
        $video = new Video;
        $video->name = $request['name'];
        if($request->hasFile('video')){
            $path = $request->file('video');
            $storedpath = $path->store('videos','public');
            $basename = basename($storedpath);
            $video->video = $basename;
            encodevideo($basename);
        }
        $video->save();
        // Delete the video stored in storage after encoding if not required
        // Storage::disk('public')->delete($storedPath);
        return redirect()->back();
    }
}
