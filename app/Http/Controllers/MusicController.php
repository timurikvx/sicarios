<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Storage;

class MusicController extends Controller
{

    public function collection(Request $request)
    {
        $data = collect([]);
        $storage = Storage::disk('public');
        $directories = $storage->directories('/music');
        foreach ($directories as $directory){

            $logo = '';
            $files = $storage->files($directory);
            foreach ($files as $file){
                if(str_starts_with($file, $directory.'/logo')){
                    $logo = str_replace($directory.'/', '', $file);
                }
            }

            $content = json_decode($storage->get($directory.'/data.json'));
            $data[] = [
                'folder'=>'/storage/'.$directory.'/',
                'data'=>$content,
                'logo'=>$logo,
                'timestamp'=>(new \DateTime($content->date))->getTimestamp()
            ];

        }
        $data = $data->sortByDesc('timestamp');
        return $data->values();
    }

    public function last(Request $request)
    {
        $data = collect([]);
        $storage = Storage::disk('public');
        $directories = $storage->directories('/music');
        foreach ($directories as $directory){

            $logo = '';
            $files = $storage->files($directory);
            foreach ($files as $file){
                if(str_starts_with($file, $directory.'/logo')){
                    $logo = str_replace($directory.'/', '', $file);
                }
            }

            $content = json_decode($storage->get($directory.'/data.json'));
            $data[] = [
                'folder'=>'/storage/'.$directory.'/',
                'data'=>$content,
                'logo'=>$logo,
                'timestamp'=>(new \DateTime($content->date))->getTimestamp()
            ];

        }
        $data = $data->sortByDesc('timestamp');
        return $data->take(3)->values();
    }

    public function release(Request $request)
    {
        ini_set('post_max_size', '200M');
        set_time_limit(300);
        $name = $request->get('name');
        $description = $request->get('description');
        $year = $request->get('year');

        $tracks = intval($request->get('tracks'));
        $storage = Storage::disk('public');
        $storage->makeDirectory('/music/'.$name);

        $ext = $request->file('logo')->getClientOriginalExtension();
        $request->file('logo')->storeAs('public/music/'.$name, 'logo.'.$ext);

        $data = [
            'name'=>$name,
            'description'=>$description,
            'date'=>(new \DateTime())->format('Y-m-d H:i:s'),
            'year'=>$year,
            'tracks'=>[]
        ];

        for ($i = 0; $i < $tracks; $i++){

            $track_name = $request->get('track_name'.$i);
            $track_desc = $request->get('track_desc'.$i);

            $filenameWithExt = $request->file('track_file'.$i)->getClientOriginalName();
            $fileName = '/music/'.$name.'/'.$filenameWithExt;
            $request->file('track_file'.$i)->storeAs('public/', $fileName);
            $data['tracks'][] = [
                'name'=> $track_name,
                'description'=> $track_desc,
                'file'=>$filenameWithExt
            ];
            $storage->put('/music/'.$name.'/data.json', json_encode($data));
        }
        return ['result'=>true];

    }

    public function remove(Request $request)
    {
        $name = $request->get('name');
        $storage = Storage::disk('public');
        $storage->deleteDirectory('/music/'.$name);
        return $this->collection($request);
    }


}
