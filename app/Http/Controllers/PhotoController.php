<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{

    public function photos(Request $request)
    {
        $storage = Storage::disk('public');
        $list = json_decode($storage->get('/photo/data.json'));
        $images = collect($list);
        $images = $images->reverse();
        return $images->values();
    }

    public function upload(Request $request)
    {
        $storage = Storage::disk('public');
        $count = intval($request->get('image_filelength'));
        $name = $request->get('name');

        $files = [];
        for($i = 0; $i < $count; $i++){
            $filename = $request->file('image_file'.$i)->getClientOriginalName();
            $request->file('image_file'.$i)->storeAs('public/photo/files/', $filename);
            $files[] = '/photo/files/'.$filename;
        }
        $data = [
            'name'=>$name,
            'files'=>$files
        ];
        $photos = json_decode($storage->get('/photo/data.json'));
        $photos[] = $data;
        $storage->put('/photo/data.json', json_encode($photos));
        return $this->photos($request);
    }


    public function remove(Request $request)
    {
        $i = intval($request->get('i'));
        $file = $request->get('file');

        $storage = Storage::disk('public');
        $list = json_decode($storage->get('/photo/data.json'), true);
        $images = collect($list);
        $index = $images->count() - $i - 1;
        $list = $images[$index];
        if(count($list['files']) == 1){
            $images->forget($index);
        }else{
            $files = $list['files'];
            $file_index = array_search($file, $files);
            if($file_index !== false){
                unset($files[$file_index]);
            }
            $list['files'] = $files;
            $images[$index] = $list;
        }
        $storage->put('/photo/data.json', json_encode($images->values()));
        return $this->photos($request);
    }


}
