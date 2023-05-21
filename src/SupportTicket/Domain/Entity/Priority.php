<?php

namespace App\SupportTicket\Domain\Entity;

enum Priority: string
{
    case Critical = 'krytyczny';
    case High = 'wysoki';
    case Normal = 'normalny';
}
