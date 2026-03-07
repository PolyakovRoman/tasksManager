<?php
namespace App\Domain\Enum;

enum RoleLevel: string
{
case ADMIN = 'Адмиин';
case USER = 'Обычный пользователь';
}