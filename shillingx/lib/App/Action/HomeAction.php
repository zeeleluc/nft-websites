<?php
namespace App\Action;

use App\ProjectsEnum;
use App\Variable;
use Carbon\Carbon;
use Doctrine\DBAL\Driver\Exception;

class HomeAction extends BaseAction
{
    /**
     * @throws Exception
     */
    public function run()
    {
        parent::__construct();

        $this->setVariable(new Variable('examples', $this->getExamples()));

        $this->setLayout('default');
        $this->setView('website/home');
    }

    private function getExampleSubjects()
    {
        return [
            ProjectsEnum::PIGPUNKS->value => 'a pig', // PigPunks
            ProjectsEnum::LOONEYLUKE->value => 'a 12-year-old boy', // Looney Luke
            ProjectsEnum::HASMINTS->value => 'a blockchain/web3 expert', // HasMints
            ProjectsEnum::LOADINGPUNKS->value => 'a pixel art expert', // LoadingPunks
            ProjectsEnum::NOBASED->value => 'a Base chain NFT deployer expert', // No-Based
            ProjectsEnum::RIPPLEPUNKS->value => 'an XRPL chain expert and/or XRPL NFT deployer', // RipplePunks
        ];
    }

    private function getRandomMaxChars()
    {
        $options = [
            25,
            50,
            50,
            50,
            100,
            100,
            100,
            200,
            200,
            200,
        ];

        shuffle($options);
        shuffle($options);

        return $options[0];
    }

    private function getRandomWouldOrCould()
    {
        $options = [
            'could',
            'would',
            'should',
            'will',
            'did',
        ];

        shuffle($options);
        shuffle($options);

        return $options[0];
    }

    private function getExamples()
    {
        $question1 = 'Write a fun statement that :subject :couldShould say. Max :chars characters. Return it in a code block for easy copy-pasting. Don\'t add quotes.';
        $question2 = 'Write a fun question that :subject :couldShould ask. Make the question max :chars characters. Give 3 answers. Return the question and answers in separate code blocks for easy copy-pasting. So I want 4 separate code blocks. Don\'t add quotes.';
        $question3 = 'Write a fun question that :subject :couldShould ask. Max :chars characters. Return it in a code block for easy copy-pasting. Don\'t add quotes.';

        $examples = [];

        foreach ($this->getExampleSubjects() as $project => $subject) {

            $question = $question3;
            $question = str_replace(':subject', $subject, $question);
            $question = str_replace(':couldShould', $this->getRandomWouldOrCould(), $question);
            $question = str_replace(':chars', $this->getRandomMaxChars(), $question);

            $examples[$project]['?'] = $question;

            $question = $question1;
            $question = str_replace(':subject', $subject, $question);
            $question = str_replace(':couldShould', $this->getRandomWouldOrCould(), $question);
            $question = str_replace(':chars', $this->getRandomMaxChars(), $question);

            $examples[$project]['!'] = $question;

            $question = $question2;
            $question = str_replace(':subject', $subject, $question);
            $question = str_replace(':couldShould', $this->getRandomWouldOrCould(), $question);
            $question = str_replace(':chars', $this->getRandomMaxChars(), $question);

            $examples[$project]['Poll'] = $question;
        }

        return $examples;
    }
}
