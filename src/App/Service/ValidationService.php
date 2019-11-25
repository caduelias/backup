<?php

declare(strict_types=1);

namespace App\Service;

class ValidationService
{
    public function validation($object): bool
    {
        if ( empty($object) ) {

        }
 
        return $object;
    }
}