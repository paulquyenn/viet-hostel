<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProvinceRequest;
use App\Http\Requests\UpdateProvinceRequest;
use App\Http\Resources\ProvinceResource;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Spatie\QueryBuilder\QueryBuilder;

class ProvinceController extends Controller
{
    public function index()
    {
        $columns = Schema::getColumnListing('provinces');

        $provinces = QueryBuilder::for(Province::class)
            ->allowedFilters($columns)
            ->allowedSorts($columns)
            ->paginate()
            ->appends(request()->query());

        return view('motel', [
            'provinces' => ProvinceResource::collection($provinces),
        ]);
    }

    public function create()
    {
        return view('province.create');
    }

    public function store(StoreProvinceRequest $request)
    {
        $data = $request->all();
        Province::create($data);

        return redirect()->route('province.index');
    }

    public function show(Province $province)
    {
        return view('motel', [
            'province' => new ProvinceResource($province),
        ]);
    }

    public function edit(Province $province)
    {
        return view('motel', [
            'province' => new ProvinceResource($province),
        ]);
    }

    public function update(UpdateProvinceRequest $request, Province $province)
    {
        $data = $request->all();
        $province->update($data);
        return redirect()->route('province.index');
    }

    public function destroy(Province $province)
    {
        $province->delete();
        return redirect()->route('province.index');
    }
}
