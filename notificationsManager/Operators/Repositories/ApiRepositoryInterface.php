<?php

namespace NotificationsManager\Operators\Repositories;

interface ApiRepositoryInterface
{
    public function fetchData(string $url): string;
}
