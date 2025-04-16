<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use App\Http\Resources\RoomResource;
use App\Models\Room;
use App\Models\Building;
use App\Models\RoomImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\QueryBuilder\QueryBuilder;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $columns = Schema::getColumnListing('rooms');
        $rooms = QueryBuilder::for(Room::class)
            ->allowedFilters($columns)
            ->allowedSorts($columns)
            ->paginate()
            ->appends($request->query());

        return view('room.index', [
            'rooms' => RoomResource::collection($rooms),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $buildings = Building::all();
        $status = [
            '0' => 'Còn trống',
            '1' => 'Đã thuê'
        ];
        return view('room.create', [
            'buildings' => $buildings,
            'status' => $status
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoomRequest $request)
    {
        DB::beginTransaction();
        try {
            $room = Room::create($request->validated());
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('rooms', 'public');
                    $room->images()->create([
                        'image_path' => $path,
                        'is_main' => $request->input('is_main', false),
                        'display_order' => 0
                    ]);
                }
            }
            DB::commit();
            return redirect()->route('room.index');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $room = Room::with('building', 'images')->findOrFail($id);
        return view('room.show', [
            'room' => $room
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $room = Room::findOrFail($id);
        $buildings = Building::all();
        $status = [
            '0' => 'Còn trống',
            '1' => 'Đã thuê'
        ];
        return view('room.edit', [
            'room' => $room,
            'buildings' => $buildings,
            'status' => $status
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoomRequest $request, string $id)
    {
        $room = Room::findOrFail($id);
        $data = $request->all();
        DB::beginTransaction();
        try {
            $room->update($data);
            if ($request->has('delete_images')) {
                $imagesToDelete = $room->images()->whereIn('id', $request->delete_images)->get();

                foreach ($imagesToDelete as $image) {
                    if (Storage::disk('public')->exists($image->image_path)) {
                        Storage::disk('public')->delete($image->image_path);
                    }
                    $image->delete();
                }
            }

            if ($request->has('is_main')) {
                $room->images()->update(['is_main' => 0]);

                if (is_numeric($request->is_main)) {
                    $room->images()->where('id', $request->is_main)->update(['is_main' => 1]);
                }
            }

            if ($request->hasFile('images')) {
                $existingCount = $room->images()->count();

                foreach ($request->file('images') as $index => $image) {
                    $path = $image->store('rooms', 'public');
                    RoomImage::create([
                        'room_id' => $room->id,
                        'image_path' => $path,
                        'is_main' => 0,
                        'display_order' => $existingCount + $index,
                    ]);
                }

                if ($room->images()->where('is_main', 1)->count() == 0) {
                    $room->images()->first()->update(['is_main' => 1]);
                }
            }
            DB::commit();
            return redirect()->route('room.index');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $room = Room::findOrFail($id);
        try {
            foreach ($room->images as $image) {
                if (Storage::disk('public')->exists($image->image_path)) {
                    Storage::disk('public')->delete($image->image_path);
                }
            }
            $room->delete();
            return redirect()->route('room.index');
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }
}
