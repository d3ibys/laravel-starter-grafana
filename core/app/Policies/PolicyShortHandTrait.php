<?php


    namespace App\Policies;


    use Illuminate\Support\Arr;

    trait PolicyShortHandTrait {
        private function getModel(): string {
            return strtolower( substr( $string = Arr::last( explode( '\\', self::class ) ), 0,
                strpos( $string, 'Policy' ) ) );
        }

        private function makeAbility(): string {
            return $this->getModel() . '-' . debug_backtrace()[ 1 ][ 'function' ];
        }
    }
