<?php

namespace App\Exceptions;

use Exception;

class PlanLimitCrossedException extends Exception
{
    protected $message = "Plan limit exceeded.";
    protected $code    = 509;
    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return response()->json([
            "message"   => $this->getMessage(),
        ], $this->getCode());
    }
}
