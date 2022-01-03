<?php

namespace App\Controller;

use Nyholm\Psr7\Factory\Psr17Factory;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Tqdev\PhpCrudApi\Api;
use Tqdev\PhpCrudApi\Config;

class ApiController extends AbstractController
{
    /**
     * @Route("/api", name="app_api")
     */
    public function index(Request $symfonyRequest): Response
    {
      $psr17Factory = new Psr17Factory;
      $psrHttpFactory = new PsrHttpFactory($psr17Factory, $psr17Factory, $psr17Factory, $psr17Factory);

      $psrRequest = $psrHttpFactory->createRequest($symfonyRequest);

      $config = new Config([
         'username' => 'username',
         'password' => 'password',
         'database' => 'database',
         'basePath' => '/api'
      ]);

      $api = new Api($config);

      // run the api handle and get the response
      $psrResponse = $api->handle($psrRequest);

      // convert from psrresponse to symfony resopnse
      $httpfoundationFactory = new HttpFoundationFactory();
      $symfonyResponse = $httpfoundationFactory->createResponse($symfonyRequest);
      
      return $symfonyResponse;     
       
    }
}
