<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Services\InstantUserService;

class UserInfo extends Component
{
    private $service;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->service = new InstantUserService;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $user = $this->service->GetSessionUser();
        $column = $this->service->GetColumns();

        return view('components.user-info', [
            'user' => $user, 
            'column' => $column,
        ]);
    }
}