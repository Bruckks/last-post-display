<?php

use Psr\Log\LoggerInterface;
use Psr\Log\InvalidArgumentException;
use Psr\Log\LogLevel;

/**
 * Register all actions and filters for the plugin
 *
 * @link       https://github.com/ViktarTsimashkou
 * @since      1.0.0
 *
 * @package    Last_Post_Display
 * @subpackage Last_Post_Display/includes
 */

class Last_Post_Display_Utils
{
    public function __construct()
    {

    }

    public static function getOs()
    {
        return (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') ? 'win' : 'nix';
    }

    public static function separateLine()
    {
        return self::getOs() === 'win' ? '\\' : '/';
    }

    /**
     * Get log directory path
     *
     * @param $dirName
     * @return string
     */
    public static function getLogDirectory($dirName)
    {
        $uploadDir = wp_upload_dir();

        $logDir = $uploadDir['basedir'] . self::separateLine() . $dirName;

        if (!is_dir($logDir)) mkdir($logDir, 0755);

        return $logDir;
    }
    
    /**
     * Get log file path
     *
     * @param $dirName
     * @param $channel
     * @return string
     */
    public static function getLogFinalPath($dirName, $channel)
    {
        return self::getLogDirectory($dirName) . self::separateLine() . self::getLogFileName($channel);
    }

    /**
     * Get hashed channel name
     *
     * @return string
     */
    public static function getLogFileName($channel)
    {
        $dateSuffix = date('Y-m-d', time());
        $hashSuffix = wp_hash($dateSuffix);

        return sprintf('%s-%s-%s.log',
            $channel,
            $dateSuffix,
            $hashSuffix
        );
    }
}
