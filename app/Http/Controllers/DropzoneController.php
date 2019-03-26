<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;

class DropzoneController extends Controller
{
    public function upload(Request $request)
    {
        return $request->file('file')->storeAs($request->folder, $request->file('file')->getClientOriginalName(), 's3');
    }

    public function populate(Request $request)
    {
        $files = Storage::disk('s3')->files($request->directory);
        $results = array();

        foreach ($files as $file) {
            $obj['name'] = basename($file);
            $obj['url'] = config('filesystems.disks.s3.url').$file;
            $results[] = $obj;
        }
        return response()->json($results);
    }

    public function delete(Request $request)
    {
        if (Storage::disk('s3')->exists($request->directory.'/'.$request->file)) {
            Storage::disk('s3')->delete($request->directory.'/'.$request->file);
        }
    }
}
