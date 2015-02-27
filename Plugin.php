<?php
/*
 * This file is a part of Mibew Purge History Plugin.
 *
 * Copyright 2015 Dmitriy Simushev <simushevds@gmail.com>.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * @file The main file of Mibew:PurgeHistory plugin.
 */

namespace Mibew\Mibew\Plugin\PurgeHistory;

use Mibew\Database;
use Mibew\EventDispatcher\EventDispatcher;
use Mibew\EventDispatcher\Events;
use Mibew\Thread;

/**
 * The main plugin's file definition.
 */
class Plugin extends \Mibew\Plugin\AbstractPlugin implements \Mibew\Plugin\PluginInterface
{
    /**
     * Class constructor.
     *
     * @param array $config List of the plugin config. The following options are
     * supported:
     *   - "timeout": integer, time in seconds. All threads that was closed more
     *     then the specified time ago will be removed. All messages from the
     *     removed threads will be removed too. The default value is 172800
     *     (two days).
     */
    public function __construct($config)
    {
        parent::__construct($config + array('timeout' => 2*24*60*60));
    }

    /**
     * The plugin does not need extra initialization thus it is always ready to
     * work.
     *
     * @return boolean
     */
    public function initialized()
    {
        return true;
    }

    /**
     * The main entry point of a plugin.
     */
    public function run()
    {
        $dispatcher = EventDispatcher::getInstance();
        $dispatcher->attachListener(Events::CRON_RUN, $this, 'purgeHistory');
    }

    /**
     * Remove old threads and messages.
     */
    public function purgeHistory()
    {
        $db = Database::getInstance();

        // Remove old threads
        $db->query(
            ('DELETE FROM {thread} '
                . 'WHERE (istate = :state_closed OR istate = :state_left) '
                . 'AND dtmclosed < :time'),
            array(
                ':state_closed' => Thread::STATE_LEFT,
                ':state_left' => Thread::STATE_CLOSED,
                ':time' => (time() - $this->config['timeout']),
            )
        );

        // Remove old messages
        $db->query(
            'DELETE m FROM {message} AS m '
                . 'LEFT OUTER JOIN {thread} AS t ON m.threadid = t.threadid '
                . 'WHERE t.threadid IS NULL'
        );
    }

    /**
     * {@inheritdoc}
     */
    public static function getVersion()
    {
        return '1.0.0';
    }
}
