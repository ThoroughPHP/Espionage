<?php

namespace ThoroughPHP\Espionage;

final class Spy
{
    /** @var array */
    private $protocol;

    public function getProtocol(): array
    {
        return $this->protocol;
    }

    public function spyOn(object $object): ObjectUnderSurveillance
    {
        if (! isset($this->protocol[spl_object_hash($object)])) {
            $this->protocol[spl_object_hash($object)] = [];
            $this->protocol[spl_object_hash($object)]['class'] = get_class($object);
            $this->protocol[spl_object_hash($object)]['calls'] = [];
        }

        return new ObjectUnderSurveillance($object, $this);
    }

    public function registerMethodCall(string $splObjectHash, string $method, array $input, $output, $file, $line): void
    {
        if (! isset($this->protocol[$splObjectHash])) {
            $this->protocol[$splObjectHash] = [];
        }

        $this->protocol[$splObjectHash]['calls'][] = [
            'method' => $method,
            'input' => $input,
            'output' => $output,
            'file' => $file,
            'line' => $line,
        ];
    }
}