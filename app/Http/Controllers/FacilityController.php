<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use Illuminate\Http\Request;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class FacilityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('facility.index', [
            "facilities" => Facility::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('facility.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|string|unique:facilities',
            'slug' => 'required|unique:facilities|string',
            'desc' => 'required|string',
        ]);

        Facility::create($validateData);
        return redirect('facility')->with('message', 'Data Fasilitas telah ditambah');
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('facility.edit', [
            'facility' => Facility::find($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Facility $facility)
    {
        $rules = [
            'name' => 'required|string',
            'desc' => 'required|string',
        ];

        if ($request->slug != $facility->slug) {
            $rules['slug'] = 'required|unique:facilities';
        }

        $validatedData = $request->validate($rules);


        Facility::where('id', $facility->id)->update($validatedData);

        return redirect('facility')->with('message', 'Data Fasilitas telah diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Facility::destroy($id);
        return redirect('facility')->with('message', 'Data Fasilitas telah dihapus');
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Facility::class, 'slug', $request->name);

        return response()->json(['slug' => $slug]);
    }
}
