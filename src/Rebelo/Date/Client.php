<?php
/**
 * MIT License
 *
 * Copyright (c) 2019 João M F Rebelo
 */

namespace Rebelo\Date;

/**
 * NTP client
 *
 * This is the main interface for getting
 * the current time from an ntp server.
 * @link https://github.com/bdluk/ntp forked
 * @since 2.2.1
 */
class Client
{
    /**
     * @var \Rebelo\Date\Socket Socket
     */
    protected Socket $socket;

    /**
     * Build a new instance of the ntp client
     *
     * @param \Rebelo\Date\Socket $socket The socket used for the connection
     * @since 2.2.1
     */
    public function __construct(Socket $socket)
    {
        $this->socket = $socket;
    }

    /**
     * Sends a request to the remote ntp server for the current time.
     * if $timezone and \Rebelo\Date\Date::$defaultTimeZone the timezone os set ro UTC
     * 
     * @param \DateTimeZone|null $timezone
     * @return \Rebelo\Date\Date
     * @throws DateNtpException
     * @since 2.2.1
     */
    public function getTime(?\DateTimeZone $timezone = null): \Rebelo\Date\Date
    {
        $packet = $this->buildPacket();
        $this->write($packet);

        $unpackTime = $this->unpack($this->read());
        if (\is_numeric($unpackTime) === false) {
            throw new DateNtpException("failling unpack read stream");
        }

        $time = (int) $unpackTime - 2208988800;

        $this->socket->close();

        $date = new \Rebelo\Date\Date("@$time", new \DateTimeZone('UTC'));

        if ($timezone !== null) {
            $date->setTimezone($timezone);
        } elseif (\Rebelo\Date\Date::$defaultTimeZone !== null) {
            $date->setTimezone(\Rebelo\Date\Date::$defaultTimeZone);
        }

        return $date;
    }

    /**
     * Write a request packet to the remote ntp server
     *
     * @param string $packet The packet to send
     *
     * @return void
     * @since 2.2.1
     */
    protected function write($packet): void
    {
        $this->socket->write($packet);
    }

    /**
     * Reads data returned from the ntp server
     *
     * @return string
     * @since 2.2.1
     */
    protected function read(): string
    {
        return $this->socket->read();
    }

    /**
     * Builds the request packet for the current time
     *
     * @return string
     * @since 2.2.1
     */
    protected function buildPacket(): string
    {
        $packet = \chr(0x1B);
        $packet .= str_repeat(chr(0x00), 47);

        return $packet;
    }

    /**
     * Unpacks the binary data that was returned
     * from the remote ntp server
     * 
     * @param string $binary The binary from the response
     *
     * @return string
     * @since 2.2.1
     */
    protected function unpack($binary): string
    {
        if(false === $data = \unpack('N12', $binary)){
            throw new DateNtpException("No binary data returned from server");
        }
        if (\array_key_exists(9, $data) === false || $data[9] === 0 || $data[9] === null) {
            throw new DateNtpException("wrong binary data returned from server");
        }
        return \sprintf('%u', $data[9]);
    }
}