<?php

    namespace App\Providers;

    use App\Models\Core\User;
    use App\Policies\Core\UserPolicy;
    use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
    use Illuminate\Support\Facades\Gate;

    class AuthServiceProvider extends ServiceProvider {
        /**
         * The policy mappings for the application.
         *
         * @var array<class-string, class-string>
         */
        protected $policies = [
            User::class => UserPolicy::class,
        ];

        /**
         * Register any authentication / authorization services.
         *
         * @return void
         */
        public function boot() {
            $this->registerPolicies();

            //
        }
    }
