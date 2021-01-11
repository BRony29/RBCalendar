<?php

namespace RBCalendar\Controllers;

class MainController extends Controller
{
    public function index()
    {
        header('location: /calendar/index');
        exit;
    }


    public function error404()
    {
        $_SESSION['error'] = 'Erreur 404. Cette page n\'existe pas !';
        header('location: /calendar/index');
    }

}