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
use Illuminate\Support\HtmlString;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class OrangTuaPanelProvider extends PanelProvider
{
  public function panel(Panel $panel): Panel
  {
    return $panel
      ->id('orang_tua')
      ->path('orang_tua')
      ->brandName('TK Bina Pertiwi')
      ->colors([
        'primary' => Color::Blue,
      ])
      ->renderHook(
        PanelsRenderHook::USER_MENU_BEFORE,
        fn() => new HtmlString('
                    <span class="px-3 py-1 text-sm font-medium text-primary-600 bg-primary-50 rounded-lg dark:bg-primary-500/10 dark:text-primary-400">
                        Orang Tua
                    </span>
                ')
      )
      ->discoverResources(in: app_path('Filament/OrangTua/Resources'), for: 'App\\Filament\\OrangTua\\Resources')
      ->discoverPages(in: app_path('Filament/OrangTua/Pages'), for: 'App\\Filament\\OrangTua\\Pages')
      ->pages([
        Pages\Dashboard::class,
      ])
      ->discoverWidgets(in: app_path('Filament/OrangTua/Widgets'), for: 'App\\Filament\\OrangTua\\Widgets')
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
