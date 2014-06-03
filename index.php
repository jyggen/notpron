<style>body { font-family: monospace; } input { border: 1px solid #ccc; padding: 5px; margin: 5px; } td { padding: 0 14px; }</style>
<div style="float: left; width: 50%">
    <h3>String Functions</h3>
    <form method="get">
        <table>
            <tr>
                <td><label>String:</label></td>
                <td><input name="string" type="text" style="width: 200px"></td>
            </tr>
            <tr>
                <td></td>
                <td><input name="button" type="submit" value="Calculate!"></td>
            </tr>
        </table>
    </form>
    <?php
    if (isset($_GET['string'])) {
        print '<table><tr><th>Function</th><th>Result</th></tr>';

        $string  = str_split($_GET['string']);
        $string2 = range('a', 'z');
        $string3 = array_reverse($string2);
        $newStr  = '';

        foreach ($string as $letter) {
            if ($letter === ' ') {
                $newStr .= $letter;
            } else {
                $newStr .= $string3[array_search(strtolower($letter), $string2)];
            }
        }

        print '<tr><td>Reverse</td><td>'.$newStr.'</td></tr>';

        $string  = str_split($_GET['string']);
        $string2 = range('a', 'z');
        $string2 = array_merge($string2, $string2, $string2, $string2, $string2);
        $newStr  = '';

        for ($i = 0; $i <= 26; $i++) {
            foreach ($string as $letter) {
                if ($letter === ' ') {
                    $newStr .= $letter;
                } else {
                    if ($i < 0) {
                        $newStr .= $string2[abs((array_search(strtolower($letter), $string2) - $i) % 26)];
                    } else {
                        $newStr .= $string2[abs((array_search(strtolower($letter), $string2) + $i) % 26)];
                    }
                }
            }
            print '<tr><td>Distance ('.$i.'/-'.(26-$i).')</td><td>'.$newStr.'</td></tr>';
            $newStr = '';
        }

        print '</table>';
    }
    ?>
</div>
<div style="float: left; width: 50%">
    <h3>Password Guesser</h3>
    <form method="get">
        <table>
            <tr>
                <td><label>URL:</label></td>
                <td><input name="url" type="text" style="width: 200px" value="<?php if (isset($_GET['url'])) { echo $_GET['url']; } ?>"></td>
            </tr>
            <tr>
                <td><label>Username:</label></td>
                <td><input name="username" type="text" style="width: 200px"></td>
            </tr>
            <tr>
                <td><label>Password:</label></td>
                <td><input name="password" type="text" style="width: 200px"></td>
            </tr>
            <tr>
                <td></td>
                <td><input name="button" type="submit" value="Guess!"></td>
            </tr>
        </table>
    </form>
    <?php
    $cache = json_decode(file_get_contents('auth.json'), true);

    if (isset($_GET['url']) and isset($_GET['username']) and isset($_GET['password'])) {
        $url  = $_GET['url'];
        $user = mb_strtolower($_GET['username'], 'utf-8');
        $pass = mb_strtolower($_GET['password'], 'utf-8');

        if (!isset($cache[$url]) or !isset($cache[$url][md5(serialize([$user, $pass]))])) {
            require_once 'vendor/autoload.php';
            $client = new GuzzleHttp\Client();
            try {
                $client->get($url, ['auth' => [$user, $pass]]);
                $cache[$url][md5(serialize([$user, $pass]))] = [$user, $pass, '#bada55'];
            } catch (Exception $e) {
                $cache[$url][md5(serialize([$user, $pass]))] = [$user, $pass, 'hotpink'];
            }
            file_put_contents('auth.json', json_encode($cache));
        }
    }

    foreach ($cache as $url => $guesses) {
        print '<table style="width: 80%; margin-bottom: 7px"><tr><th colspan="2" style="text-align: left">'.$url.'</th></tr>';
        foreach ($guesses as $guess) {
            print '<tr style="background: '.$guess[2].'"><td style="width: 50%">'.$guess[0].'</td><td style="width: 50%">'.$guess[1].'</td></tr>';
        }
        print '</table>';
    }
    ?>
</div>
