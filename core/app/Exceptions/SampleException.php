<?php

    namespace App\Exceptions;

    use Symfony\Component\HttpFoundation\Response;

    class SampleException extends BaseException {
        public static function failed() {
            return self::make( 'Failed! please try again later.', BaseErrorCode::FOR_EXAMPLE,
                Response::HTTP_FORBIDDEN );
        }
    }
