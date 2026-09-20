<?php

use Predis\Client;

class RedisCache
{
    private static $client = null;
    private static $enabled = true;

    public static function getClient()
    {
        if (!self::$enabled) return null;

        if (!class_exists('Predis\Client')) {
            if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
                require_once __DIR__ . '/../vendor/autoload.php';
            }
        }

        if (!class_exists('Predis\Client')) {
            self::$enabled = false;
            return null;
        }

        if (self::$client == null) {
            try {
                self::$client = new Client([
                    'scheme' => 'tcp',
                    'host' => '127.0.0.1',
                    'port' => 6379,
                    'read_write_timeout' => 1,
                    'timeout' => 1,
                ]);
            } catch (\Throwable $e) {
                self::$enabled = false;
                return null;
            }
        }
        return self::$client;
    }

    public static function get($key)
    {
        try {
            $client = self::getClient();
            return $client ? $client->get($key) : null;
        } catch (\Throwable $e) {
            return null;
        }
    }

    public static function set($key, $value, $ttl = 600)
    {
        try {
            $client = self::getClient();
            return $client ? $client->setex($key, $ttl, $value) : null;
        } catch (\Throwable $e) {
            return null;
        }
    }

    public static function delete($key)
    {
        try {
            $client = self::getClient();
            return $client ? $client->del([$key]) : null;
        } catch (\Throwable $e) {
            return null;
        }
    }

    public static function del($key)
    {
        return self::delete($key);
    }

    public static function exists($key)
    {
        try {
            $client = self::getClient();
            return $client ? (bool)$client->exists($key) : false;
        } catch (\Throwable $e) {
            return false;
        }
    }

    public static function keys($pattern)
    {
        try {
            $client = self::getClient();
            return $client ? $client->keys($pattern) : [];
        } catch (\Throwable $e) {
            return [];
        }
    }
}
