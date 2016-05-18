<?php

namespace Training\FpcCache\Block;

class DateTimePrivate extends DateTime
{
    public function isScopePrivate()
    {
        return true;
    }
}
