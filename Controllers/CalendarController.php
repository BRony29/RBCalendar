<?php

namespace RBCalendar\Controllers;

use RBCalendar\Models\EventsModel;
use DateTimeImmutable;
use DateTimeInterface;

class CalendarController extends Controller
{
    public $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
    private $months = ['janvier', 'février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
    public $month;
    public $year;


    /**
     * Constructeur du calendrier
     *
     * @param integer $month Mois à afficher
     * @param integer $year Année à Afficher
     */
    public function __construct(?int $month = null, ?int $year = null)
    {
        if ($month === null || $month < 1 || $month > 12) {
            $month = intval(date('m'));
            $year = intval(date('Y'));
        }
        if ($year === null) {
            $year = intval(date('Y'));
        }
        $this->month = $month;
        $this->year = $year;
    }


    public function index()
    {
        if (isset($_GET) && !empty($_GET)) {
            $params = explode('/', $_GET['p']);
            if (isset($params[2]) && isset($params[3])) {
                $month = $params[2];
                $year = $params[3];
            } else {
                $month = intval(date('m'));
                $year = intval(date('Y'));
            }
            $calendar = new CalendarController($month, $year);
            // définir $start (date de départ) et $end (date de fin)
            $start = $calendar->getStartingDay();
            $start = $start->format('N') === '1' ? $start : $calendar->getStartingDay()->modify('last monday');
            $weeks = $calendar->getWeeks();
            $end = $start->modify('+' . (6 + 7 * ($weeks - 1)) . ' days');
            // chercher les évènements entre $start et $end
            $eventsModel = new EventsModel;
            $eventList = $eventsModel->calendarEvents($start, $end);
            //ranger les événements dans un tableau par date
            $eventListByDay = $this->CalendarEventsByDay($eventList);
            $this->render('calendar/index', compact('calendar'), compact('eventListByDay'));
        }
    }


    /**
     * Indexation du tableau d'évènements par jour
     *
     * @param [type] $eventList
     * @return array
     */
    public function CalendarEventsByDay(array $eventList): array
    {
        $days = [];
        foreach ($eventList as $event) {
            $date = explode(' ', $event->date)[0];
            if (!isset($days[$date])) {
                $days[$date] = [$event];
            } else {
                $days[$date][] = $event;
            }
        }
        return $days;
    }


    /**
     * Retourne le mois en toute lettres en FR et l'année.
     *
     * @return string
     */
    public function toString(): string
    {
        return $this->months[$this->month - 1] . ' ' . $this->year;
    }


    /**
     * Renvoi le nombre de semaine dans le mois
     *
     * @return integer
     */
    public function getWeeks(): int
    {
        $start = $this->getStartingDay();
        $end = $start->modify('+1 month -1 day');
        $startWeek = intval($start->format('W'));
        $endWeek = intval($end->format('W'));
        if ($endWeek === 1) {
            $endWeek = intval($end->modify('-7 days')->format('W')) + 1;
        }
        $weeks =  $endWeek - $startWeek + 1;
        if ($weeks < 0) {
            $weeks = intval($end->format('W')) + 1;
        }
        return $weeks;
    }


    /**
     * Renvoi le premier jour du mois
     *
     * @return DateTimeInterface
     */
    public function getStartingDay(): DateTimeInterface
    {
        return new DateTimeImmutable("{$this->year}-{$this->month}-01");
    }


    /**
     * Est ce que le jour est dans le mois ?
     *
     * @param DateTimeImmutable $date
     * @return boolean
     */
    public function withinMonth(DateTimeImmutable $date): bool
    {
        return $this->getStartingDay()->format('Y-m') === $date->format('Y-m');
    }


    /**
     * Est ce que le jour aujourd'hui ?
     *
     * @param DateTimeImmutable $date
     * @return boolean
     */
    public function currentDay(DateTimeImmutable $date): bool
    {
        return $date->format('Y-m-d') === date('Y-m-d');
    }


    /**
     * Renvoi le mois suivant
     *
     * @return CalendarController
     */
    public function nextMonth(): CalendarController
    {
        $month = $this->month + 1;
        $year = $this->year;
        if ($month > 12) {
            $month = 1;
            $year += 1;
        }
        return new CalendarController($month, $year);
    }


    /**
     * Renvoi le mois précédent
     *
     * @return CalendarController
     */
    public function previousMonth(): CalendarController
    {
        $month = $this->month - 1;
        $year = $this->year;
        if ($month < 1) {
            $month = 12;
            $year -= 1;
        }
        return new CalendarController($month, $year);
    }


    /**
     * Renvoi 6 mois plus tard
     *
     * @return CalendarController
     */
    public function nextSixMonth(): CalendarController
    {
        $month = $this->month + 6;
        $year = $this->year;
        if ($month > 12) {
            $month = $month % 12;
            $year += 1;
        }
        return new CalendarController($month, $year);
    }


    /**
     * Renvoi 6 mois avant
     *
     * @return CalendarController
     */
    public function previousSixMonth(): CalendarController
    {
        $month = $this->month - 6;
        $year = $this->year;
        if ($month < 1) {
            $month = ($month + 12) % 12;
            $year -= 1;
        }
        return new CalendarController($month, $year);
    }
}
