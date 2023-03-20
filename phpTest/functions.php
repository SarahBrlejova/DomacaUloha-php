<?php

namespace main;

class Menu
{
    private $filePath = "source/headerMenu.json";
    private string $hostname = "localhost";
    private int $port =8889;
    private string $username = "root";
    private  string $password="";
    private string $dbName = "sj-2023";
    private $connection;
    public function __construct(string $host="", int $port=8889, string $user="", string $pass= "" , string $dbName="")
    {
        if(!empty($host)){
            $this -> hostname=$host;
        }
        if(!empty($port)){
            $this -> port=$port;
        }
        if(!empty($user)){
            $this -> username=$user;
        }
        if(!empty($pass)){
            $this -> password=$pass;
        }
        if(!empty($dbName)){
            $this -> dbName=$dbName;
        }
        try {
            $this -> connection = new \PDO("mysql.host=".$this->hostname.";dbname=".$this->dbName.";port=".$this->port);

        } catch (\Exception $exception){
        echo $exception ->getMessage();
        die();
        }
    }

    public function getMenu(string $type): array
    {
        $menu = [];
        $isValid = $this->validateMenuType($type);

        if($isValid) {
            if($type === "header") {
                try {
                    $Hlavicka =[]; //Vytvorenie prazdneho pola
                    $SuborOpen = fopen("source/menu.csv", "r"); //otvorenie
                    $SuborGets = fgetcsv($SuborOpen, 50, ",");// fgetcsv -Načíta riadok zo súboru zadaného deskriptorom a separuje polia CSV
                   //po načítaní vráti pole, ktoré obsahuje tieto položky
                    while($SuborGets != FALSE){
                        $Hlavicka[$SuborGets [0]] = ["path" => $SuborGets[1],"name" => $SuborGets[2]];
                        $SuborGets =fgetcsv($SuborOpen, 50, ",");
                    }
                    $menu = $Hlavicka;
                } catch (\Exception $exception) {
                    //echo $exception->getMessage();
                    $menu = [
                        'home' => [
                            'path' => 'index.php',
                            'name' => 'Domov',
                        ]
                    ];
                }
            }
        }

        return $menu;
    }

    public function printMenu(array $menu)
    {
        foreach ($menu as $key => $menuItem) {
            echo '<li><a href="'.$menuItem['path'].'">'.$menuItem['name'].'</a></li>';
        }
    }

    public function preparePortfolio(int $numberOfRows = 2, int $numberOfCols = 4): array
    {
        $portfolio = [];
        $colIndex = 1;

        for ($i = 1; $i <= $numberOfRows; $i++) {
            for ($j = 1; $j <= $numberOfCols; $j++) {
                $portfolio[$i][] = $colIndex;
                $colIndex++;
            }
        }

        return $portfolio;
    }

    private function validateMenuType(string $menuType): bool
    {
        $validTypes = [
            'header',
            'footer',
            'main'
        ];

        if(in_array($menuType, $validTypes)) {
            return true;
        } else {
            return false;
        }
    }
}