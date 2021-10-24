<!DOCTYPE html>
<html lang="~pl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/style-form.css">
    <link rel="stylesheet" href="CSS/results.css">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <div class="background">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 3200">
                <path fill="#ff7308" fill-opacity="10" d="M0,288L48,282.7C96,277,192,267,288,234.7C384,203,480,149,576,154.7C672,160,768,224,864,250.7C960,277,1056,267,1152,256C1248,245,1344,235,1392,229.3L1440,224L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z">
                </path>
            </svg>
        </div>


        <div class="form-frame">
            <p class="form-header">Proponowani kandydaci</p>
            <p class="form-text">Algorytm przetworzył wprowadzone dane i wybrał kandydatów, którzy najbardziej
                spełniają Twoje oczekiwania.</br>
                Skontaktuj się z nimi.</p>
            <?php


            /*dołączenie pliku*/
            require_once "connect.php";
            $connection = @new mysqli($host, $db_user, $db_password, $db_name); /* @- wycisza bledy php i nie sa wyrzucane na ekran*/

            if ($connection->connect_errno != 0) {
                echo "Error: " . $connection->connect_errno . " Opis: " . $connection->connect_error;
            } else {

                #wczytanie danych z formularza i konwersja funkcja myswli_real_escape_string na dane do MySQL
                $java_level = $_POST['java_level'];
                $java_level_sql = mysqli_real_escape_string($connection, $java_level);

                $cpp_level = $_POST['cpp_level'];
                $cpp_level_sql = mysqli_real_escape_string($connection, $cpp_level);

                $php_level = $_POST['php_level'];
                $php_level_sql = mysqli_real_escape_string($connection, $php_level);

                $js_level = $_POST['js_level'];
                $js_level_sql = mysqli_real_escape_string($connection, $js_level);

                $html_level = $_POST['html_level'];
                $html_level_sql = mysqli_real_escape_string($connection, $html_level);

                $css_level = $_POST['css_level'];
                $css_level_sql = mysqli_real_escape_string($connection, $css_level);

                $lan_name = $_POST['lan_name'];
                $lan_name_sql = mysqli_real_escape_string($connection, $lan_name);
                $lan_level = $_POST['lan_level'];
                $lan_level_sql = mysqli_real_escape_string($connection, $lan_level);


                /*pobranie danych z bazy*/
                $sql = "SELECT * FROM `uzytkownicy` 
               INNER JOIN cpp ON cpp.id_uzytkownika = uzytkownicy.id_uzytkownika 
               INNER JOIN js ON js.id_uzytkownika = uzytkownicy.id_uzytkownika 
               INNER JOIN php ON php.id_uzytkownika = uzytkownicy.id_uzytkownika 
               INNER JOIN html ON html.id_uzytkownika = uzytkownicy.id_uzytkownika 
               INNER JOIN css ON css.id_uzytkownika = uzytkownicy.id_uzytkownika 
               INNER JOIN java ON java.id_uzytkownika = uzytkownicy.id_uzytkownika 
               INNER JOIN jezyki_obce ON uzytkownicy.id_uzytkownika = jezyki_obce.id_uzytkownika WHERE jezyk='angielski' AND jezyki_obce.poziom >= '$lan_level_sql';";


                #var_dump(mysqli_error($connection));


                if (isset($_POST['algorithm'])) {
                    $select1 = $_POST['algorithm'];
                    switch ($select1) {
                        case 'Euklides':
                            echo 'Użytkownicy wybrani algorytmem: Odległość Euklidesowa.<br/>';
                            $result = $connection->query($sql);
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $id_uzytkownika = $row['id_uzytkownika'];
                                    $podobienstwo = sqrt((pow($cpp_level - $row['cpp_poziom'], 2))
                                            + (pow($js_level - $row['js_poziom'], 2))
                                            + (pow($php_level - $row['php_poziom'], 2))
                                            + (pow($html_level - $row['html_poziom'], 2))
                                            + (pow($css_level - $row['css_poziom'], 2))
                                            + (pow($java_level - $row['java_poziom'], 2))
                                    );
                                    $kandydaci[] = array('id' => $id_uzytkownika, 'podobienstwo' => $podobienstwo,   'dane' => $row,);
                                }
                            } else {
                                echo "Przykro nam, ale niestety nie mamy kandydatów, którzy spełnialiby wszystkie Twoje oczekiwania.";
                            }
                            //sortowanie tablicy po wynikach otrzymanych z algorytmu
                            usort($kandydaci, function ($a, $b) {
                                if ($a['podobienstwo'] == $b['podobienstwo']) {
                                    return 0;
                                }
                                if ($a['podobienstwo'] > $b['podobienstwo']) {
                                    return 1;
                                }
                                if ($a['podobienstwo'] < $b['podobienstwo']) {
                                    return -1;
                                }
                            });
                            break;
                        case 'Manhattan':
                            echo 'Użytkownicy wybrani algorytmem: Odległość Manhattan.<br/>';
                            $result = $connection->query($sql);
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $id_uzytkownika = $row['id_uzytkownika'];
                                    $podobienstwo = abs($cpp_level - $row['cpp_poziom'])
                                        + abs($js_level - $row['js_poziom'])
                                        + abs($php_level - $row['php_poziom'])
                                        + abs($html_level - $row['html_poziom'])
                                        + abs($css_level - $row['css_poziom'])
                                        + abs($java_level - $row['java_poziom']);
                                    $kandydaci[] = array('id' => $id_uzytkownika, 'podobienstwo' => $podobienstwo,   'dane' => $row,);
                                }
                            } else {
                                echo "Przykro nam, ale niestety nie mamy kandydatów, którzy spełnialiby wszystkie Twoje oczekiwania.";
                            }
                            //sortowanie tablicy po wynikach otrzymanych z algorytmu
                            usort($kandydaci, function ($a, $b) {
                                if ($a['podobienstwo'] == $b['podobienstwo']) {
                                    return 0;
                                }
                                if ($a['podobienstwo'] > $b['podobienstwo']) {
                                    return 1;
                                }
                                if ($a['podobienstwo'] < $b['podobienstwo']) {
                                    return -1;
                                }
                            });
                            break;
                        case 'Cosinus':
                            echo 'Użytkownicy wybrani algorytmem: Podobieństwo cosinusowe.<br/>';
                            $result = $connection->query($sql);
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $id_uzytkownika = $row['id_uzytkownika'];
                                    $podobienstwo = (($cpp_level * $row['cpp_poziom']) + ($js_level * $row['js_poziom']) + ($php_level * $row['php_poziom']) +
                                        ($html_level * $row['html_poziom']) + ($css_level * $row['css_poziom']) + ($java_level * $row['java_poziom']))
                                        / ((sqrt((pow($cpp_level, 2)) + (pow($js_level, 2)) + (pow($php_level, 2)) + (pow($html_level, 2)) + (pow($css_level, 2)) +
                                            (pow($java_level, 2)))) * sqrt((pow($row['cpp_poziom'], 2)) + (pow($row['js_poziom'], 2)) + (pow($row['php_poziom'], 2)) +
                                            (pow($row['html_poziom'], 2)) + (pow($row['css_poziom'], 2)) + (pow($row['java_poziom'], 2))));
                                    $kandydaci[] = array('id' => $id_uzytkownika, 'podobienstwo' => $podobienstwo,   'dane' => $row,);
                                }
                            } else {
                                echo "Przykro nam, ale niestety nie mamy kandydatów, którzy spełnialiby wszystkie Twoje oczekiwania.";
                            }
                            //sortowanie tablicy po wynikach otrzymanych z algorytmu
                            usort($kandydaci, function ($a, $b) {
                                if ($a['podobienstwo'] == $b['podobienstwo']) {
                                    return 0;
                                }
                                if ($a['podobienstwo'] > $b['podobienstwo']) {
                                    return -1;
                                }
                                if ($a['podobienstwo'] < $b['podobienstwo']) {
                                    return 1;
                                }
                            });
                            break;
                        default:
                            echo 'Błąd nie wybrano żadnego algorytmu<br/>';
                            break;
                    }
                }





                $kandydaci2 = ' ';
                $i = 0;
                $kandydaci2 .=
                    "<div class='grid-cont'>
                    <div class='item'> 
                    <p> 
                    <h3>{$kandydaci[$i]['dane']['imię']} {$kandydaci[$i]['dane']['nazwisko']}</h3>
                    Numer telefonu: {$kandydaci[$i]['dane']['nr_telefonu']}</br></br>
                    Język obcy: {$kandydaci[$i]['dane']['jezyk']} {$kandydaci[$i]['dane']['poziom']}</br></br>
                    C/C++: {$kandydaci[$i]['dane']['cpp_poziom']} </br></br> 
                    Java-Script: {$kandydaci[$i]['dane']['js_poziom']}</br></br> 
                    PHP: {$kandydaci[$i]['dane']['php_poziom']} </br></br> 
                    HTML: {$kandydaci[$i]['dane']['html_poziom']}</br></br> 
                    CSS: {$kandydaci[$i]['dane']['css_poziom']} </br></br> 
                    Java: {$kandydaci[$i]['dane']['java_poziom']}</br></br> 
                    </p>
                    <button class='button' style='color:white;'>Wyślij maila</button>
                    </div>
                    <div class='item'> 
                    <p> 
                    <h3>{$kandydaci[$i + 1]['dane']['imię']} {$kandydaci[$i + 1]['dane']['nazwisko']}</h3>
                    Numer telefonu: {$kandydaci[$i + 1]['dane']['nr_telefonu']}</br></br>
                    Język obcy: {$kandydaci[$i + 1]['dane']['jezyk']} {$kandydaci[$i + 1]['dane']['poziom']}</br></br>
                    C/C++: {$kandydaci[$i + 1]['dane']['cpp_poziom']} </br></br> 
                    Java-Script: {$kandydaci[$i + 1]['dane']['js_poziom']}</br></br> 
                    PHP: {$kandydaci[$i + 1]['dane']['php_poziom']} </br></br> 
                    HTML: {$kandydaci[$i + 1]['dane']['html_poziom']}</br></br> 
                    CSS: {$kandydaci[$i + 1]['dane']['css_poziom']} </br></br> 
                    Java: {$kandydaci[$i + 1]['dane']['java_poziom']}</br></br> 
                    </p>
                    <button class='button' style='color:white;'>Wyślij maila</button>
                    </div>
                    <div class='item'> 
                    <p> 
                    <h3>{$kandydaci[$i + 2]['dane']['imię']} {$kandydaci[$i + 2]['dane']['nazwisko']}</h3>
                    Numer telefonu: {$kandydaci[$i + 2]['dane']['nr_telefonu']}</br></br>
                    Język obcy: {$kandydaci[$i + 2]['dane']['jezyk']} {$kandydaci[$i + 2]['dane']['poziom']}</br></br>
                    C/C++: {$kandydaci[$i + 2]['dane']['cpp_poziom']} </br></br> 
                    Java-Script: {$kandydaci[$i + 2]['dane']['js_poziom']}</br></br> 
                    PHP: {$kandydaci[$i + 2]['dane']['php_poziom']} </br></br> 
                    HTML: {$kandydaci[$i + 2]['dane']['html_poziom']}</br></br> 
                    CSS: {$kandydaci[$i + 2]['dane']['css_poziom']} </br></br> 
                    Java: {$kandydaci[$i + 2]['dane']['java_poziom']}</br></br> 
                    </p>
                    <button class='button' style='color:white;'>Wyślij maila</button>
                    </div>
                    <div class='item'> 
                    <p> 
                    <h3>{$kandydaci[$i + 3]['dane']['imię']} {$kandydaci[$i + 3]['dane']['nazwisko']}</h3>
                    Numer telefonu: {$kandydaci[$i + 3]['dane']['nr_telefonu']}</br></br>
                    Język obcy: {$kandydaci[$i + 3]['dane']['jezyk']} {$kandydaci[$i + 3]['dane']['poziom']}</br></br>
                    C/C++: {$kandydaci[$i + 3]['dane']['cpp_poziom']} </br></br> 
                    Java-Script: {$kandydaci[$i + 3]['dane']['js_poziom']}</br></br> 
                    PHP: {$kandydaci[$i + 3]['dane']['php_poziom']} </br></br> 
                    HTML: {$kandydaci[$i + 3]['dane']['html_poziom']}</br></br> 
                    CSS: {$kandydaci[$i + 3]['dane']['css_poziom']} </br></br> 
                    Java: {$kandydaci[$i + 3]['dane']['java_poziom']}</br></br> 
                    </p>
                    <button class='button' style='color:white;'>Wyślij maila</button>
                    </div>
                    </div>";


                print_r($kandydaci2);

                #print_r($kandydaci);
            }

            ?>



        </div>
    </div>
    <?php

    $connection->close();
    ?>

</body>

</html>