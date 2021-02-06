<?php
/**
 * MIT License
 *
 * Copyright (c) 2019 João M F Rebelo
 */

namespace Rebelo\Date;

/**
 * UDP socket wrapper
 *
 * Opens up a udp socket. Reads and
 * writes data to the open socket.
 *
 * @link https://github.com/bdluk/ntp forked
 * @see    http://php.net/manual/en/function.fsockopen.php
 * @since 2.2.1
 */
class Socket
{
    /**
     * @var resource
     */
    protected $resource;

    /**
     * @var string
     */
    protected string $host;

    /**
     * @var int
     */
    protected int $port;

    /**
     * The socket timeout
     * @var int
     */
    public static int $timeout = 2;

    /**
     * Build a new instance of a socket
     *
     * @param string $host    The ntp server url
     * @param int    $port    The port the ntp server is listening on
     * @since 2.2.1
     */
    public function __construct(string $host, int $port = 123)
    {
        $this->host    = $this->resolveAddress($host);
        $this->port    = $port;

        $this->connect();
    }

    /**
     * Write data to the socket
     *
     * @param string $data The data to write
     *
     * @return void
     * @since 2.2.1
     */
    public function write(string $data): void
    {
        \fwrite($this->resource, $data);
    }

    /**
     * Read data from the socket
     *
     * @throws \Rebelo\Date\DateNtpException When the connection timed out
     * @return string
     * @since 2.2.1
     */
    public function read(): string
    {
        $preInfo = $this->getMetadata();

        if (true === $preInfo['timed_out']) {
            throw new DateNtpException('Connection timed out');
        }

        \stream_set_timeout($this->resource, static::$timeout, 0);
        $read = \fread($this->resource, 48);

        $afterInfo = $this->getMetadata();
        
        if (true === $afterInfo['timed_out']) {
            throw new DateNtpException('Connection timed out');
        }

        if ($read === false || empty($read)) {
            throw new DateNtpException('No stream from server');
        }

        return $read;
    }

    /**
     * Closes the socket connection
     *
     * @return void
     * @since 2.2.1
     */
    public function close(): void
    {
        \fclose($this->resource);
        unset($this->resource);
    }

    /**
     * Check if the connection is open
     *
     * @return bool
     * @since 2.2.1
     */
    public function isConnected(): bool
    {
        return \is_resource($this->resource) && !\feof($this->resource);
    }

    /**
     * Gets the full address from the socket
     *
     * @return string|null The address if there is a socket
     * @since 2.2.1
     */
    public function getAddress(): ?string
    {
        if (isset($this->resource) === false) {
            return null;
        }
        if(false === $socket = \stream_socket_get_name($this->resource, false)){
            return null;
        }
        return $socket;
    }

    /**
     * Gets the ip address from the domain name
     *
     * @param string $host The domain name to resolve
     *
     * @return string
     * @since 2.2.1
     */
    protected function resolveAddress(string $host): string
    {
        if (filter_var($host, FILTER_VALIDATE_IP)) {
            return $host;
        }

        $ip = \gethostbyname($host);
        return "udp://{$ip}";
    }

    /**
     * Returns a stream's meta data
     *
     * @return array
     * @since 2.2.1
     */
    protected function getMetadata(): array
    {
        return \stream_get_meta_data($this->resource);
    }

    /**
     * Connect to server
     * @throws \Rebelo\Date\DateNtpException
     * @return void
     * @since 2.2.1
     */
    private function connect(): void
    {
        if (!$this->isConnected()) {
            $resource = \fsockopen(
                $this->host, $this->port, $errno, $errstr, static::$timeout
            );

            if ($resource === false) {
                throw new DateNtpException("Unable to create socket: '{$errno}' '{$errstr}'");
            }

            $this->resource = $resource;
        }
    }
}