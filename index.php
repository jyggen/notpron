<style>body { background: HOTPINK; color: #b4D455; } input { border: 1px solid #ccc; padding: 5px; margin: 5px; } td { padding: 0 14px; }</style>
<pre>
<table>
<tr><th>Function</th><th>Result</th></tr>
<?php
if (isset($_GET['string'])) {
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
}
?>
</table>
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
</pre>
