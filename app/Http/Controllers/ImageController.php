<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ImageResource;
use Illuminate\Support\Facades\Schema;
use Spatie\QueryBuilder\QueryBuilder;
use App\Models\Image;
use App\Http\Requests\StoreImageRequest;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $columns = Schema::getColumnListing('images');
        $resource = QueryBuilder::for(Image::class)
            ->allowedSorts($columns)
            ->allowedFilters($columns)
            ->paginate()
            ->appends($request->query());

        return view('image.index', [
            'images' => ImageResource::collection($resource)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('image.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreImageRequest $request)
    {
        $disk_name = 'public';
        $folder  = 'upload';
        $files = $request->file('file');
        $image = [];
        foreach ($files as $file) {
            $path = $file->store($folder, $disk_name);
            $data = $request->all();
            unset($data['file']);
            unset($data['room_id']);
            $data['path'] = $path;
            $data['name'] = $file->getClientOriginalName();
            $data['size'] = $file->getSize();
            $data['type'] = $file->getMimeType();
            $img = Image::create($data);
            $image[] = $img;
            if ($request->filled('room_id')) {
                $img->roomImage()->create([
                    'room_id' => $request->room_id
                ]);
            }
        }

        return response()->json([
            'data' => $image,
            'message' => 'Image created successfully'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Image $image)
    {
        return view('image.show', compact('image'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Image $image)
    {
        return view('image.edit', compact('image'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Image $image)
    {
        $image->delete();

        return response()->json([
            'message' => 'Image deleted successfully'
        ], 200);
    }
}
