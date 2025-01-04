<?php

// function readAllFunction(string $address) : string {
function readAllFunction(array $config) : string {
    $address = $config['storage']['address'];

    if (file_exists($address) && is_readable($address)) {
        $file = fopen($address, "rb");
        
        $contents = ''; 
    
        while (!feof($file)) {
            $contents .= fread($file, 100);
        }
        
        fclose($file);
        return $contents;
    }
    else {
        return handleError("Файл не существует");
    }
}

// function addFunction(string $address) : string {
function addFunction(array $config) : string {
    $address = $config['storage']['address'];

    $name = readline("Введите имя: ");
    $date = readline("Введите дату рождения в формате ДД-ММ-ГГГГ: ");
    if (!validateData($date)) {
        return handleError("Неверная дата.");
    }
    $data = $name . ", " . $date . "\r\n";

    $fileHandler = fopen($address, 'a');

    if(fwrite($fileHandler, $data)){
        return "Запись $data добавлена в файл $address" . "\r\n"; 
    }
    else {
        return handleError("Произошла ошибка записи. Данные не сохранены");
    }

    fclose($fileHandler);
}

function delByNameFunction(array $config) : string {
    $address = $config['storage']['address'];

    $name = readline("Введите имя: ");

    if (file_exists($address) && is_readable($address)) {
        $file = fopen($address, "rb");

        $line = '';
        $content = '';
        $result = ''; 
    
        while (!feof($file)) {
            $line = explode(",", fgets($file));
            if (count($line) > 0) {
                if ($line[0] == $name) {
                    $result = $result . implode(",", $line);
                } else {
                    $content = $content . implode(",", $line);
                }
            }
        }

        fclose($file);

        $file = fopen($address, "w");

        fwrite($file, $content);
        fclose($file);

        if (!empty($result)) {
            return $result;
        } else {
            return "Запись не найдена." . "\r\n";
        }
        
    }
    else {
        return handleError("Файл не существует");
    }
}

function delByDateFunction(array $config) : string {
    $address = $config['storage']['address'];

    $date = readline("Введите дату рождения в формате ДД-ММ-ГГГГ: ");

    if (file_exists($address) && is_readable($address)) {
        $file = fopen($address, "rb");
        
        $dateBlocks = explode("-", $date);

        $line = '';
        $content = '';
        $result = ''; 
    
        while (!feof($file)) {
            $line = explode(",", fgets($file));
            if (count($line) > 1) {
                $dateBirthdayBlocks = explode("-", $line[1]);
                if ($dateBirthdayBlocks[0] == $dateBlocks[0] && 
                    $dateBirthdayBlocks[1] == $dateBlocks[1]) {
                    $result = $result . implode(",", $line);
                } else {
                    $content = $content . implode(",", $line);
                }
            }
        }

        fclose($file);

        $file = fopen($address, "w");

        fwrite($file, $content);
        fclose($file);

        if (!empty($result)) {
            return $result;
        } else {
            return "Запись не найдена." . "\r\n";
        }
        
    }
    else {
        return handleError("Файл не существует");
    }
}

// function clearFunction(string $address) : string {
function clearFunction(array $config) : string {
    $address = $config['storage']['address'];

    if (file_exists($address) && is_readable($address)) {
        $file = fopen($address, "w");
        
        fwrite($file, '');
        
        fclose($file);
        return "Файл очищен";
    }
    else {
        return handleError("Файл не существует");
    }
}

function helpFunction() {
    return handleHelp();
}

function readConfig(string $configAddress): array|false{
    return parse_ini_file($configAddress, true);
}

function readProfilesDirectory(array $config): string {
    $profilesDirectoryAddress = $config['profiles']['address'];

    if(!is_dir($profilesDirectoryAddress)){
        mkdir($profilesDirectoryAddress);
    }

    $files = scandir($profilesDirectoryAddress);

    $result = "";

    if(count($files) > 2){
        foreach($files as $file){
            if(in_array($file, ['.', '..']))
                continue;
            
            $result .= $file . "\r\n";
        }
    }
    else {
        $result .= "Директория пуста \r\n";
    }

    return $result;
}

function readProfile(array $config): string {
    $profilesDirectoryAddress = $config['profiles']['address'];

    if(!isset($_SERVER['argv'][2])){
        return handleError("Не указан файл профиля");
    }

    $profileFileName = $profilesDirectoryAddress . $_SERVER['argv'][2] . ".json";

    if(!file_exists($profileFileName)){
        return handleError("Файл $profileFileName не существует");
    }

    $contentJson = file_get_contents($profileFileName);
    $contentArray = json_decode($contentJson, true);

    $info = "Имя: " . $contentArray['name'] . "\r\n";
    $info .= "Фамилия: " . $contentArray['lastname'] . "\r\n";

    return $info;
}

function searchBirthdays(array $config) : string {
    $address = $config['storage']['address'];

    if (file_exists($address) && is_readable($address)) {
        $file = fopen($address, "rb");
        
        $dateCurrent = date("d-m-Y");
        $dateCurrentBlocks = explode("-", $dateCurrent);

        $content = '';
        $result = ''; 
    
        while (!feof($file)) {
            $content = explode(",", fgets($file));
            if (count($content) > 1) {
                $dateBirthdayBlocks = explode("-", $content[1]);
                if ($dateBirthdayBlocks[0] == $dateCurrentBlocks[0] && 
                    $dateBirthdayBlocks[1] == $dateCurrentBlocks[1]) {
                    $result = $result . implode(",", $content);
                }
            }
        }

        fclose($file);

        if (!empty($result)) {
            return $result;
        } else {
            return "Сегодня дней рождений нет." . "\r\n";
        }
        
    }
    else {
        return handleError("Файл не существует");
    }
}