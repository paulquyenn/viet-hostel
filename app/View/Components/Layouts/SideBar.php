<?php

namespace App\View\Components\Layouts;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SideBar extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $menus = [
            [
                'key' => 'dashboard',
                'name' => 'Trang chủ',
                'route' => 'dashboard',
                'icon' => 'bi bi-house',
            ],
            [
                'key' => 'users',
                'name' => 'Người dùng',
                'route' => 'user.index',
                'icon' => 'bi bi-person',
                'submenus' => [
                    [
                        'name' => 'Danh sách người dùng',
                        'route' => 'user.index',
                    ],
                    [
                        'name' => 'Thêm người dùng',
                        'route' => 'user.create',
                    ],
                ],
            ],
            [
                'key' => 'buildings',
                'name' => 'Tòa nhà',
                'route' => 'building.index',
                'icon' => 'bi bi-building',
                'submenus' => [
                    [
                        'name' => 'Danh sách tòa nhà',
                        'route' => 'building.index',
                    ],
                    [
                        'name' => 'Thêm tòa nhà',
                        'route' => 'building.create',
                    ],
                ],
            ],
            [
                'key' => 'rooms',
                'name' => 'Phòng',
                'route' => 'room.index',
                'icon' => 'bi bi-door-open',
                'submenus' => [
                    [
                        'name' => 'Danh sách phòng',
                        'route' => 'room.index',
                    ],
                    [
                        'name' => 'Thêm phòng',
                        'route' => 'room.create',
                    ],
                ],
            ],
        ];
        return view('components.layouts.side-bar', [
            'menus' => $menus,
            'user' => request()->user(),
        ]);
    }
}
