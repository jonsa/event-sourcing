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

interface DefaultAggregateRootContract
{
    public static function reconstituteFromHistory(Iterator $historyEvents);

    public function getVersion();

    public function getId();

    /**
     * @return Message[]
     */
    public function popRecordedEvents();

    public function replay($event);
}
