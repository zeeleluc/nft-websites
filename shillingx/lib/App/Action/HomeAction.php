<?php
namespace App\Action;

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
            'a pig',
            'a 12-year-old boy',
            'a Web3 expert',
            'an NFT expert',
            'a crypto expert',
            'a pixel art expert',
            'a Base chain expert',
            'an XRPL chain expert',
        ];
    }

    private function getRandomMaxChars()
    {
        $options = [
            25,
            50,
            100,
            200,
        ];

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

        return $options[0];
    }

    private function getExamples()
    {
        $question1 = 'Write a fun statement that :subject :couldShould say. Max :chars characters. Return it in a code block for easy copy-pasting. Don\'t add quotes.';
        $question2 = 'Write a fun question that :subject :couldShould ask. Make the question max :chars characters. Give 3 answers. Return the question and answers in separate code blocks for easy copy-pasting. So I want 4 separate code blocks. Don\'t add quotes.';
        $question3 = 'Write a fun question that :subject :couldShould ask. Max :chars characters. Return it in a code block for easy copy-pasting. Don\'t add quotes.';
        $question4 = 'Write a fun statement that :subject :couldShould ask. Max :chars characters. Return it in a code block for easy copy-pasting. Don\'t add quotes.';

        $examples = [];

        foreach ($this->getExampleSubjects() as $subject) {
            $question = $question1;
            $question = str_replace(':subject', $subject, $question);
            $question = str_replace(':couldShould', $this->getRandomWouldOrCould(), $question);
            $question = str_replace(':chars', $this->getRandomMaxChars(), $question);

            $examples[$subject][] = $question;

            $question = $question2;
            $question = str_replace(':subject', $subject, $question);
            $question = str_replace(':couldShould', $this->getRandomWouldOrCould(), $question);
            $question = str_replace(':chars', $this->getRandomMaxChars(), $question);

            $examples[$subject][] = $question;

            $question = $question3;
            $question = str_replace(':subject', $subject, $question);
            $question = str_replace(':couldShould', $this->getRandomWouldOrCould(), $question);
            $question = str_replace(':chars', $this->getRandomMaxChars(), $question);

            $examples[$subject][] = $question;

            $question = $question4;
            $question = str_replace(':subject', $subject, $question);
            $question = str_replace(':couldShould', $this->getRandomWouldOrCould(), $question);
            $question = str_replace(':chars', $this->getRandomMaxChars(), $question);

            $examples[$subject][] = $question;
        }

        return $examples;
    }
}
