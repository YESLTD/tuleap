<?php
/**
 * Copyright (c) Enalean, 2015. All Rights Reserved.
 *
 * This file is a part of Tuleap.
 *
 * Tuleap is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * Tuleap is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Tuleap. If not, see <http://www.gnu.org/licenses/>.
 */

class Git_HTTP_Wrapper {

    /**
     * @var Logger
     */
    private $logger;

    const CHUNK_LENGTH = 8192;

    public function __construct(Logger $logger) {
        $this->logger = $logger;
    }

    public function stream(Git_HTTP_Command $command) {
        $cwd = '/tmp';
        $descriptorspec = array(
           0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
           1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
        );

        if (Config::get('sys_logger_level') == Logger::DEBUG) {
            $descriptorspec[2] = array('file', Config::get('codendi_log').'/git_http_error_log', 'a');
        }

        $pipes = array();
        $this->logger->debug('Command: '.$command->getCommand());
        $this->logger->debug('Environment: '.print_r($command->getEnvironment(), true));
        $process = proc_open($command->getCommand(), $descriptorspec, $pipes, $cwd, $command->getEnvironment());
        if (is_resource($process)) {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                fwrite($pipes[0], file_get_contents('php://input'));
            }
            fclose($pipes[0]);

            $first = true;
            while ($result = stream_get_contents($pipes[1], self::CHUNK_LENGTH)) {
                if ($first) {
                    list($headers, $body) = http_split_header_body($result);
                    foreach(explode("\r\n", $headers) as $header) {
                        header($header);
                    }
                    file_put_contents('php://output', $body);
                } else {
                    file_put_contents('php://output', $result);
                }

                $first = false;
            }
            fclose($pipes[1]);

            $return_value = proc_close($process);
        }
    }
}
