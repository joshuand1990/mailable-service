<?php


namespace Domain\Mail\Transports;

use GuzzleHttp\Client;

abstract class ApiTransport extends Client implements Transportable
{

}