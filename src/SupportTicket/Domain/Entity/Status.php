<?php

namespace App\SupportTicket\Domain\Entity;

enum Status: string
{
    case Planned = 'zaplanowano';
    case New = 'nowy';
}
