<?php

namespace RBCalendar\Controllers;

use RBCalendar\Models\EventsModel;

abstract class Controller
{
    /**
     * Envoi des infos collectées à la vue afin d'afficher la page demandée
     *
     * @param string $fichier
     * @param array $datas
     * @return void
     */
    public function render(string $fichier, array $datas1 = [], array $datas2 = [])
    {
        extract($datas1);
        extract($datas2);
        ob_start();
        require_once ROOT . '/RBCalendar/views/header.php';
        $header = ob_get_clean();
        ob_start();
        require_once ROOT . '/RBCalendar/views/' . $fichier . '.php';
        $contenu = ob_get_clean();
        ob_start();
        require_once ROOT . '/RBCalendar/views/footer.php';
        $footer = ob_get_clean();
        require_once ROOT . '/RBCalendar/views/default.php';
    }

}
