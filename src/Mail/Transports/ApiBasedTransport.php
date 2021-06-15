<?php


namespace Domain\Mail\Transports;

use GuzzleHttp\Client;

abstract class ApiBasedTransport extends Client implements Transportable
{

}