<?php
    $a = 4;
    $b = 8;
    $c = 0;

// Задание 1.
    function add(float $arg1, float $arg2) : float {
        return $arg1 + $arg2;
    }
    $y = add($a, $b);
    print("{$a} + {$b} = {$y}\n");

    function sub(float $arg1, float $arg2) : float {
        return $arg1 - $arg2;
    }
    $y = sub($a, $b);
    print("{$a} - {$b} = {$y}\n");

    function mult(float $arg1, float $arg2) : float {
        return $arg1 * $arg2;
    }
    $y = mult($a, $b);
    print("{$a} * {$b} = {$y}\n");

    function div(float $arg1, float $arg2) {
        return ($arg2 == 0) ? "Ошибка деления на ноль.\n" : $arg1 / $arg2;
    }
    $y = div($a, $b);
    is_string($y) ? print($y) : print("{$a} : {$b} = {$y}\n");
    $y = div($a, $c);
    is_string($y) ? print($y) : print("{$a} : {$b} = {$y}\n");

// Задание 2.
    function mathOperation(float $arg1, float $arg2, string $operation) {
        switch ($operation) {
            case "+":
                return add($arg1, $arg2);
                break;
            case "-":
                return sub( $arg1, $arg2);
                break;
            case "*":
                return mult($arg1, $arg2);
                break;
            case ":":
                return div($arg1, $arg2);
                break;
            default:
                return "Математическое действие не найдено.\n";
                break;
        }
    }
    $y = mathOperation($a, $b, "+");
    print("{$a} + {$b} = {$y}\n");
    $y = mathOperation($a, $b, "-");
    print("{$a} - {$b} = {$y}\n");
    $y = mathOperation($a, $b, "*");
    print("{$a} * {$b} = {$y}\n");
    $y = mathOperation($a, $b, ":");
    is_string($y) ? print($y) : print("{$a} : {$b} = {$y}\n");
    $y = mathOperation($a, $c, ":");
    is_string($y) ? print($y) : print("{$a} : {$b} = {$y}\n");
    $y = mathOperation($a, $b, "?");
    is_string($y) ? print($y) : print("{$a} : {$b} = {$y}\n");

// Задание 3.
    $result = "";
    $areas = array(
        "Московская область" => ["Москва", "Зеленоград", "Клин"],
        "Ленинградская область" => ["Санкт-Петербург", "Всеволожск", "Павловск", "Кронштадт"],
        "Рязанская область" => ["Рязань", "Михайловс", "Сасово"]
    );
    foreach ($areas as $area => $citys) {
        $result = $result . $area . ":";
        foreach ($citys as $city) {
            $result = $result . " " . $city . ",";
        }
        $result[strlen($result)-1]='.'; 
        $result = $result . "\n";
    }
    print($result);

// Задание 4.
    $result = "";
    $alphabet = [
        'а' => 'a',   'б' => 'b',   'в' => 'v',
        'г' => 'g',   'д' => 'd',   'е' => 'e',
        'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
        'и' => 'i',   'й' => 'y',   'к' => 'k',
        'л' => 'l',   'м' => 'm',   'н' => 'n',
        'о' => 'o',   'п' => 'p',   'р' => 'r',
        'с' => 's',   'т' => 't',   'у' => 'u',
        'ф' => 'f',   'х' => 'h',   'ц' => 'c',
        'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
        'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
        'э' => 'e',   'ю' => 'yu',  'я' => 'ya'
    ];
    $str="Привет мир!";
    $arr = mb_str_split($str);
    foreach ($arr as $ch) {
        if ($ch === mb_strtoupper($ch) && array_key_exists(mb_strtolower($ch), $alphabet)) {
            $result = $result . mb_strtoupper($alphabet[mb_strtolower($ch)]);
        } elseif (array_key_exists($ch, $alphabet)){
            $result = $result . $alphabet[$ch];
        } else {
            $result = $result . $ch;
        }
    }
    print($result . "\n");

// Задание 5.
    function power($val, $pow) {
        if ($pow === 0) {
            return 1;
        }
        return $val * power($val, $pow - 1);
    }
    print(power($a, $b) . "\n")
?>