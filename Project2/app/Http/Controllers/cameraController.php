<?php

namespace App\Http\Controllers;

use App\Models\cam;
use Illuminate\Http\Request;

class cameraController extends Controller
{
    public function index() {
    $cameras = cam::all();
    return view('camdemo.cam', compact('cameras'));
}

public function indexUser() {
    $cameras = cam::all();
    return view('camdemo.camuser', compact('cameras'));
}

 public function create()
    {
        return view('camdemo.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'stream_url' => 'required|url',
        ]);

        cam::create([
            'name' => $request->name,
            'stream_url' => $request->stream_url,
        ]);

        return redirect()->route('cameras.index')->with('success', 'Camera added successfully!');
    }
    public function destroy($id)
{
    $camera = cam::find($id);
    if ($camera) {
        $camera->delete();
    }
    return redirect()->route('cameras.index');
}

}
