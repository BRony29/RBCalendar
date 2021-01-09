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
        $this->render('main/error404');
    }

}