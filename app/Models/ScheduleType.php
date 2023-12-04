<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleType extends Model
{
    use HasFactory;
}
/*
Visita
Ligação
Reunião Presencial
Reunião Online
Atividade Pessoal
Lembrete
Evento
Outros

INSERT INTO `schedule_types` (`name`, `order`, bk_color, text_color) VALUES
('Visita', 1, '#007bff', '#ffffff'),
('Ligação', 2, '#343a40', '#ffffff'),
('Reunião Presencial', 3, '#28a745', '#ffffff'),
('Reunião Online', 4, '#ffc107', '#333333'),
('Atividade Pessoal', 5, '#dc3545', '#ffffff'),
('Lembrete', 6, '#17a2b8', '#ffffff'),
('Evento', 7, '#6610f2', '#ffffff'),
('Outros', 8, '#6c757d', '#fff');

*/
