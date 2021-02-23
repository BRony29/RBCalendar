<?php

namespace RBCalendar\Controllers;

use RBCalendar\Models\EventsModel;

class EventsController extends Controller
{
    public function index()
    {
            $params = explode('/', $_GET['p']);
            if (isset($params[2]) && $params[2] > 1) {
                $params[2] = intval($params[2]);
            } else {
                $params[2] = 1;
            }
        $eventsModel = new EventsModel;
        $fullEventsList = $eventsModel->findAllDateDesc();
        $eventsList = array_slice($fullEventsList, 10 * $params[2] - 10, 10);
        $this->render('events/index', compact('eventsList'));
        exit;
    }


    /**
     * Ajouter un évènement
     *
     * @return void
     */
    public function addEvents()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (
                isset($_POST['honeyPot']) && empty($_POST['honeyPot'])
                && isset($_POST['date']) && !empty($_POST['date'])
                && isset($_POST['hour']) && !empty($_POST['hour'])
                && isset($_POST['title']) && !empty($_POST['title'])
                && isset($_POST['location']) && !empty($_POST['location'])
                && isset($_POST['description']) && !empty($_POST['description'])
            ) {
                if (!isset($_POST['bg_color'])) {
                    $bg_color = "#FFFFFF";
                } elseif (isset($_POST['bg_color']) && empty($_POST['bg_color'])) {
                    $bg_color = "#FFFFFF";
                } else {
                    $bg_color = htmlspecialchars(strip_tags($_POST['bg_color']));
                }
                $date = htmlspecialchars(strip_tags($_POST['date']));
                $hour = htmlspecialchars(strip_tags($_POST['hour']));
                $dateTemp = explode('/', $date);
                if ($hour == '24:00') {
                    $hour = '23:59:59';
                }
                $date = $dateTemp[2] . '-' . $dateTemp[1] . '-' . $dateTemp[0] . ' ' . $hour;
                $eventsModel = new EventsModel;
                $donnees = [
                    'date' => $date,
                    'title' => htmlspecialchars(strip_tags($_POST['title'])),
                    'location' => htmlspecialchars(strip_tags($_POST['location'])),
                    'description' => htmlspecialchars(strip_tags($_POST['description'])),
                    'bg_color' => $bg_color
                ];
                $event = $eventsModel->hydrate($donnees);
                $event->create($event);
                unset($_SESSION['error']);
                if (isset($_SESSION['redirect']) && !empty($_SESSION['redirect'])) {
                    header('location: ' . $_SESSION['redirect']);
                    exit;
                }
                header('location: /calendar/index/' . $dateTemp[1] . '/' . $dateTemp[2]);
                exit;
            }
            if (isset($_SESSION['redirect']) && !empty($_SESSION['redirect'])) {
                $_SESSION['error'] = 'Veuillez remplir tous les champs';
                header('location: ' . $_SESSION['redirect']);
                exit;
            } else {
                header('location: /calendar/index');
                exit;
            }
        }
        if (isset($_SESSION['redirect']) && !empty($_SESSION['redirect'])) {
            $_SESSION['error'] = 'Suite à une erreur, votre nouvel évènement n\'a pas été pris en compte. Veuillez réessayer.';
            header('location: ' . $_SESSION['redirect']);
            exit;
        } else {
            header('location: /calendar/index');
            exit;
        }
    }


    /**
     * Supprimer un évènement
     *
     * @return void
     */
    public function deleteEvents()
    {
        if (
            $_SERVER['REQUEST_METHOD'] == 'POST'
            && isset($_POST['deleteIdEvent']) && !empty($_POST['deleteIdEvent'])
            && isset($_POST['honeyPot']) && empty($_POST['honeyPot'])
        ) {
            if (isset($_POST['deleteCheck']) && $_POST['deleteCheck'] == 'on') {
                if (!$this->verifEventExist($_POST['deleteIdEvent'])) {
                    $_SESSION['error'] = 'Cet évènement n\'existe pas !';
                    header('location: /calendar/index');
                    exit;
                }
                $eventsModel = new EventsModel;
                $traitement = $eventsModel->delete($_POST['deleteIdEvent']);
                ($_SESSION['error'] = '');
            }
        }
        if (isset($_SESSION['redirect']) && !empty($_SESSION['redirect'])) {
            header('Location: ' . $_SESSION['redirect']);
            exit;
        } else {
            header('location: /calendar/index');
            exit;
        }
    }


    /**
     * Modifier un évènement
     *
     * @return void
     */
    public function modifyEvents()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['honeyPot']) && empty($_POST['honeyPot'])) {
                if (
                    isset($_POST['date']) && !empty($_POST['date'])
                    && isset($_POST['hour']) && !empty($_POST['hour'])
                    && isset($_POST['title']) && !empty($_POST['title'])
                    && isset($_POST['description']) && !empty($_POST['description'])
                    && isset($_POST['id']) && !empty($_POST['id'])
                    && isset($_POST['location']) && !empty($_POST['location'])
                ) {
                    if (!$this->verifEventExist($_POST['id'])) {
                        $_SESSION['error'] = 'Cet évènement n\'existe pas !';
                        header('location: /calendar/index');
                        exit;
                    }
                    if (!isset($_POST['bg_color'])) {
                        $bg_color = "#FFFFFF";
                    } elseif (isset($_POST['bg_color']) && empty($_POST['bg_color'])) {
                        $bg_color = "#FFFFFF";
                    } else {
                        $bg_color = htmlspecialchars(strip_tags($_POST['bg_color']));
                    }
                    $date = htmlspecialchars(strip_tags($_POST['date']));
                    $hour = htmlspecialchars(strip_tags($_POST['hour']));
                    if ($hour == '24:00:00') {
                        $hour = '23:59:59';
                    }
                    $dateTemp = explode('/', $date);
                    $date = $dateTemp[2] . '-' . $dateTemp[1] . '-' . $dateTemp[0] . ' ' . $hour;
                    $donnees = [
                        'date' => $date,
                        'title' => htmlspecialchars(strip_tags($_POST['title'])),
                        'location' => htmlspecialchars(strip_tags($_POST['location'])),
                        'description' => htmlspecialchars(strip_tags($_POST['description'])),
                        'bg_color' => $bg_color
                    ];
                    $eventsModel = new EventsModel;
                    $evenement = $eventsModel->hydrate($donnees);
                    $eventsModel->update($_POST['id'], $evenement);
                    if (isset($_SESSION['redirect']) && !empty($_SESSION['redirect'])) {
                        header('Location: ' . $_SESSION['redirect']);
                        exit;
                    } else {
                        header('location: /calendar/index/' . $dateTemp[1] . '/' . $dateTemp[2]);
                        exit;
                    }
                }
                $_SESSION['error'] = 'Veuillez remplir tous les champs.';
                header('location: /calendar/index');
                exit;
            }
            $_SESSION['error'] = 'La mise à jour à échouée.';
            header('location: /calendar/index');
            exit;
        }
        $_SESSION['error'] = 'La mise à jour à échouée.';
        header('location: /calendar/index');
        exit;
    }


    /**
     * vérification qu'un event existe dans la table events
     *
     * @param integer $id ID de l'event à rechercher
     * @return bool
     */
    public function verifEventExist(int $id)
    {
        $eventsModel = new EventsModel;
        $resultat = $eventsModel->findBy(['id' => $id]);
        if (count($resultat) == 1) {
            return true;
        } else {
            return false;
        }
    }
}
