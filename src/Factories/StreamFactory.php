<?php

namespace LoneCat\Framework\Factories;

use Exception;
use LoneCat\PSR7\Stream\Stream;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;

class StreamFactory
    implements StreamFactoryInterface
{

    public function createStream(string $content = ''): StreamInterface
    {
        $stream_resource = fopen('php://temp', 'rb+');
        $stream = new Stream($stream_resource);
        if ($content)
            $stream->write($content);
        return $stream;
    }

    public function createStreamFromFile(string $filename, string $mode = 'r'): StreamInterface
    {
        if (!file_exists($filename))
            throw new Exception('No file "' . $filename . '"');

        return new Stream(fopen('file://' . $filename, $mode));
    }

    public function createStreamFromResource($resource): StreamInterface
    {
        if (!is_resource($resource) || get_resource_type($resource) !== 'stream')
            throw new Exception('Not a stream resource given!');

        return new Stream($resource);
    }

    public function createStreamFromInput(): StreamInterface
    {
        return new Stream(fopen('php://input', 'rb'));
    }
}