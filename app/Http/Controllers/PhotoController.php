<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePhotoRequest;
use App\Models\Photo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Photo::all();
        return view('Photos.index',['data'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Photos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePhotoRequest $request):RedirectResponse
    {
        $validated = $request->validated();

        $path = public_path('images/');
        !is_dir($path) && mkdir($path, 0777, true);

        $imageName = time() . '.' .  $validated['image']->extension();
        $request->image->move($path, $imageName);

        $photo  = new Photo;
        $photo->name    = $validated['name'];
        $photo->email   = $validated['email'];
        $photo->username= $validated['username'];
        $photo->number  = $validated['number'];
        $photo->age     = $validated['age'];
        $photo->show_data = $validated['show_data'];
        $photo->photo   = $imageName;
        $photo->metadata = 'this is meta data';
        $photo->save();

        return redirect('/photos')->with('success','Photo created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Photo $photo)
    {
        return view('Photos.single',['photo'=>$photo]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Photo $photo)
    {
        return view('Photos.edit',['photo'=>$photo]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Photo $photo)
    {
        //12.7
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:64',
        ],$messages =[
            'required' => 'This :attribute is required.',
        ],$attributes = [
            'name' => 'Name',
        ]);

        if ($validator->fails()) {
            return redirect('photos/'.$photo->id.'/edit')
                        ->withErrors($validator)
                        ->withInput();
        }

          // Retrieve the validated input...
        $validated = $validator->validated();

        // Retrieve a portion of the validated input...
        $validated = $validator->safe()->only(['name', 'email']);
        $validated = $validator->safe()->except(['name', 'email']);

        dd($validated['name']);
        return redirect('/photos')->with('success','Photo created successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
