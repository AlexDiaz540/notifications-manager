<?php

namespace NotificationsManager\Operators\Commands;

use Exception;
use Illuminate\Console\Command;
use NotificationsManager\Operators\UpdateOperatorsService;

class UpdateOperators extends Command
{
    protected $signature = 'update:operators';
    protected $description = 'Actualiza los datos de los operarios';

    private UpdateOperatorsService $updateOperatorsService;

    public function __construct(UpdateOperatorsService $updateOperatorsService)
    {
        parent::__construct();
        $this->updateOperatorsService = $updateOperatorsService;
    }

    public function handle(): int
    {
        try {
            $this->updateOperatorsService->update();
            $this->info(json_encode(['message' => 'Operators updated successfully.'], JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE));
            return 0;
        } catch (Exception $exception) {
            if ($exception->getCode() === 500) {
                $this->error(json_encode(['message' => 'Failed to retrieve operators.'], JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE));
            }
            if ($exception->getCode() === 400) {
                $this->error(json_encode(['message' => 'Failed to update operators.'], JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE));
            }
            return 1;
        }
    }
}
