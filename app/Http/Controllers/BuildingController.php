<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBuildingRequest;
use App\Http\Requests\UpdateBuildingRequest;
use App\Http\Resources\BuildingResource;
use App\Http\Resources\UserResource;
use App\Models\Building;
use App\Models\Province;
use App\Models\District;
use App\Models\User;
use App\Models\Ward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Spatie\QueryBuilder\QueryBuilder;

class BuildingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $columns = Schema::getColumnListing('buildings');

        $buildings = QueryBuilder::for(Building::class)
            ->allowedFilters($columns)
            ->allowedSorts($columns)
            ->paginate()
            ->appends($request->query());
        return view('building.index', [
            'buildings' => BuildingResource::collection($buildings),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $provinces = Province::all();
        $districts = District::all();
        $wards = Ward::all();
        $user = new UserResource(Auth::user());
        return view('building.create', [
            'provinces' => $provinces,
            'districts' => $districts,
            'wards' => $wards,
            'user' => $user,
            'users' => User::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBuildingRequest $request)
    {
        $data = $request->validated();
        if (!isset($data['user_id'])) {
            $data['user_id'] = Auth::id();
        }

        Building::create($data);
        return redirect()->route($this->getRoutePrefix() . 'buildings.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Building $building)
    {
        $building->load(['rooms', 'ward', 'district', 'province']);
        return view('building.show', compact('building'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Building $building)
    {
        $building = new BuildingResource($building);
        return view('building.edit', [
            'building' => $building,
            'provinces' => Province::all(),
            'districts' => District::all(),
            'wards' => Ward::all(),
            'users' => User::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBuildingRequest $request, Building $building)
    {
        $data = $request->all();        $building->update($data);
        return redirect()->route($this->getRoutePrefix() . 'buildings.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Building $building)
    {
        try {
            $building->delete();
            return redirect()->route($this->getRoutePrefix() . 'buildings.index');
        } catch (\Exception $e) {
            return redirect()->route($this->getRoutePrefix() . 'buildings.index');
        }
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
