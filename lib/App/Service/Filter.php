<?php
namespace App\Service;

use App\Model\NFT;

class Filter
{
    public static function parse(string $string): array
    {
        $filters = [];

        $chunks = explode(';', ltrim($string,';'));
        foreach ($chunks as $chunk) {
            $partialChunks = explode('=', $chunk);
            $filters[$partialChunks[0]] = $partialChunks[1];
        }

        return $filters;
    }

    public static function validate(array $filters): bool
    {
        $reflector = new \ReflectionClass(NFT::class);
        $validProperties = array_diff(
            array_map(fn($prop) => $prop->getName(), $reflector->getProperties()),
            ['id', 'nft_id']
        );

        foreach (array_keys($filters) as $key) {
            if (!in_array($key, $validProperties, true)) {
                return false;
            }
        }

        return true;
    }

    public static function queryHasFilter(string $string, string $trait): bool
    {
        return array_key_exists($trait, self::parse($string));
    }
}
