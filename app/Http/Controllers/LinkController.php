<?php

namespace App\Http\Controllers;

use App\Link;
use Illuminate\Http\Request;

class LinkController extends Controller
{
   public function index() {

        $links = Link::all();
        return view('laracrud')->with('links', $links);

    }

    public function store(Request $request) {
        $link = Link::create($request->all());
        return Response::json($link);
    }

    public function edit($link_id) {
        $link = Link::find($link_id);
        return Response::json($link);
    }

    public function update(Request $request, $link_id) {
        $link = Link::find($link_id);
        $link->url = $request->url;
        $link->description = $request->description;
        $link->save();
        return Response::json($link);
    }

    public function delete($link_id) {
        $link = Link::destroy($link_id);
        return Response::json($link);
    }




}//end class
