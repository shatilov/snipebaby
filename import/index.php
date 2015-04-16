<?php
/**
 * Created by JetBrains PhpStorm.
 * User: sahtilov
 * Date: 17.04.13
 * Time: 19:05
 * To change this template use File | Settings | File Templates.
 */

// Create connection
$con=mysql_connect("localhost","maesz","pfhf,jne","maesz_joom");

// Check connection
if (!$con)
{
	echo "Failed to connect to MySQL: ";
	die();
} else { echo "Connection was OK!\n";}

echo '<pre>';

$source_prefix = 'jold_kid';
$dest_prefix = 'j25_';

$src_tables = array();
$dst_tables = array();

$res = mysql_list_tables('maesz_joom',$con);

if ($res)
{
	while($data = mysql_fetch_assoc($res)){

		$tname = $data['Tables_in_maesz_joom'];
		if(strpos($tname , $source_prefix)!==false)
		{
			$name = substr($tname,strlen($source_prefix));
			$src_tables[$name] = $tname;
		}

		if(strpos($tname , $dest_prefix)!==false)
		{
			$name = substr($tname,strlen($dest_prefix));
			$dst_tables[$name] = $tname;
		}
	}

	foreach($dst_tables as $name=>$table){
		//if (!in_array($name, array('templates_menu','plugins' , 'users' ,'session','jce_plugins','coupons')))
		{
			if($src_tables[$name])
			{
			$SQL[] = "delete from maesz_joom.".$dest_prefix.$name.";";
			$SQL[] = "insert into maesz_joom.".$dest_prefix.$name." SELECT * FROM maesz_joom.".$source_prefix.$name.";";
			}
		}
	}
}

foreach($SQL as $q)
{
	echo $q."\n";
	//if(!mysql_query($q)) echo("Query failed : " . mysql_error() ." \n");
}

mysql_close($con);