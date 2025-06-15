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
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Room::with(['building', 'images']);

        if ($user && $user->hasRole('landlord')) {
            // Landlord chỉ xem được phòng thuộc các tòa nhà của mình
            $query->whereHas('building', function ($buildingQuery) use ($user) {
                $buildingQuery->where('user_id', $user->id);
            });
        }
        // Admin có thể xem tất cả phòng (không cần thêm điều kiện)

        $rooms = QueryBuilder::for($query)
            ->allowedFilters(['room_number', 'status', 'building_id'])
            ->allowedSorts(['room_number', 'price', 'created_at'])
            ->paginate(10);

        return view('room.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();

        if ($user && $user->hasRole('landlord')) {
            // Landlord chỉ có thể tạo phòng trong tòa nhà của mình
            $buildings = Building::where('user_id', $user->id)->get();
        } else {
            // Admin có thể tạo phòng trong bất kỳ tòa nhà nào
            $buildings = Building::all();
        }

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
        $user = Auth::user();
        $data = $request->all();

        // Kiểm tra quyền tạo phòng trong tòa nhà này
        if ($user && $user->hasRole('landlord')) {
            $building = Building::find($data['building_id']);
            if (!$building || $building->user_id !== $user->id) {
                abort(403, 'Bạn không có quyền tạo phòng trong tòa nhà này.');
            }
        }

        // Tạo phòng mới
        $room = Room::create($data);

        // Liên kết ảnh đã tải lên với phòng mới
        if ($request->filled('image_ids')) {
            try {
                $imageIds = json_decode($request->image_ids, true);

                if (is_array($imageIds) && count($imageIds) > 0) {
                    foreach ($imageIds as $imageId) {
                        // Tạo liên kết trong bảng room_images
                        $roomImage = RoomImage::create([
                            'room_id' => $room->id,
                            'image_id' => $imageId
                        ]);
                    }

                    // Tải lại mối quan hệ images để đảm bảo dữ liệu mới nhất
                    $room->load('images');
                }
            } catch (\Exception $e) {
                // Có thể thêm xử lý lỗi ở đây nếu cần
            }
        }

        return redirect()->route($this->getRoutePrefix() . 'rooms.index')->with('success', 'Phòng đã được tạo thành công.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        $user = Auth::user();

        // Kiểm tra quyền xem phòng
        if ($user && $user->hasRole('landlord') && $room->building->user_id !== $user->id) {
            abort(403, 'Bạn không có quyền xem phòng này.');
        }

        return view('room.show', [
            'room' => new RoomResource($room),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = Auth::user();
        $room = Room::findOrFail($id);

        // Kiểm tra quyền chỉnh sửa phòng
        if ($user && $user->hasRole('landlord') && $room->building->user_id !== $user->id) {
            abort(403, 'Bạn không có quyền chỉnh sửa phòng này.');
        }

        if ($user && $user->hasRole('landlord')) {
            $buildings = Building::where('user_id', $user->id)->get();
        } else {
            $buildings = Building::all();
        }

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
        $user = Auth::user();
        $room = Room::findOrFail($id);

        // Kiểm tra quyền cập nhật phòng
        if ($user && $user->hasRole('landlord') && $room->building->user_id !== $user->id) {
            abort(403, 'Bạn không có quyền cập nhật phòng này.');
        }

        $data = $request->all();

        $room->update($data);

        // Xử lý ảnh mới được tải lên (nếu có)
        if ($request->filled('new_image_ids')) {
            try {
                $newImageIds = json_decode($request->new_image_ids, true);

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
                        }
                    }

                    // Tải lại mối quan hệ images để đảm bảo dữ liệu mới nhất
                    $room->load('images');
                }
            } catch (\Exception $e) {
                // Có thể thêm xử lý lỗi ở đây nếu cần
            }
        }

        return redirect()->route($this->getRoutePrefix() . 'rooms.index')->with('success', 'Phòng đã được cập nhật thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = Auth::user();
        $room = Room::findOrFail($id);

        // Kiểm tra quyền xóa phòng
        if ($user && $user->hasRole('landlord') && $room->building->user_id !== $user->id) {
            abort(403, 'Bạn không có quyền xóa phòng này.');
        }

        $room->delete();
        return redirect()->route($this->getRoutePrefix() . 'rooms.index');
    }

    /**
     * Determine the route prefix based on user role
     */
    private function getRoutePrefix(): string
    {
        $user = Auth::user();
        if ($user && $user->hasRole('admin')) {
            return 'admin.';
        } elseif ($user && $user->hasRole('landlord')) {
            return 'landlord.';
        }
        return '';
    }
}
