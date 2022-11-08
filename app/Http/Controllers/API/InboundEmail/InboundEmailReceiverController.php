<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\InboundEmail;

use App\Exceptions\Interfaces\ErrorLogInterface;
use App\Http\Controllers\API\AbstractAPIController;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

final class InboundEmailReceiverController extends AbstractAPIController
{
    private ErrorLogInterface $errorLog;

    public function __construct(ErrorLogInterface $errorLog) {
        $this->errorLog = $errorLog;
    }

    public function __invoke(Request $request): JsonResource
    {
        $this->errorLog->log('test inbound email');
        $from = $request->input("from");
        $to = $request->input("to");
        $body = $request->input("text");

        $result = [
            'from' => $request->input("from"),
            'to' => $request->input("to"),
            'body' => $request->input("body"),
            'test' => $request->all(),
        ];

        $this->errorLog->log(json_encode($result));

        return $this->respondNoContent();
    }
}
