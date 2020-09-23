<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNote;
use App\Http\Resources\NoteCollection;
use App\Http\Resources\NoteResource;
use App\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new NoteCollection(Note::all());
    }

    public function getArchived()
    {
        $note = Note::where('status', 'archived')->get();
        if(empty($note)) {
            return response()->json(null, 404);
        }else {
            return new NoteCollection($note);
        }
    }

    public function getUnarchived()
    {
        $note = Note::where('status', 'unarchived')->get();
        if(empty($note)) {
            return response()->json(null, 404);
        }else {
            return new NoteCollection($note);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNote $request)
    {

        $note = Note::create($request->all() + ["status" => "unarchived"]);

        return new NoteResource($note);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $note = Note::where('id', $id)->first();
        if(empty($note)) {
            return response()->json(null, 404);
        }else {
            return new NoteResource($note);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $note = Note::find($id);
        if(empty($note)){
            return response()->json(null, 404);
        }else {
            $note->update($request->all());
            return new NoteResource($note);
        }

    }

    public function archive($id)
    {
        $note = Note::find($id);
        if(empty($note)){
            return response()->json(null, 404);
        }else {
            $note->update(["status" => "archived"]);
            return new NoteResource($note);
        }
    }

    public function unarchive($id)
    {
        $note = Note::find($id);
        if(empty($note)){
            return response()->json(null, 404);
        }else {
            $note->update(["status" => "unarchived"]);
            return new NoteResource($note);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $note = Note::find($id);

        if(empty($note)){
            return response()->json(null, 404);
        }else {
            $note->delete();
            return response()->json($note, 204);
        }
    }
}
