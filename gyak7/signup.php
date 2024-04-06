<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Regisztráció</title>
</head>
<body>

    <table>
        <tr>
            <th>Adat</th>
            <th>Érték</th>
        </tr>
        <tr>
            <td>email</td>
            <td><?php echo $_POST["email"]?></td>
        </tr>
        <tr>
            <td>jelszó</td>
            <td><?php echo $_POST["password"]?></td>
        </tr>
        <tr>
            <td>név</td>
            <td><?php echo $_POST["name"]?></td>
        </tr>
        <tr>
            <td>születés dátuma</td>
            <td><?php echo $_POST["birth"]?></td>
        </tr>
        <tr>
            <td>kedvenc szám</td>
            <td></td>
        </tr>
        <tr>
            <td>mit gondolsz az axerwáliakokról</td>
            <td></td>
        </tr>
        <tr>
            <td>mit akarnak az axerwáliakok</td>
            <td></td>
        </tr>
    </table>



</body>
</html>