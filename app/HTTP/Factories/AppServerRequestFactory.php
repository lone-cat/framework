<?php

namespace app\HTTP\Factories;

use LoneCat\Framework\HTTP\Factories\ServerRequestFactory;
use LoneCat\PSR11\ContainerAware\ContainerAwareTrait;
use LoneCat\PSR11\ContainerAware\ContanerAwareInterface;
use LoneCat\PSR7\HTTP\Headers\HeadersList;
use LoneCat\PSR7\HTTP\UploadedFiles\UploadedFile;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;

class AppServerRequestFactory
    extends ServerRequestFactory
    implements ContanerAwareInterface
{
    use ContainerAwareTrait;

    protected const SERVER_HTTP_VERSION = '2';

    public function generateServerRequestFromGlobals(): ServerRequestInterface {
        $headers = new HeadersList(getallheaders());

        $uri = $this->getUriFromParams(
            $_SERVER['REQUEST_SCHEME'],
            $headers->getHeaderLine('Host'),
            $_SERVER['REQUEST_URI']);

        $method = $this->getMethodFromServerParams($_SERVER);

        $body = $this->container->get(StreamFactoryInterface::class)
                                ->createStreamFromInput();

        $uploaded_files = $this->getFilesInfoFromArray($_FILES);
        $cookies = $_COOKIE;
        $query_params = $_GET;
        $parsed_body = $_POST;

        $server_request = $this->createServerRequest($method, $uri, $_SERVER);

        foreach ($headers->getHeaders() as $header_name => $header_value) {
            $server_request = $server_request->withHeader($header_name, $header_value);
        }

        return $server_request->withBody($body)
                              ->withProtocolVersion(self::SERVER_HTTP_VERSION)
                              ->withUploadedFiles($uploaded_files)
                              ->withCookieParams($cookies)
                              ->withQueryParams($query_params)
                              ->withParsedBody($parsed_body)
        ;
    }

    protected function getUriFromParams(string $scheme, string $host, string $request_uri)
    {
        $uri = $host
            ? ($scheme ? $scheme . ':' : '') . '//' . $host
            : '';
        $uri .= $request_uri;

        return ($this->container->get(UriFactoryInterface::class))
            ->createUri($uri)
            ;
    }

    protected function getMethodFromServerParams(array $server_params)
    {
        return isset($server_params['REQUEST_METHOD'])
            ? mb_strtoupper($server_params['REQUEST_METHOD'])
            : 'GET';
    }

    protected function getFilesInfoFromArray(array $denormalized_files_arr)
    {
        $normal_file_arr = [];
        foreach ($denormalized_files_arr as $field_name => $field_value) {
            $normal_file_arr[$field_name] = self::filterFileParams($field_value['name'], $field_value['type'], $field_value['tmp_name'], $field_value['error'], $field_value['size']);
        }

        return $normal_file_arr;
    }

    protected function filterFileParams($names, $types, $tmp_names, $errors, $sizes)
    {
        if (is_array($names)) {
            $result = [];
            foreach ($names as $key => $file) {
                $result[$key] = self::filterFileParams($names[$key], $types[$key], $tmp_names[$key], $errors[$key], $sizes[$key],);
            }
            return $result;
        }
        return new UploadedFile($tmp_names, $sizes, $errors, $names, $types);
    }

}