<div>
    <ul class="fi-sidebar-nav-groups flex flex-col gap-y-7">
        <li class="fi-sidebar-nav-group">
            <ul class="fi-sidebar-nav-group-items flex flex-col gap-y-1">
                <x-filament-panels::sidebar.item
                    active="false"
                    icon="heroicon-o-arrow-right-on-rectangle"
                    url="#"
                    wire:click="mountAction('logout')"
                >
                    Logout
                </x-filament-panels::sidebar.item>
            </ul>
        </li>
    </ul>

    @teleport('body')
        <x-filament-actions::modals />
    @endteleport
</div>
