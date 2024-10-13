<?php
namespace App\Action;

use App\Variable;

class CommunityAction extends BaseAction
{
    public function run()
    {
        parent::__construct();

        $this->setLayout('default');
        $this->setView('website/community');

        $this->setVariable(new Variable('fanArtImages', $this->getAllFanArt()));
        $this->setVariable(new Variable('memes', $this->getAllMemes()));
    }

    private function getAllMemes(): array
    {
        $baseDir = '../nobased/assets/images/memes';

        return $this->getImages($baseDir, $baseDir);
    }

    private function getAllFanArt(): array
    {
        $baseDir = '../nobased/assets/images/fanart';

        return $this->getImages($baseDir, $baseDir);
    }

    private function getImages($dir, $baseDir = ''): array
    {
        $images = [];
        $files = scandir($dir);

        foreach ($files as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            $fullPath = $dir . '/' . $file;

            if (is_dir($fullPath)) {
                $images = array_merge($images, $this->getImages($fullPath, $baseDir));
            } elseif (is_file($fullPath)) {
                $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));

                if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                    $relativePath = str_replace($baseDir . '/', '', $fullPath);
                    $images[] = $relativePath;
                }
            }
        }

        shuffle($images);

        return $images;
    }
}
