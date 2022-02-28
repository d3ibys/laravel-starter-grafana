<?php

    namespace Database\Seeders;

    use Illuminate\Database\Seeder;

    class DatabaseSeeder extends Seeder {
        /**
         * Seed the application's database.
         *
         * @return void
         * @throws \Throwable
         */
        public function run() {
            $this->call( [
                RoleAndPermissionSeeder::class,
                UserSeeder::class,
                PreferenceSeeder::class,

            ] );
        }
    }
