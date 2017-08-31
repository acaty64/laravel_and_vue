<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
        return Note::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only(['note','category_id']);
        // validate()   ValidatesRequests.php
        $this->validate($request, [
                'note' => 'required',
                'category_id' => 'exists:categories,id',
            ]);

        $note = Note::create($data);

        return [
            'success'   => true,
            'note'      => $note,
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Note $note)
    {
        $this->validate($request, [
                'note' => 'required',
                'category_id' => 'exists:categories,id',
            ]);

        $note->fill($request->all());
        $note->save();
        return [
            'success' => true,
            'note'    => $note,
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $note)
    {
        //abort(500, 'Something is wrong !!!');
//Ejemplo:        abort_if($note->category_id==3, 403, 'No tienes permiso para eliminar esta nota', ['Accept'=>'application/json']); // Modificar Handler

        $note->delete();
        return [
            'success' => true
        ];
    }
}
