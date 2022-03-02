<?php

    namespace Database\Factories;

    use Illuminate\Database\Eloquent\Factories\Factory;

    /**
     * @extends Factory
     */
    class PreferenceFactory extends Factory {
        /**
         * Define the model's default state.
         *
         * @return array<string, mixed>
         */
        public function definition() {
            return [
                'key'   => $this->faker->firstNameFemale(),
                'value' => $this->faker->colorName()
            ];
        }

        public function fill( string $key, $value ) {
            return $this->state( [
                'key'   => $key,
                'value' => $value
            ] );
        }
    }
