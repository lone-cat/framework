<?php

namespace LoneCat\Framework\HTTP;

use Psr\Http\Message\ResponseInterface;

class Emitter
{

    public function emit(ResponseInterface $response)
    {
        $this->emitHeaders($response);
        $this->emitBody($response);
    }

    protected function emitHeaders(ResponseInterface $response)
    {
        header('HTTP/' . $response->getProtocolVersion() . ' ' . $response->getStatusCode() . ' ' . $response->getReasonPhrase());
        foreach ($response->getHeaders() as $header_name => $header_value) {
            header($header_name . ':' . $response->getHeaderLine($header_name));
        }
    }

    protected function emitBody(ResponseInterface $response)
    {
        $stream = $response->getBody();
        $stream->rewind();
        while (!$stream->eof()) {
            echo $stream->read(2048);
        }

        //if ($this->response->getStatusCode() < 500)
        //echo is_string($this->response->getBody()) ? $this->response->getBody() : json_encode($this->response->getBody());
    }

}