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
        $user = request()->user();
        $routePrefix = '';

        if ($user && $user->hasRole('admin')) {
            $routePrefix = 'admin.';
        } elseif ($user && $user->hasRole('landlord')) {
            $routePrefix = 'landlord.';
        }

        $menus = [
            [
                'key' => 'dashboard',
                'name' => 'Trang chủ',
                'route' => 'dashboard',
                'icon' => 'bi bi-house',
            ],
        ];

        // Only show user management for admins
        if ($user && $user->hasRole('admin')) {
            $menus[] = [
                'key' => 'users',
                'name' => 'Người dùng',
                'route' => $routePrefix . 'users.index',
                'icon' => 'bi bi-person',
                'submenus' => [
                    [
                        'name' => 'Danh sách người dùng',
                        'route' => $routePrefix . 'users.index',
                    ],
                    [
                        'name' => 'Thêm người dùng',
                        'route' => $routePrefix . 'users.create',
                    ],
                ],
            ];
        }

        // Show building and room management for admins and landlords
        if ($user && ($user->hasRole('admin') || $user->hasRole('landlord'))) {
            $menus[] = [
                'key' => 'buildings',
                'name' => 'Tòa nhà',
                'route' => $routePrefix . 'buildings.index',
                'icon' => 'bi bi-building',
                'submenus' => [
                    [
                        'name' => 'Danh sách tòa nhà',
                        'route' => $routePrefix . 'buildings.index',
                    ],
                    [
                        'name' => 'Thêm tòa nhà',
                        'route' => $routePrefix . 'buildings.create',
                    ],
                ],
            ];

            $menus[] = [
                'key' => 'rooms',
                'name' => 'Phòng',
                'route' => $routePrefix . 'rooms.index',
                'icon' => 'bi bi-door-open',
                'submenus' => [
                    [
                        'name' => 'Danh sách phòng',
                        'route' => $routePrefix . 'rooms.index',
                    ],
                    [
                        'name' => 'Thêm phòng',
                        'route' => $routePrefix . 'rooms.create',
                    ],
                ],
            ];

            $menus[] = [
                'key' => 'bookings',
                'name' => 'Đặt phòng',
                'route' => $routePrefix . 'bookings.index',
                'icon' => 'bi bi-calendar-check',
                'submenus' => [
                    [
                        'name' => 'Danh sách đặt phòng',
                        'route' => $routePrefix . 'bookings.index',
                    ],
                ],
            ];

            $menus[] = [
                'key' => 'contracts',
                'name' => 'Hợp đồng',
                'route' => $routePrefix . 'contracts.index',
                'icon' => 'bi bi-file-earmark-text',
                'submenus' => [
                    [
                        'name' => 'Danh sách hợp đồng',
                        'route' => $routePrefix . 'contracts.index',
                    ],
                ]
            ];

            $menus[] = [
                'key' => 'tenants',
                'name' => 'Người thuê',
                'route' => $routePrefix . 'tenants.index',
                'icon' => 'bi bi-people',
                'submenus' => [
                    [
                        'name' => 'Danh sách người thuê',
                        'route' => $routePrefix . 'tenants.index',
                    ],
                ]
            ];
        }

        return view('components.layouts.side-bar', [
            'menus' => $menus,
            'user' => request()->user(),
        ]);
    }
}
