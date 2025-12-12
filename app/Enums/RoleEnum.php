<?php

namespace App\Enums;

enum RoleEnum: string
{
    case ADMIN = 'admin';
    case ARTIST = 'artist';
    case LISTENER = 'listener';
}
