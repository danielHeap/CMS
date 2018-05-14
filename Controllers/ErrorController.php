<?php 

class ErrorController extends Controller
{
    public function Start()
    {
        System::view("Error404");
    }
}