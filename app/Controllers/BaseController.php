<?php

declare(strict_types=1);

namespace App\Controllers;

use Twig\Environment;
use App\ApiService;


class BaseController
{
    protected Environment $twig;
    protected ApiService $apiService;

    public function __construct(Environment $twig, ApiService $apiService)
    {
        $this->twig = $twig;
        $this->apiService = $apiService;
    }
}