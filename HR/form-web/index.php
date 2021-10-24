<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/style-form.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
    <title>HireIT</title>
</head>

<body>
    <div class="container">


        <div class="background">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 3200">
                <path fill="#ff7308" fill-opacity="10" d="M0,288L48,282.7C96,277,192,267,288,234.7C384,203,480,149,576,154.7C672,160,768,224,864,250.7C960,277,1056,267,1152,256C1248,245,1344,235,1392,229.3L1440,224L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z"></path>
            </svg>
        </div>
        <div class="form-frame">
            <p class="form-header">
                Kogo szukasz?
            </p>
            <p class="form-text">
                Określ poziom znajomości podanych technologii.<br>
                Algorytm przedstawi Ci kandydatów najbardziej pasujących do Twoich oczekiwań.
            </p>
            <form class="form" action="main.php" method="post">
                <div class="form-inputs">
                    <label name="technology1_name">JAVA:<span style="color: rgb(226, 6, 6);">*</span></label><br>
                    <input class="form-field" type="range" name="java_level"><br><br>
                    <label>C++:<span style="color: rgb(226, 6, 6);">*</span></label><br>
                    <input class="form-field" type="range" name="cpp_level"><br><br>
                    <label>PHP:<span style="color: rgb(226, 6, 6);">*</span></label><br>
                    <input class="form-field" type="range" name="php_level"><br><br>
                    <label>Java-Script:<span style="color: rgb(226, 6, 6);">*</span></label><br>
                    <input class="form-field" type="range" name="js_level"><br><br>
                    <label>HTML:<span style="color: rgb(226, 6, 6);">*</span></label><br>
                    <input class="form-field" type="range" name="html_level"><br><br>
                    <label>CSS:<span style="color: rgb(226, 6, 6);">*</span></label><br>
                    <input class="form-field" type="range" name="css_level"><br><br>
                    <label>Język obcy:<span style="color: rgb(226, 6, 6);">*</span></label><br>
                    <input type="text" class="form-field form-left" name="lan_name" required><br><br>
                    <label>Poziom(A1-C1): <span style="color: rgb(226, 6, 6);">*</span></label><br>
                    <input type="text" class="form-field form-left" name="lan_level" required> <br><br>
                    <label for="algorithm" required>Wybierz algorytm:</label>
                    <select name="algorithm">
                        <option value="Euklides">Odległość Euklidesowa</option>
                        <option value="Manhattan">Odległość Manhattan</option>
                        <option value="Cosinus">Podobieństwo cosinusowe</option>
                    </select>
                </div>
                <div>
                    <button class="submit-button " type="submit">Dalej</button>
                </div>
            </form>
        </div>
        <div class="form-back">
            <a href="../index.html">&lt Powrót</a>
        </div>


    </div>


</body>

</html>