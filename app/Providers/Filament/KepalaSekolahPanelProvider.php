<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Filament\Widgets;
use Hardikkhorasiya09\ChangePassword\ChangePasswordPlugin;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\HtmlString;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class KepalaSekolahPanelProvider extends PanelProvider
{
  public function panel(Panel $panel): Panel
  {
    return $panel
      ->id('kepala_sekolah')
      ->path('kepala_sekolah')
      ->colors([
        'primary' => Color::Blue,
      ])
      ->renderHook(
        PanelsRenderHook::USER_MENU_BEFORE,
        fn() => new HtmlString('
                    <span class="px-3 py-1 text-sm font-medium text-primary-600 bg-primary-50 rounded-lg dark:bg-primary-500/10 dark:text-primary-400">
                        Kepala Sekolah
                    </span>
                ')
      )
      ->discoverResources(in: app_path('Filament/KepalaSekolah/Resources'), for: 'App\\Filament\\KepalaSekolah\\Resources')
      ->discoverPages(in: app_path('Filament/KepalaSekolah/Pages'), for: 'App\\Filament\\KepalaSekolah\\Pages')
      ->pages([
        Pages\Dashboard::class,
      ])
      ->discoverWidgets(in: app_path('Filament/KepalaSekolah/Widgets'), for: 'App\\Filament\\KepalaSekolah\\Widgets')
      ->widgets([
        // Widgets\AccountWidget::class,
        // Widgets\FilamentInfoWidget::class,
      ])
      ->middleware([
        EncryptCookies::class,
        AddQueuedCookiesToResponse::class,
        StartSession::class,
        AuthenticateSession::class,
        ShareErrorsFromSession::class,
        VerifyCsrfToken::class,
        SubstituteBindings::class,
        DisableBladeIconComponents::class,
        DispatchServingFilamentEvent::class,
      ])
      ->authMiddleware([
        Authenticate::class,
      ])
      ->plugins([
        ChangePasswordPlugin::make()
      ]);
  }
}
