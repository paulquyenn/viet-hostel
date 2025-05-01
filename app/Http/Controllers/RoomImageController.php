<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoomImageRequest;
use App\Http\Requests\UpdateRoomImageRequest;
use App\Http\Resources\RoomImageResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Spatie\QueryBuilder\QueryBuilder;
use App\Models\RoomImage;

class RoomImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $columns = Schema::getColumnListing('room_images');
        $resource = QueryBuilder::for(RoomImage::class)
            ->allowedSorts($columns)
            ->allowedFilters($columns)
            ->paginate()
            ->append($request->query());
        return view('room_image.index', [
            'room_images' => RoomImageResource::collection($resource)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('room_image.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoomImageRequest $request)
    {
        $data = $request->all();
        $roomImage = RoomImage::create($data);
        return redirect()->route('room_image.index')->with('success', 'Room image created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RoomImage $roomImage)
    {
        return view('room_image.edit', [
            'roomImage' => new RoomImageResource($roomImage)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoomImageRequest $request, RoomImage $roomImage)
    {
        $data = $request->all();
        $roomImage->update($data);
        return redirect()->route('room_image.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RoomImage $roomImage)
    {
        try {
            $roomImage->delete();
            return redirect()->route('room_image.index');
        } catch (\Exception $e) {
            return redirect()->route('room_image.index');
        }
    }
}
