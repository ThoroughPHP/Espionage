<?php

namespace ThoroughPHP\Espionage;

final class ObjectUnderSurveillance
{
    /** @var object */
    private $object;

    /** @var Spy */
    private $spy;

    /**
     * ObjectUnderSurveillance constructor.
     * @param object $object
     * @param Spy $spy
     */
    public function __construct(object $object, Spy $spy)
    {
        $this->object = $object;
        $this->spy = $spy;
    }

    public function __call($name, $arguments)
    {
        if (! is_callable([$this->object, $name])) {
            throw new \BadMethodCallException();
        }

        $debugBacktrace = debug_backtrace();
        $caller = array_shift($debugBacktrace);

        $this->spy->registerMethodCall(
            spl_object_hash($this->object),
            $name,
            $arguments,
            $result = $this->object->{$name}(...$arguments),
            $caller['file'],
            $caller['line']
        );

        return $result;
    }
}