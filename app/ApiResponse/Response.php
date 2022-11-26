<?php
namespace App\ApiResponse;
use Exception;

class Response
{
    public bool $isError;
    public int $code;
    public $result;
    public string $message;
    public string $error;
    public array $errorMesages;

    public function __construct(bool $isError)
    {
        $this->isError = $isError;        
    }

    public function makeErrorResponse(string $error, array $errorMesages = [], int $code = 400)
    {
        if($this->isError){
            $this->error = $error;
            $this->errorMesages = $errorMesages;
            $this->code = $code;
            return $this;
        }
        else{
            throw new Exception("Can't create error response at false value for 'isError' field");
        }
    }

    public function makeSuccessResponse($result, string $message = 'ok', int $code = 200)
    {
        if($this->isError){
            throw new Exception("Can't create success response at true value for 'isError' field");
        }
        else{
            $this->result = $result;
            $this->message = $message;
            $this->code = $code;
            return $this;
        }
    }
}



?>