<?php
//Informasjon om tilkobling
$servername = "localhost";
$username = "elise";
$password = "abcd1234";
$dbname = "elise";

//Kobler til databasen
$conn = new mysqli($servername, $username, $password, $dbname);

//Sjekker om forbindelse ble opprettet
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

//Leser inn value fra skjemaet på hovedsiden
$value = $_POST['fornavn'];
$value1 = $_POST['etternavn'];
$value2 = $_POST['alder'];
$value3 = $_POST['kjonn'];
$value4 = $_POST['postnr'];
$value5 = $_POST['kode'];
$value6 = $_POST['drikke'];
$value7 = $_POST['mat'];
$value8 = $_POST['tilbehor'];
$verdi9 = implode(',', $_POST['ekstra']);

$conn->query($sql);

$sql = "INSERT INTO kunde (fornavn, etternavn, alder, kjonn, postnr, kode)
VALUES ('$value', '$value1', '$value2', '$value3', '$value4', '$value5')";

$sql = "INSERT INTO bestilling (drikke)
VALUES ('$value6')";


//Sjekker om det gikk bra å opprette ny linje i tabellen
if ($conn->query($sql) === TRUE) {
    echo "New record created successfully<br>";
} else {
    echo "Error:" . $sql . "<br>" . $conn->error;
}


$sql = "SELECT * FROM kunde
    JOIN bestilling
    ON kunde.kunde_id = bestilling.kunde_id";


$result = $conn->query($sql);

//Sjekker om det er fler enn null linjer i tabellen
if($result->num_rows > 0){

//Lager tabell for resultatene
echo"<table border='1px'>";
	while($row = $result->fetch_assoc()){
	echo"<tr>";
echo"<td>"."Fornavn: ".$row["fornavn"]."</td>";
echo"<td>"."Etternavn: ".$row["etternavn"]."</td>";
echo"<td>"."Alder: ".$row["alder"]."</td>";
echo"<td>"."Kjønn: ".$row["kjonn"]."</td>";
echo"<td>"."Postnr: ".$row["postnr"]."</td>";
echo"<td>"."Kode: ".$row["kode"]."</td>";
echo"<td>"."Drikke: ".$row["drikke"]."</td>";
echo"<td>"."Mat: ".$row["mat"]."</td>";
echo"<td>"."Tilbehør: ".$row["tilbehor"]."</td>";
echo"<td>"."Ekstra: ".$row["ekstra"]."</td>";
	echo"</tr>";
}
echo "</table>";
}

//Dersom det ikke er fler enn null linjer i tabellen
else{
echo "0 results";
}

//Link tilbake til hovedsiden
echo "<br><a href='http://elevweb.skit.no/elise/mcbergbys'>Tilbake til hovedsiden</a>";

//Lukker forbindelsen
$conn->close();
?>