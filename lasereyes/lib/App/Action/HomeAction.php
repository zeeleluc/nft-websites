<?php
namespace App\Action;

use App\Collection\NFTs;
use App\Variable;
use Doctrine\DBAL\Driver\Exception;

class HomeAction extends BaseAction
{
    /**
     * @throws Exception
     */
    public function run()
    {
        parent::__construct();

        $this->setLayout('default');
        $this->setView('website/home');

        $memes = $this->getMemes();
        shuffle($memes);

        $this->setVariable(new Variable('memes', array_slice($memes, 0, 16)));
    }

    private function getMemes(): array
    {
        $directory = './assets/images/memes';

        if (!is_dir($directory)) {
            return [];
        }

        $imageFiles = [];

        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        $files = scandir($directory);

        foreach ($files as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            $fileExtension = pathinfo($file, PATHINFO_EXTENSION);

            if (in_array(strtolower($fileExtension), $imageExtensions)) {
                $imageFiles[] = $file;
            }
        }

        return $imageFiles;
    }
}
