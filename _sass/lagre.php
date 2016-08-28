<?php
//Tilkoblingsinformasjon
$servername = "localhost";
$username = "tjc";
$password = "xxxxxx";
$dbname = "tjc";

// Tilkobling til databasen og feilsjekk
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

//Leser inn value fra skjemaet på hovedsiden
$verdi01 = $_POST['fname'];
$verdi02 = $_POST['kode'];
$verdi03 = $_POST['drikke'];
$verdi04 = $_POST['hoved'];
$verdi05 = $_POST['side'];
$verdi06 = implode(',', $_POST['annet']);

$conn->query($sql);

// Legger inn verdier i kundetabellen
$sql = "INSERT INTO kunde (fnavn, kode)
VALUES ('$verdi01', '$verdi02')";
//Sjekker om det gikk bra å opprette ny linje i kundetabellen
if ($conn->query($sql) === TRUE) {
    echo "New record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

//Henter siste person_id inn i variabelen $last_id
$last_id = $conn->insert_id;
echo "Last inserted ID is: " . $last_id . "<br>";

//Legger inn data i bestillingstabellen - Siste person_id fra person som fremmednøkkel
$sql = "INSERT INTO bestilling (drikke, main, side, addon, person_id)
VALUES ('$verdi03', '$verdi04', '$verdi05', '$verdi06', '$last_id')";

//Sjekker om det gikk bra å opprette ny linje i tabellen
if ($conn->query($sql) === TRUE) {
    echo "New record created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}


// Skriver ut data fra tabellen
$sql = "SELECT  bestilling.bestilling_id, 
                kunde.fnavn,
                kunde.kode,
                bestilling.drikke,
                bestilling.main,
                bestilling.side,
                bestilling.addon 
        FROM bestilling 
        INNER JOIN kunde
        ON bestilling.person_id=kunde.person_id";

$result = $conn->query($sql);


if ($result->num_rows > 0){
	//Legger ut data i en tabell
	echo "<table border='1px'>";
    while($row = $result->fetch_assoc()){
    	echo "<tr>";
    	echo "<td>" . "id: " . $row["bestilling_id"] . "</td>";
    	echo "<td>" . "Navn: " . $row["fnavn"] . "</td>";
        echo "<td>" . "Kodeord: " . $row["kode"] . "</td>";
    	echo "<td>" . "Drikke: " . $row["drikke"] . "</td>";
        echo "<td>" . "Hovedrett: " . $row["main"] . "</td>";
        echo "<td>" . "Tilbehor: " . $row["side"] . "</td>";
        echo "<td>" . "Topping: " . $row["addon"] . "</td>";
    	echo "</tr>";
    	}
    echo "</table>";
	} 
	else {
		echo "0 results";
	}

echo "<br><a href='http://elevweb.skit.no/tjc/'>Tlbake til hovedsiden</a>";
$conn->close();
?>
