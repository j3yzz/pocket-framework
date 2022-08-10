<?php


namespace Pocket;


class Response
{
    public function setStatusCode(int $code)
    {
        http_response_code($code);
    }
    
    public function render(array $output, int $statusCode): bool|string
    {
        $this->setStatusCode($statusCode);
        return json_encode($output);
    }
}