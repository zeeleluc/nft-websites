<?php
namespace App\Action;

use App\ProjectsEnum;
use App\Query\DoShillQuery;
use App\ShillConfig;
use App\TypesEnum;
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

        $query = new DoShillQuery();
        $shills = $query->getShills(Carbon::now('America/Curacao'));

        $this->setVariable(new Variable('progress', calculateCompletionPercentages($shills, ShillConfig::get())));
        $this->setVariable(new Variable('remaining', calculateRemainingActions($shills, ShillConfig::get())));
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
        $question1 = 'Write a fun statement that :subject :couldShould say. Max :chars characters. Return it in a code block for easy copy-pasting. Don\'t add quotes. End with emoticon :emoticon.';
        $question2 = 'Write a fun question that :subject :couldShould ask. Make the question max :chars characters. Give 3 answers with max. 23 chars. Return the question and answers in separate code blocks for easy copy-pasting. So I want 4 separate code blocks. Don\'t add quotes. Also don\'t add numbers at front of the answers. End the question with emoticon :emoticon.';
        $question3 = 'Write a fun question that :subject :couldShould ask. Max :chars characters. Return it in a code block for easy copy-pasting. Don\'t add quotes. End with emoticon :emoticon.';

        $examples = [];

        foreach ($this->getExampleSubjects() as $project => $subject) {

            $question = $question3;
            $question = str_replace(':subject', $subject, $question);
            $question = str_replace(':couldShould', $this->getRandomWouldOrCould(), $question);
            $question = str_replace(':chars', $this->getRandomMaxChars(), $question);
            $question = str_replace(':emoticon', ProjectsEnum::from($project)->icon(), $question);

            $examples[$project][TypesEnum::QUESTION->value] = $question;

            $question = $question1;
            $question = str_replace(':subject', $subject, $question);
            $question = str_replace(':couldShould', $this->getRandomWouldOrCould(), $question);
            $question = str_replace(':chars', $this->getRandomMaxChars(), $question);
            $question = str_replace(':emoticon', ProjectsEnum::from($project)->icon(), $question);

            $examples[$project][TypesEnum::SHOUT->value] = $question;

            $question = $question2;
            $question = str_replace(':subject', $subject, $question);
            $question = str_replace(':couldShould', $this->getRandomWouldOrCould(), $question);
            $question = str_replace(':chars', $this->getRandomMaxChars(), $question);
            $question = str_replace(':emoticon', ProjectsEnum::from($project)->icon(), $question);

            $examples[$project][TypesEnum::POLL->value] = $question;

            switch ($project) {
                case ProjectsEnum::PIGPUNKS->value: $examples[$project][TypesEnum::GM->value] = 'GM pigs and hoomans 🐽'; break;
                case ProjectsEnum::LOONEYLUKE->value: $examples[$project][TypesEnum::GM->value] = 'GM guys and girls 🧢'; break;
                case ProjectsEnum::HASMINTS->value: $examples[$project][TypesEnum::GM->value] = 'GM web3, enjoy your day, tell your friends it\'s another day to mint 💦'; break;
                case ProjectsEnum::LOADINGPUNKS->value: $examples[$project][TypesEnum::GM->value] = 'GM BM, keep \'em loading! 🔄'; break;
                case ProjectsEnum::NOBASED->value: $examples[$project][TypesEnum::GM->value] = 'GM from No-Based on @base 🟦'; break;
                case ProjectsEnum::RIPPLEPUNKS->value: $examples[$project][TypesEnum::GM->value] = 'Gm Punks on XRPL - keep grinding 👑'; break;
            }

            switch ($project) {
                case ProjectsEnum::PIGPUNKS->value: $examples[$project][TypesEnum::GN->value] = 'GN pigs and hoomans 🐽'; break;
                case ProjectsEnum::LOONEYLUKE->value: $examples[$project][TypesEnum::GN->value] = 'GN and thanks for all the laughs 🧢'; break;
                case ProjectsEnum::HASMINTS->value: $examples[$project][TypesEnum::GN->value] = 'GN web3, tomorrow it\'s another day to mint 💦'; break;
                case ProjectsEnum::LOADINGPUNKS->value: $examples[$project][TypesEnum::GN->value] = 'GN fam, keep \'em loading while you sleep! 🔄'; break;
                case ProjectsEnum::NOBASED->value: $examples[$project][TypesEnum::GN->value] = 'GN from No-Based on @base 🟦'; break;
                case ProjectsEnum::RIPPLEPUNKS->value: $examples[$project][TypesEnum::GN->value] = 'GN Punks on XRPL 👑'; break;
            }

            switch ($project) {
                case ProjectsEnum::PIGPUNKS->value: $examples[$project][TypesEnum::HASHTAG->value] = 'PigPunks 🐽 Pigs with an attitude'; break;
                case ProjectsEnum::LOONEYLUKE->value: $examples[$project][TypesEnum::HASHTAG->value] = 'Looney Luke is a little rebel, just like you were once 🧢'; break;
                case ProjectsEnum::HASMINTS->value: $examples[$project][TypesEnum::HASHTAG->value] = 'HasMints has mints day and night on different chains 💦'; break;
                case ProjectsEnum::LOADINGPUNKS->value: $examples[$project][TypesEnum::HASHTAG->value] = 'LoadingPunks keep \'em loading every day 🔄'; break;
                case ProjectsEnum::NOBASED->value: $examples[$project][TypesEnum::HASHTAG->value] = 'NoBased on @base is the way 🟦'; break;
                case ProjectsEnum::RIPPLEPUNKS->value: $examples[$project][TypesEnum::HASHTAG->value] = 'RipplePunk are The Punks on the XRPL 👑'; break;
            }

        }

        return $examples;
    }
}
