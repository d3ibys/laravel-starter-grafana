<?php

    namespace App\Exceptions;

    use Exception;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Support\Facades\Log;
    use Throwable;

    class BaseException extends Exception {
        private int $errorCode;

        public function __construct( string $message = "", int $ErrorCode = 0, int $responseCode = 500, Throwable $previous = null ) {
            parent::__construct( $message, $responseCode, $previous );
            $this->errorCode = $ErrorCode;
        }

        public static function make( string $message = "", int $ErrorCode = 0, int $responseCode = 500, Throwable $previous = null ): self {
            return new self( $message, $ErrorCode, $responseCode, $previous );
        }

        /**
         * Render the exception as an HTTP response.
         *
         * @return JsonResponse
         */
        public function render(): JsonResponse {
            $this->log( [ 'errorCode' => $this->getErrorCode(), 'responseCode' => $this->getCode() ] );

            return new JsonResponse( [
                'title'  => 'Unexpected error!',
                'detail' => $this->getMessage(),
                'code'   => $this->getErrorCode(),
            ], $this->getCode() );
        }

        private function log( array $context = [] ): void {
            Log::channel( 'starter' )->debug( self::class . ' => ' . 'message: ' . $this->getMessage(), $context );
        }

        public function getErrorCode(): int {
            return $this->errorCode;
        }
    }
