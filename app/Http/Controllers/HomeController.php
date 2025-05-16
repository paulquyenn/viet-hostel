<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoomResource;
use App\Models\Building;
use App\Models\District;
use App\Models\Image;
use App\Models\Province;
use App\Models\Room;
use App\Models\RoomImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function Pest\Laravel\get;

class HomeController extends Controller
{
    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }

    public function motelDetail(Room $room)
    {
        // Load room with its relationships
        $room = $room->load(['building.province', 'building.district', 'building.ward', 'images', 'reviews.user']);

        // Get similar rooms based on criteria
        $similarRooms = Room::query()
            ->where('id', '!=', $room->id) // Exclude current room
            ->where('status', 0) // Only available rooms (status = 0 means available)
            ->where(function ($query) use ($room) {
                $query->where('building_id', $room->building_id) // Same building
                    ->orWhereBetween('price', [$room->price * 0.8, $room->price * 1.2]); // Price range within ±20%
            })
            ->with(['building.province', 'building.district', 'building.ward', 'images', 'reviews'])
            ->limit(3)
            ->get();

        return view('motel-detail', [
            'room' => $room,
            'similarRooms' => $similarRooms,
        ]);
    }

    public function motel(Request $request)
    {
        $provinces = Province::orderBy('name', 'asc')->get();
        $buildings = Building::orderBy('name', 'asc')->get();
        $districts = District::orderBy('name', 'asc')->get();

        $query = Room::query()->with('images', 'building.province', 'building.district', 'building.ward');

        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('room_number', 'like', '%' . $searchTerm . '%')
                    ->orWhere('description', 'like', '%' . $searchTerm . '%')
                    ->orWhere('utilities', 'like', '%' . $searchTerm . '%')
                    ->orWhereHas('building', function ($q) use ($searchTerm) {
                        $q->where('name', 'like', '%' . $searchTerm . '%')
                            ->orWhere('address', 'like', '%' . $searchTerm . '%');
                    });
            });
        }

        if ($request->has('province_id') && !empty($request->province_id)) {
            $query->whereHas('building', function ($q) use ($request) {
                $q->where('province_id', $request->province_id);
            });

            $districts = District::where('province_id', $request->province_id)
                ->orderBy('name', 'asc')
                ->get();
        }

        if ($request->has('district_id') && !empty($request->district_id)) {
            $query->whereHas('building', function ($q) use ($request) {
                $q->where('district_id', $request->district_id);
            });
        }

        if ($request->has('price_from') && !empty($request->price_from)) {
            $query->where('price', '>=', $request->price_from);
        }

        if ($request->has('price_to') && !empty($request->price_to)) {
            $query->where('price', '<=', $request->price_to);
        }

        if ($request->has('area_from') && !empty($request->area_from)) {
            $query->where('area', '>=', $request->area_from);
        }

        if ($request->has('area_to') && !empty($request->area_to)) {
            $query->where('area', '<=', $request->area_to);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        } else {
            $query->where('status', 0); // 0 = Còn trống
        }

        $rooms = $query->paginate(9)->appends($request->all());

        return view('motel', [
            'provinces' => $provinces,
            'districts' => $districts,
            'buildings' => $buildings,
            'rooms' => $rooms,
            'filters' => $request->all()
        ]);
    }

    public function myReviews()
    {
        $reviews = Auth::user()->reviews()->with(['room.building'])->latest()->paginate(10);

        return view('tenant.my-reviews', [
            'reviews' => $reviews
        ]);
    }
}
