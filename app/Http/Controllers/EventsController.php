<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PHPHtmlParser\Dom;
use PHPHtmlParser\Options;

class EventsController extends Controller
{

    public function events(Request $request)
    {
        $storage = Storage::disk('public');
        $events_json = collect(json_decode($storage->get('/events/events.json')));
        $events = $events_json->sortByDesc('time');
        return $events->values()->all();
    }

    public function add(Request $request)
    {
        $data = $request->all();
        $storage = Storage::disk('public');

        $events_json = json_decode($storage->get('/events/events.json'));
        $events = collect($events_json);

        $events[] = $data;
        $events = $events->sortByDesc('time');
        $storage->put('/events/events.json', json_encode($events->values()));
        return [
            'result'=>true,
            'list'=>$events
        ];

    }

    public function remove(Request $request): array
    {
        $url = $request->get('url');
        $storage = Storage::disk('public');
        $events = collect(json_decode($storage->get('/events/events.json')));
        foreach ($events as $key => $event){
            if($event->url != $url){
                continue;
            }
            $events->forget($key);
        }
        $events = $events->sortByDesc('time');
        $storage->put('/events/events.json', json_encode($events->values()));
        return [
            'result'=>true,
            'list'=>$events->values()
        ];
    }

    public function ref(Request $request): array
    {
        $url = $request->get('url');

        $options = collect([
            'og:image'=>'image',
            'og:image:width'=>'width',
            'og:image:height'=>'height',
            'og:title'=>'title',
            'og:description'=>'description',
            'og:url'=>'url'
        ]);

        $data = [];

        $dom = new Dom;
        $dom->loadFromUrl($url);
        $metas = $dom->find('meta');
        foreach ($metas as $meta){
            $name = $meta->getAttribute('property');
            $value = mb_convert_encoding($meta->getAttribute('content'), 'windows-1251', 'UTF-8');
            if(empty($name)){
                continue;
            }
            $option = $options->get($name);
            if(empty($option)){
                continue;
            }
            $data[$option] = $value;
            if($option == 'width' || $option == 'height'){
                $data[$option] = intval($value);
            }
        }
        $data['time'] = intval(microtime(true) * 10000);
        return $data;


    }

}
