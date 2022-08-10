<?php


namespace Pocket\Routing\Exceptions;


class NotFoundException extends \Exception
{
    public function render()
    {
        return 'Not Found';
    }
}