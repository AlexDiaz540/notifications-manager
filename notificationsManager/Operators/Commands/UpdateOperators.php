<?php

namespace NotificationsManager\Operators\Commands;

use Exception;
use Illuminate\Console\Command;
use NotificationsManager\Operators\UpdateOperatorsService;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

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
            if ($exception->getCode() === ResponseAlias::HTTP_INTERNAL_SERVER_ERROR) {
                $this->error(json_encode(['message' => 'Failed to retrieve operators.'], JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE));
            }
            if ($exception->getCode() === ResponseAlias::HTTP_BAD_REQUEST) {
                $this->error(json_encode(['message' => 'Failed to update operators.'], JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE));
            }
            return 1;
        }
    }
}
