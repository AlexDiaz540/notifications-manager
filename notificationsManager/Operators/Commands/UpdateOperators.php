<?php

namespace NotificationsManager\Operators\Commands;

use Exception;
use Illuminate\Console\Command;
use NotificationsManager\Operators\GetOperatorService;
use NotificationsManager\Operators\UpdateOperatorsService;

class UpdateOperators extends Command
{
    protected $signature = 'update:operators';
    protected $description = 'Actualiza los datos de los operarios';

    private UpdateOperatorsService $updateOperatorsService;
    private GetOperatorService $getOperatorService;

    public function __construct(UpdateOperatorsService $updateOperatorsService, getOperatorService $getOperatorService)
    {
        parent::__construct();
        $this->updateOperatorsService = $updateOperatorsService;
        $this->getOperatorService = $getOperatorService;
    }

    public function handle(): int
    {
        try {
            $operators = $this->getOperatorService->getOperators();
            $this->updateOperatorsService->update($operators[0]);
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
