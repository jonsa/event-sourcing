<?php
/**
 * This file is part of the prooph/event-sourcing.
 * (c) 2014-2018 prooph software GmbH <contact@prooph.de>
 * (c) 2015-2018 Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace ProophTest\EventSourcing\Mock;

use Iterator;
use Prooph\Common\Messaging\Message;

final class FaultyAggregateRoot implements DefaultAggregateRootContract
{
    public function getVersion()
    {
        //faulty return
        return 1;
    }

    public static function reconstituteFromHistory(Iterator $historyEvents)
    {
        //faulty method
        return new class() implements DefaultAggregateRootContract {
            public static function reconstituteFromHistory(Iterator $historyEvents)
            {
                return new self();
            }

            public function getVersion()
            {
                return 1;
            }

            public function getId()
            {
                return 'id';
            }

            /**
             * @return Message[]
             */
            public function popRecordedEvents()
            {
                return [];
            }

            /**
             * @param $event
             */
            public function replay($event)
            {
            }
        };
    }

    public function getId()
    {
        //faulty method
        return '0';
    }

    /**
     * @return Message[]
     */
    public function popRecordedEvents()
    {
        //faulty method
        return [];
    }

    public function replay($event)
    {
    }
}
