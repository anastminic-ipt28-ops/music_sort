<?php
echo "<html>
<head>
<meta charset='UTF-8'>
<link rel='stylesheet' href='style.css'>
<title>Музика</title>
</head>
<body>";

echo "<h2>Список музики</h2>";
echo "<p>Оберіть спосіб сортування:</p>";

echo "<div>
<a href='?sort=0'>Виконавець</a> |
<a href='?sort=1'>Рік</a> |
<a href='?sort=2'>Альбом</a> |
<a href='?sort=3'>Назва</a>
</div>";

echo "<hr>";

$dir = './mp3';
$files = scandir($dir);

if($files == false)
{
  echo "Помилка: папка mp3 не знайдена";
  exit;
}

$songs = array();


foreach($files as $f)
{
  if($f == "." || $f == "..") continue;

  $tmp = explode(".mp3", $f);
  $parts = explode(" -- ", $tmp[0]);

  if(count($parts) < 4) continue;

  $song = array();
  $song[0] = $parts[0];
  $song[1] = $parts[1];
  $song[2] = $parts[2];
  $song[3] = $parts[3];
  $song[4] = $f;

  $songs[] = $song;
}


$mode = 0;
if(isset($_GET["sort"])) $mode = $_GET["sort"];

for($i = 0; $i < count($songs); $i++)
{
  for($j = $i+1; $j < count($songs); $j++)
  {
    if($songs[$i][$mode] > $songs[$j][$mode])
    {
      $tmp = $songs[$i];
      $songs[$i] = $songs[$j];
      $songs[$j] = $tmp;
    }
  }
}

echo "<table>";
echo "<tr>
<th>Виконавець</th>
<th>Рік</th>
<th>Альбом</th>
<th>Назва</th>
<th>Play</th>
<th>Download</th>
</tr>";

foreach($songs as $s)
{
  echo "<tr>";

  echo "<td>$s[0]</td>";
  echo "<td>$s[1]</td>";
  echo "<td>$s[2]</td>";
  echo "<td>$s[3]</td>";

  echo "<td>
  <audio controls>
    <source src='$dir/$s[4]' type='audio/mpeg'>
  </audio>
  </td>";

  echo "<td>
<a href='$dir/$s[4]' download>
<img src='https://img.icons8.com/?size=100&id=366&format=png&color=000000' width='25'>
</a>
</td>";

  echo "</tr>";
}

echo "</table>";

echo "</body></html>";
?>