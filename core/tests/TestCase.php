<?php

    namespace Tests;

    use Arr;
    use Hans\Sphinx\Contracts\SphinxContract;
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
    use Illuminate\Foundation\Testing\WithFaker;
    use function app;

    abstract class TestCase extends BaseTestCase {
        use CreatesApplication, RefreshDatabase, WithFaker;

        public SphinxContract $sphinx;
        private array $sphinxConfig;

        /**
         * Setup the test environment.
         *
         * @return void
         */
        protected function setUp(): void {
            parent::setUp();
            $this->sphinx       = app( SphinxContract::class );
            $this->sphinxConfig = config( 'sphinx' );
        }

        public function getConfig( string $key, $default = null ) {
            return Arr::get( $this->sphinxConfig, $key, $default );
        }
    }
