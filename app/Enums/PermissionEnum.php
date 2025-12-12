<?php

namespace App\Enums;

enum PermissionEnum: string
{
    case VIEW_SONGS = 'view songs';
    case CREATE_SONGS = 'create songs';
    case EDIT_SONGS = 'edit songs';
    case DELETE_SONGS = 'delete songs';
}
