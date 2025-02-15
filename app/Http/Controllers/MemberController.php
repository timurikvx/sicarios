<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{

    public function members(Request $request): array
    {
        $storage = Storage::disk('public');
        $members =  json_decode($storage->get('/members/data.json'));
        $collection = new Collection($members);
        $sorted = $collection->sortByDesc('number');
        return $sorted->values()->toArray();
    }

    public function add(Request $request): array
    {
        $storage = Storage::disk('public');
        $photo = $request->file('photo');
        $photo_name = $photo->getClientOriginalName();
        $photo->storeAs('public/members/', $photo_name);
        $member = [
            'name'=>$request->get('name'),
            'description'=>$request->get('description'),
            'photo'=>'/members/'.$photo_name,
            'role'=>$request->get('role'),
            'vk'=>$request->get('vk'),
            'number'=>intval($request->get('number')),
        ];
        $members = json_decode($storage->get('/members/data.json'));
        $members[] = $member;
        $storage->put('/members/data.json', json_encode($members));
        return $members;

    }

    public function remove(Request $request): array
    {
        $name = $request->get('name');
        $storage = Storage::disk('public');
        $members = json_decode($storage->get('/members/data.json'));
        $collection = new Collection($members);
        $members = $collection->where('name', '<>', $name);
        $storage->put('/members/data.json', json_encode($members));
        return $members->toArray();
    }

}
