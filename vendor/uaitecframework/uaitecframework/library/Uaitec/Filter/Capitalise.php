<?php

namespace Uaitec\Filter;

use Zend\Filter\FilterInterface;

class Capitalise implements FilterInterface
{

    public function filter($value)
    {
        return ucwords($value);
    }

}