<?php
declare(strict_types=1);

namespace App\Controllers;

class CoinsController extends BaseController
{
    /**
     * @throws \Twig\Error\SyntaxError
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\LoaderError
     * @throws \Exception
     */
    public function index(): void
    {
        $searchQuery = $_POST['search'] ?? null;

        if ($searchQuery !== null) {
            $coinRates = $this->apiService->searchCoins($searchQuery);
        } else {
            $coinRates = $this->apiService->fetchCoins();
        }

        $this->twig->addGlobal('coinRates', $coinRates);
        echo $this->twig->render('index.twig');
    }

}