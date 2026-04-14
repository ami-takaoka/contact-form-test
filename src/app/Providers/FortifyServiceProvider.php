<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // 会員登録処理
        Fortify::createUsersUsing(CreateNewUser::class);

        // register画面
        Fortify::registerView(function () {
            return view('auth.register');
        });

        // login画面
        Fortify::loginView(function () {
            return view('auth.login');
        });

        // ログイン試行制限
        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;
            return Limit::perMinute(10)->by($email . $request->ip());
        });

        // Laravel8用 安定認証フロー
        Fortify::authenticateThrough(function () {
            return [
                \Laravel\Fortify\Actions\EnsureLoginIsNotThrottled::class,
                \App\Actions\Fortify\ValidateLogin::class,
                \Laravel\Fortify\Actions\AttemptToAuthenticate::class,
                \Laravel\Fortify\Actions\PrepareAuthenticatedSession::class,
            ];
        });
    }
}