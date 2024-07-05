<?php

namespace NotificationsManager\Operarios\Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ActualizarOperariosTest extends TestCase
{
    #[Test]
    public function testActualizarOperarios(): void
    {
        $this->artisan('notifications:actualizarOperarios')
            ->expectsOutput('Funciona Correctamente');
    }
}
