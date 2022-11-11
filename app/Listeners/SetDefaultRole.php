<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\StoreMember;
use App\Repositories\RoleRepository;

class SetDefaultRole
{
    private RoleRepository $roleRepository;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * Handle the event.
     *
     * @param \App\Events\StoreMember  $event
     * @return void
     */
    public function handle(StoreMember $event)
    {
        $this->roleRepository->setDefaultRole($event->getMember());
    }
}
