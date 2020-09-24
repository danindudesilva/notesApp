<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNote;
use App\Http\Requests\UpdateNote;
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

    public function getArchived($user_id)
    {

        $note = Note::where('user_id', $user_id)->where('status', 'archived')->get();
        if(empty($note)) {
            return response()->json(null, 404);
        }else {
            return new NoteCollection($note);
        }
    }

    public function getUnarchived($user_id)
    {
        $note = Note::where('user_id', $user_id)->where('status', 'unarchived')->get();
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
    public function update(UpdateNote $request, $id)
    {
        $note = Note::where('user_id', $request->user_id)->where('id', $id)->first();
        if(empty($note)){
            return response()->json(null, 404);
        }else {
            $note->update($request->all());
            return new NoteResource($note);
        }

    }

    public function archive(UpdateNote $request, $id)
    {
        $note = Note::where('user_id', $request->user_id)->where('id', $id)->first();

        if(empty($note)){
            return response()->json(null, 404);
        }else {
            $note->update(["status" => "archived"]);
            return new NoteResource($note);
        }
    }

    public function unarchive(UpdateNote $request, $id)
    {
        $note = Note::where('user_id', $request->user_id)->where('id', $id)->first();

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
    public function destroy(UpdateNote $request, $id)
    {
        $note = Note::where('user_id', $request->user_id)->where('id', $id)->first();

        if(empty($note)){
            return response()->json(null, 404);
        }else {
            $note->delete();
            return response()->json($note, 204);
        }
    }
}
