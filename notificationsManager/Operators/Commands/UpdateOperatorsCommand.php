<?php

namespace NotificationsManager\Operators\Commands;

use Exception;
use Illuminate\Console\Command;
use NotificationsManager\Operators\UpdateOperatorsService;
use Symfony\Component\HttpFoundation\Response;

class UpdateOperatorsCommand extends Command
{
    protected $signature = 'update:operators';
    protected $description = 'Actualiza los datos de los operarios';

    public function __construct(private readonly UpdateOperatorsService $updateOperatorsService)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        try {
            $this->updateOperatorsService->update();
            $this->info(json_encode(['message' => 'Operators updated successfully.'], JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE));
            return 0;
        } catch (Exception $exception) {
            if ($exception->getCode() === Response::HTTP_INTERNAL_SERVER_ERROR) {
                $this->error(json_encode(['message' => $exception->getMessage()], JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE));
            }
            if ($exception->getCode() === Response::HTTP_BAD_REQUEST) {
                $this->error(json_encode(['message' => $exception->getMessage()], JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE));
            }
            return 1;
        }
    }
}
