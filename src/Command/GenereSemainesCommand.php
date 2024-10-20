<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpKernel\KernelInterface;

#[AsCommand(
    name: 'app:genere-semaines',
    description: 'Génère les semaines de septembre à juillet et crée des fichiers JSON',
)]
class GenereSemainesCommand extends Command
{
    private string $directory;
    private array $holidays;

    private const TAB_JOUR = [
        'Monday' => 'Lundi',
        'Tuesday' => 'Mardi',
        'Wednesday' => 'Mercredi',
        'Thursday' => 'Jeudi',
        'Friday' => 'Vendredi',
    ];

    public function __construct(KernelInterface $kernel)
    {
        $this->directory = $kernel->getProjectDir();

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Génère les semaines de septembre à juillet et crée des fichiers JSON');
        // parametre pour avoir la date du lundi de départ
        $this->addOption('start-date', null, InputOption::VALUE_REQUIRED, 'Date de début');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        // récupération de la date de début
        $startDate = $input->getOption('start-date') ? new \DateTime($input->getOption('start-date')) : new \DateTime('first monday of september this year');

        $endDate = new \DateTime('first monday of july next year');
        $currentDate = clone $startDate;
        dump($currentDate);
        $numSemaines = 1;
        $this->holidays = $this->getHolidays($startDate->format('Y'));

        while ($currentDate < $endDate) {
            $weekData = $this->generateWeekData($currentDate, $numSemaines);
            dump($weekData);
            $this->saveWeekData($weekData, $currentDate, $numSemaines);
            $currentDate->modify('+1 week');
            $numSemaines++;
        }

        $io->success('Les fichiers JSON des semaines ont été générés avec succès.');

        return Command::SUCCESS;
    }

    private function generateWeekData(\DateTime $startDate): array
    {
        $weekData = [];
        $jours = [];
        for ($i = 0; $i < 5; $i++) {
            $date = (clone $startDate)->modify("+$i day");
            $jours[self::TAB_JOUR[$date->format('l')]] = $date->format('d/m/Y');
            $weekData[] = [
                'day' => self::TAB_JOUR[$date->format('l')],
                'date' => $date->format('Y-m-d'),
                'dateFr' => $date->format('d/m/Y'),
                'isHoliday' => in_array($date->format('Y-m-d'), $this->holidays),
            ];
        }

        return [
            'jours' => $jours,
            'days' => $weekData
        ];
    }

    private function saveWeekData(array $weekData, \DateTime $startDate, int $numSemaine): void
    {
        //vérifier si le dossier existe
        if (!is_dir($this->directory . '/public/semaines')) {
            mkdir($this->directory . '/public/semaines');
        }


        // parcourir les jours de la semaine et ajouter des restrictions si c'est un jour férié
        $restrictedSlots = [];
        foreach ($weekData['days'] as $day) {
            if ($day['isHoliday']) {
                $restrictedSlots = $this->addRestrictedSlot($day['day']);
            }
        }

        $data = [
            "week" => $numSemaine,
            "restrictedSlots" => $restrictedSlots,
        ];

        $data = array_merge($data, $weekData);

        $filename = sprintf($this->directory . '/public/semaines/semaine_%s.json', $numSemaine);
        file_put_contents($filename, json_encode($data, JSON_PRETTY_PRINT));
    }

    private function addRestrictedSlot(string $day): array
    {
//        $restrictedSlots = [];
//        $slots = [
//            '8h00',
//            '9h30',
//            '11h00',
//            '12h30',
//            '14h00',
//            '15h30',
//            '17h00',
//        ];

//        foreach ($slots as $slot) {
        $restrictedSlots['all'][] = [
            'type' => 'full-day',
            'motif' => 'Jour férié',
            'days' => [$day],
        ];
//        }

        return $restrictedSlots;
    }

    private function getHolidays(int $year): array
    {

        // génération des jours fériés

        $year1 = $year + 1; // second "semestre"

        $easter = easter_date($year1, CAL_FRENCH); // paque (dimanche)
        $easterDay = (int)date('j', $easter);
        $easterMonth = (int)date('n', $easter);
        $easterYear = (int)date('Y', $easter);

        $lundiPaque = mktime(0, 0, 0, $easterMonth, $easterDay + 1, $easterYear);
        $jeudiAscension = mktime(0, 0, 0, $easterMonth, $easterDay + 39, $easterYear);
        $lundiPentecote = mktime(0, 0, 0, $easterMonth, $easterDay + 50, $easterYear);

        return [
            $year . '-11-01', // toussaints
            $year . '-11-11', // armistice
            $year . '-12-25', // noel
            $year1 . '-01-01', // jour de l'an
            $year1 . '-05-01', // fete du travail
            $year1 . '-05-08', // victoire
            $year1 . '-07-14', // fete nationale
            $year1 . '-08-15', // assomption
            date('Y-m-d', $easter), // dimanche de pâque
            date('Y-m-d', $lundiPaque), // lundi de pâque
            date('Y-m-d', $jeudiAscension), // jeudi ascension
            date('Y-m-d', $lundiPentecote), // lundi de pentecote
        ];
    }
}
