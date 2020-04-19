<?php

use LoneCat\Framework\Factories\StreamFactory;
use Psr\Http\Message\StreamFactoryInterface;

// CONTAINER
// Aliases
$container->setAlias(StreamFactoryInterface::class, StreamFactory::class);

// Definitions