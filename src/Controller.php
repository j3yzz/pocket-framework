<?php


namespace Pocket;


class Controller extends Response
{
    public function response($data, bool $status, int $statusCode): bool|string
    {
        $response = [
            'data' => $data,
            'status' => $status
        ];

        return $this->render($response, $statusCode);
    }

    public function error($message, bool $status, int $statusCode): bool|string
    {
        $error = [
            'message' => $message,
            'status' => $status
        ];

        return $this->render($error, $statusCode);
    }
}