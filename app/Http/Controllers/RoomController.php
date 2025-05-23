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
            'available' => 'Còn trống',
            'occupied' => 'Đã thuê'
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
        $data = $request->all();

        \Log::info('Tạo phòng mới với dữ liệu:', ['data' => $data]);

        // Tạo phòng mới
        $room = Room::create($data);
        \Log::info('Đã tạo phòng mới:', ['room_id' => $room->id]);

        // Liên kết ảnh đã tải lên với phòng mới
        if ($request->filled('image_ids')) {
            try {
                $imageIds = json_decode($request->image_ids, true);
                \Log::info('Xử lý ID ảnh:', ['image_ids' => $imageIds]);

                if (is_array($imageIds) && count($imageIds) > 0) {
                    foreach ($imageIds as $imageId) {
                        // Tạo liên kết trong bảng room_images
                        $roomImage = RoomImage::create([
                            'room_id' => $room->id,
                            'image_id' => $imageId
                        ]);
                        \Log::info('Đã liên kết ảnh với phòng:', [
                            'room_id' => $room->id,
                            'image_id' => $imageId,
                            'room_image_id' => $roomImage->id
                        ]);
                    }

                    // Tải lại mối quan hệ images để đảm bảo dữ liệu mới nhất
                    $room->load('images');
                    \Log::info('Số ảnh đã liên kết:', ['count' => $room->images->count()]);
                }
            } catch (\Exception $e) {
                // Log lỗi nếu có
                \Log::error('Lỗi khi liên kết ảnh với phòng: ' . $e->getMessage(), [
                    'exception' => $e,
                    'room_id' => $room->id,
                    'image_ids' => $request->image_ids
                ]);
            }
        } else {
            \Log::info('Không có ID ảnh để xử lý');
        }

        return redirect()->route('room.index')->with('success', 'Phòng đã được tạo thành công.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        return view('room.show', [
            'room' => new RoomResource($room),
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
            'available' => 'Còn trống',
            'occupied' => 'Đã thuê'
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

        \Log::info('Cập nhật phòng', [
            'room_id' => $id,
            'has_new_images' => $request->filled('new_image_ids')
        ]);

        $room->update($data);

        // Xử lý ảnh mới được tải lên (nếu có)
        if ($request->filled('new_image_ids')) {
            try {
                $newImageIds = json_decode($request->new_image_ids, true);
                \Log::info('Xử lý ID ảnh mới:', ['new_image_ids' => $newImageIds]);

                if (is_array($newImageIds) && count($newImageIds) > 0) {
                    foreach ($newImageIds as $imageId) {
                        // Kiểm tra xem liên kết đã tồn tại chưa
                        $existingLink = RoomImage::where('room_id', $room->id)
                            ->where('image_id', $imageId)
                            ->first();

                        if (!$existingLink) {
                            // Tạo liên kết mới trong bảng room_images
                            $roomImage = RoomImage::create([
                                'room_id' => $room->id,
                                'image_id' => $imageId
                            ]);
                            \Log::info('Đã liên kết ảnh mới với phòng:', [
                                'room_id' => $room->id,
                                'image_id' => $imageId,
                                'room_image_id' => $roomImage->id
                            ]);
                        } else {
                            \Log::info('Liên kết ảnh đã tồn tại:', [
                                'room_id' => $room->id,
                                'image_id' => $imageId
                            ]);
                        }
                    }

                    // Tải lại mối quan hệ images để đảm bảo dữ liệu mới nhất
                    $room->load('images');
                }
            } catch (\Exception $e) {
                // Log lỗi nếu có
                \Log::error('Lỗi khi liên kết ảnh mới với phòng: ' . $e->getMessage(), [
                    'exception' => $e,
                    'room_id' => $room->id,
                    'new_image_ids' => $request->new_image_ids
                ]);
            }
        }

        return redirect()->route('room.index')->with('success', 'Phòng đã được cập nhật thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $room = Room::findOrFail($id);

        $room->delete();
        return redirect()->route('room.index');
    }
}
