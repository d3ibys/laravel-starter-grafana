<?php

    namespace App\Http\Controllers\Auth;

    use App\Http\Controllers\Controller;
    use App\Models\User;
    use App\Providers\RouteServiceProvider;
    use Hans\Horus\Exceptions\HorusException;
    use Hans\Horus\Models\Role;
    use Hans\Sphinx\Contracts\SphinxContract;
    use Illuminate\Foundation\Auth\RegistersUsers;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Validator;

    class RegisterController extends Controller {
        /**
         * Where to redirect users after registration.
         *
         * @var string
         */
        protected $redirectTo = RouteServiceProvider::HOME;
        /*
        |--------------------------------------------------------------------------
        | Register Controller
        |--------------------------------------------------------------------------
        |
        | This controller handles the registration of new users as well as their
        | validation and creation. By default, this controller uses a trait to
        | provide this functionality without requiring any additional code.
        |
        */

        use RegistersUsers;

        private SphinxContract $sphinx;

        public function __construct( SphinxContract $sphinx_contract ) {
            $this->sphinx = $sphinx_contract;
        }

        /**
         * Get a validator for an incoming registration request.
         *
         * @param array $data
         *
         * @return \Illuminate\Contracts\Validation\Validator
         */
        protected function validator( array $data ) {
            return Validator::make( $data, [
                'name'                 => [ 'required', 'string', 'max:255' ],
                User::username()       => [ 'required', 'string', 'email', 'max:255', 'unique:users' ],
                'password'             => [ 'required', 'string', 'min:8', 'confirmed' ],
                'g-recaptcha-response' => env( 'RECAPTCHAV3_ENABLE',
                    false ) ? 'required|recaptchav3:login,0.5' : 'nullable'
            ] );
        }

        /**
         * Create a new user instance after a valid registration.
         *
         * @param array $data
         *
         * @return User
         */
        protected function create( array $data ) {
            return User::create( [
                'name'     => $data[ 'name' ],
                User::username()    => $data[ User::username() ],
                'password' => Hash::make( $data[ 'password' ] ),
                'version'  => 1
            ] );
        }

        /**
         * The user has been registered.
         *
         * @param Request $request
         * @param mixed   $user
         *
         * @return mixed
         * @throws HorusException
         */
        protected function registered( Request $request, User $user ) {
            $user->assignRole( Role::findByName( \RolesEnum::DEFAULT_USERS, \AreasEnum::USER ), true );
            // capture user's session
            $session = capture_session();

            return $request->wantsJson() ? new JsonResponse( [
                'access_token'  => $this->sphinx->session( $session )->create( $user )->accessToken(),
                'refresh_token' => $this->sphinx->createRefreshToken( $user )->refreshToken(),
                'user'          => $user->extract()
            ], 201 ) : redirect( $this->redirectPath() );
        }
    }
