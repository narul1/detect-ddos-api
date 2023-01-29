<?php
$server = new \GuzzleHttp\Psr7\ServerRequest('GET', '/');
$handler = function (\Psr\Http\Message\ServerRequestInterface $request) {

    $isDdos = detectDdos($request);
    if ($isDdos) {

        $webhookUrl = 'https://ctxsend.com/';
        $client = new \GuzzleHttp\Client();
        $client->post($webhookUrl, [
            'json' => [
                'content' => 'DDoS attack detected!'
            ]
        ]);
    }
    return new \GuzzleHttp\Psr7\Response();
};

$server = \GuzzleHttp\Server::createServer($handler);
$server->listen();

function detectDdos($request) {
    $ip = $request->getServerParams()['REMOTE_ADDR'];
    $userAgent = $request->getServerParams()['HTTP_USER_AGENT'];
    return true;
}
