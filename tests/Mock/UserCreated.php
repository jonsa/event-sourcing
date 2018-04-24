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

use Prooph\EventSourcing\AggregateChanged;

class UserCreated extends AggregateChanged
{
    public function userId()
    {
        return $this->payload['id'];
    }

    public function name()
    {
        return $this->payload['name'];
    }
}
