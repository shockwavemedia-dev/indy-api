<?php

namespace App\Services\MailChimp\Interfaces;

use MailchimpMarketing\ApiClient;

interface MailChimpClientFactoryInterface
{
    public function make(): ApiClient;
}
