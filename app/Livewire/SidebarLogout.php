<?php

namespace App\Livewire;

use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Facades\Filament;
use Livewire\Component;

class SidebarLogout extends Component implements HasForms, HasActions
{
    use InteractsWithActions;
    use InteractsWithForms;

    public function logoutAction(): Action
    {
        return Action::make('logout')
            ->label('Logout')
            ->icon('heroicon-o-arrow-right-on-rectangle')
            ->color('gray')
            ->requiresConfirmation()
            ->modalHeading('Keluar Aplikasi')
            ->modalDescription('Apakah Anda yakin ingin keluar dari aplikasi?')
            ->modalSubmitActionLabel('Ya, Keluar')
            ->action(function () {
                Filament::auth()->logout();

                session()->invalidate();
                session()->regenerateToken();

                $this->redirect(filament()->getPanel('auth')->getLoginUrl());
            });
    }

    public function render()
    {
        return view('livewire.sidebar-logout');
    }
}
