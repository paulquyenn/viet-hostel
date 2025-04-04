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
        ];
        return view('components.layouts.side-bar', [
            'menus' => $menus,
            'user' => request()->user(),
        ]);
    }
}
