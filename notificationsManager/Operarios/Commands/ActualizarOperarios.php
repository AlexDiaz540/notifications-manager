<?php

namespace NotificationsManager\Operarios\Commands;

use Illuminate\Console\Command;

class ActualizarOperarios extends Command
{
    protected $signature = 'notifications:actualizarOperarios';

    protected $description = 'Actualiza los datos de los operarios';

    public function handle(): void
    {
        $this->info("Funciona Correctamente");
    }
}
