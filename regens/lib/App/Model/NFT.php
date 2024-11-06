<?php

namespace App\Model;

class NFT
{
    public ?int $id;
    public array $metadata;

    public function __construct(int $id)
    {
        $this->id = $id;
        $this->metadata = $this->getMetadata($id);
    }

    public function getMetadata(int $id): array
    {
        $metadataUrl = env('CDN_ENDPOINT_METADATA') . $id . '.json';

        $content = file_get_contents($metadataUrl);

        if ($content === false) {
            var_dump("Failed to retrieve metadata for {$id} from {$metadataUrl}");
            exit;
        }

        $decoded = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            var_dump("JSON decoding error for {$id}: " . json_last_error_msg());
            exit;
        }

        return (array) $decoded;
    }

    public function getAttributes(): array
    {
        $attributes = [];

        foreach ($this->metadata['attributes'] as $attribute) {
            $attributes[ltrim($attribute['trait_type'], '_')] = $attribute['value'];
        }

        return $attributes;
    }

    public function getName(): string
    {
        return $this->metadata['name'];
    }

    public function getImage(): string
    {
        $ext = 'png';
        if (in_array($this->id, [2274, 4438, 6038, 6625])) {
            $ext = 'gif';
        } elseif (in_array($this->id, [338])) {
            $ext = 'jpeg';
        }

        return env('CDN_ENDPOINT_IMAGES') . $this->id . '.' . $ext;
    }
}
