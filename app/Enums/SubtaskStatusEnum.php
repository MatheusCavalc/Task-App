<?php

namespace App\Enums;

enum SubtaskStatusEnum: string {

    case Waiting = 'Waiting';
    case In_Progress = 'In Progress';
    case Finished = 'Finished';

    public function getName(): string
    {
        return match ($this)
        {
            self::Waiting => 'Waiting',
            self::In_Progress => 'In Progress',
            self::Finished => 'Finished',
            default => 'Waiting'
        };
    }
}
