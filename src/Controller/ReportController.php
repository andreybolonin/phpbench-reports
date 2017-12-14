<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Domain\Store\VariantStore;
use Twig\Environment;
use App\Domain\Report\VariantReport;
use App\Domain\Store\SuiteStore;
use App\Domain\Report\EnvReport;

class ReportController
{
    /**
     * @var VariantStore
     */
    private $variantStore;

    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var SuiteStore
     */
    private $suiteStore;

    public function __construct(VariantStore $variantStore, Environment $twig, SuiteStore $suiteStore)
    {
        $this->variantStore = $variantStore;
        $this->twig = $twig;
        $this->suiteStore = $suiteStore;
    }

    /**
     * @Route("/report/suite/{uuid}", name="report_suite")
     */
    public function suite(Request $request)
    {
        $uuid = $request->attributes->get('uuid');
        $suiteReport = EnvReport::env($this->suiteStore->forSuiteUuid($uuid));
        $variantReport = VariantReport::aggregate($this->variantStore->forSuiteUuid($uuid));

        return new Response($this->twig->render('report/report_suite.html.twig', [
            'uuid' => $uuid,
            'suiteReport' => $suiteReport,
            'variantReport' => $variantReport,
        ]));
    }

    /**
     * @Route("/report/suite/{uuid}/benchmark/{class}", name="report_benchmark")
     */
    public function benchmark(Request $request)
    {
        $uuid = $request->attributes->get('uuid');
        $class = $request->attributes->get('class');
        $variantReport = VariantReport::aggregate(
            $this->variantStore->forSuiteUuidAndBenchmark($uuid, $class)
        );

        return new Response($this->twig->render('report/report_benchmark.html.twig', [
            'uuid' => $uuid,
            'variantReport' => $variantReport,
        ]));
    }
}
