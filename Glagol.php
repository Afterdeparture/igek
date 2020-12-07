<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <style type="text/css">
            body {background-size: cover; background-position: center top;
                  background-image: url("Parlament.jpg");background-repeat: no-repeat;
            background-attachment: fixed;}
            table#sad {position: relative;align:left}
            table#pro {position: relative;align:center}
            table#kond {position: relative;align:right}
            table#imp {position: relative;align:left}
        </style>
    </head>
    <body>
        <?php
            $ige = filter_input(INPUT_POST, 'ige', FILTER_SANITIZE_STRING);
            
            /*
             * filter_ige() pravi osnovu za sadasnje vreme
             */
            function filter_ige($ige) {
                if (substr($ige, -2) === 'ik') {
                    $ige = str_replace('ik','',$ige);
                }
                if (substr($ige,-2) === 'sz') {
                    $ige = str_replace('z','',$a);
                }
                return $ige;   
            }
            
            /*
             * filter_ige_past1() pravi osnovu za sva lica u proslom vremenu
             * osim za 3. lice jednine prve promene
             */
            function filter_ige_past1($ige,$h1) {
                $sug = ('(b|c|d|f|g|h|k|m|p|t|v)');
                $sugl = ('(b|c|d|f|g|h|j|k|l|m|n|p|r|t|v)');
                if (substr($ige, -2) === 'ik') {
                    $ige = str_replace('ik','',$ige);
                }
                $ige1 = $ige . 't';
                if (substr($ige,-3) == 'ít') {
                    $ige1 = $ige . $h1 . 'tt';
                }
                if ((preg_match($sugl, substr($ige,-2,1))) && (preg_match($sug, substr($ige,-2,2)))) {
                    $ige1 = $ige . $h1 . 'tt';
                }
                if (preg_match('(vesz|visz|tesz|hisz)',$ige)) {
                    $ige1 = str_replace('sz','tt',$ige);
                }
                if ($ige === 'esz') {
                    $ige1 = 'ett';
                }
                if (((strlen($ige) === (3)) | (strlen($ige) === (4))) 
                    & (substr($ige,-1) === 't')) {
                    $ige1 = $ige . $h1 . 'tt'; 
                }
                return $ige1;
            }
            
            /*
             * fulter_ige_past2 pravi osnovu za proslo vreme
             * za 3. lice jednine
             */
            function filter_ige_past2($ige,$h1) {
                if (substr($ige, -2) === 'ik') {
                    $ige = str_replace('ik','',$ige);
                }
                $ige2 = $ige . $h1 . 'tt';
                if (preg_match('(l|r|n|j)',substr($ige,-1))) {
                    $ige2 = $ige . 't';
                }
                if (preg_match('(ad|ed)',substr($ige,-2))) {
                    $ige2 = $ige . 't';
                }
                if (preg_match('(vesz|visz|tesz|hisz)',$ige)) {
                    $ige2 = str_replace('sz','tt',$ige);
                }
                if ($ige === 'esz') {
                    $ige2 = 'evett';
                }
                return $ige2;
            }
            
            /*
             * inf() pravi infinitiv
             */
            function inf($ige,$ae) {
                $sug = ('(b|c|d|f|g|h|k|m|p|t|v)');
                $sugl = ('(b|c|d|f|g|h|j|k|l|m|n|p|r|s|t|v|z)');
                if (substr($ige, -2) === 'ik') {
                    $ige = str_replace('ik','',$ige);
                }
                $inf = $ige . 'ni';
                if (preg_match('(vesz|visz|tesz|hisz)',$ige)) {
                    $ige = str_replace('sz','n',$ige);
                    $inf = $ige . 'ni';
                }
                if (substr($ige,-3) == 'ít') {
                    $inf = $ige . $ae . 'ni';
                }
                if ((preg_match($sugl, substr($ige,-2,1))) && (preg_match($sug, substr($ige,-2,2)))) {
                    $inf = $ige . $ae . 'ni';
                }
                if ($ige === 'esz') {
                    $inf = 'enni';
                }
                return $inf;
            }
            
            /*
             * s_z sluzi da proveri da li se glagol zavrsava
             * na s ili z i vraca rezultat
             */
            function s_z($ige) {
                $s_z = '';
                $veg1 = substr($ige,-1);
                if ($veg1 === 's') {
                    $s_z = 's';
                }
                if ($veg1 === 'z') {
                    $s_z = 'z';
                }
                return $s_z;
            }
            
            /*function imp($ige,$veg,$ujveg) {
                $len = strlen($veg);
                if (substr($ige,-$len) === $veg) {
                    return $ige . $ujveg;
                } else {
                    return $ige . 'j';
                }
            }*/
            /*
             * imperativ() pravi osnovu za imperativ
             */
            function imperativ($ige) {
                if (substr($ige, -2) === 'ik') {
                    $ige = str_replace('ik','',$ige);
                }
                $veg1 = substr($ige,-1);
                $veg2 = substr($ige,-2);
                $veg3 = substr($ige,-3);
                $sugl = ('(b|c|d|f|g|h|j|k|l|m|n|p|r|t|v)');
                $imp = $ige . 'j'; 
                if ($veg1 === 't') {
                    $imp = substr($ige,0,-1) . 'ss';    
                }
                if (($veg1 === 't') && (preg_match($sugl, substr($ige,-2,1)))) {
                    $imp = substr($imp,0,-2) . 'ts';
                }
                if ($veg3 === 'ít') {
                    $imp = $ige . 's';
                }
                if ($veg3 === 'szt') {
                    $imp = substr($ige,0,-3) . 'ssz';
                }
                if ($veg2 === 'sz') {
                    $imp = substr($ige,0,-2) . 'ssz';
                }
                if ($veg2 === 'st') {
                    $imp = substr($ige,0,-2) . 'ss';
                }
                if ($s_z) {
                    $imp = $ige . $s_z;
                }
                return $imp;
            }
            
            function imperativ2($imp) {
                $veg2 = substr($imp,-2);
                $veg3 = substr($imp,-3);
                $imp2 = substr($imp,0,-1);
                if ($veg3 === 'ssz') {
                    $imp2 = substr($imp,0,-3) . 'sz';
                }
                if ($veg2 === 'ts') {
                    $imp2 = $imp;
                }
                return $imp2;
            }
            
            function harmony1($ige) { //proverava harmoniju vokala o-e-ö
                if (preg_match('(ö|ő|ü|ű)', $ige)) {
                    return 'ö';
                }
                if (preg_match('(a|o|u|á|ó|ú)', $ige)) {
                    return 'o';
                }
                return 'e';
            }
            
            function a_e($h1) {
                $ae = 'a';
                if ($h1 !== 'o') {
                    $ae = 'e';
                }
                return $ae;
            }
            
            function aa_ee($h1) {
                $aaee = 'á';
                if ($h1 !== 'o') {
                    $aaee = 'é';
                }
                return $aaee;
            }
            
            /*
             * j_jj,s_ss,z_zz,sz_ssz proveravaju harmoniju vokala
             *  i dodaju odgovarajuci suglasnik
             */
            function j_jj($h1) {
                if ($h1 === 'o') {
                    $duplo1 = 'j';
                    return $duplo1;
                }
            } 
            
            function s_ss($h1) {
                if ($h1 === 'o') {
                    $duplo1 = 's';
                    return $duplo1;
                }
            }
            
            function z_zz($h1) {
                if ($h1 === 'o') {
                    $duplo1 = 'z';
                    return $duplo1;
                }
            }
            
            function sz_ssz($h1) {
               if ($h1 === 'o') {
                    $duplo1 = 'sz';
                    return $duplo1;
                }
            }
            
            function check_ik($ige) {//proverava da li se glagol zavrsava na "-ik"
                if (substr($ige, -2) === 'ik') {
                    $ik = 'ik';
                    return $ik;    
                }   
            }
            
            function te($ige3,$h1) {
                $te = 'sz';
                if (preg_match('(s|z)', substr($ige3, -1))) {
                    if ($h1 === 'o') {
                        $te = 'ol';
                    }
                    if ($h1 === 'e') {
                        $te = 'el';
                    }
                    if ($h1 === 'ö') {
                        $te = 'öl';
                    }
                }
                return $te;
            }

            function check_it($ige) {
                if (substr($ige,-3) == 'ít') {
                    $it = 1;
                    return $it;
                }   
            }
            
            function check_duplo1($ige,$h1) {
                if (substr($ige, -2) === 'ik') {
                    $ige = str_replace('ik','',$ige);
                }
                $duplo1 = j_jj($h1);
                if (preg_match('/s/',substr($ige,-1))) {
                    $duplo1 = s_ss($h1);
                }
                if (substr($ige,-1) === 'z') {   
                    if (substr($ige,-2) === 'sz') {
                        $duplo1 = sz_ssz($h1);
                    } else {
                        $duplo1 = z_zz($h1);
                    }    
                }
                return $duplo1;
            }
            
            function check_duplo2($ige) {
                if (substr($ige, -2) === 'ik') {
                    $ige = str_replace('ik','',$ige);
                }
                $duplo2 = 'j';
                if (preg_match('/s/',substr($ige,-1))) {
                    $duplo2 = 's';
                }
                if (substr($ige,-1) === 'z') {   
                    if (substr($ige,-2) === 'sz') {
                        $duplo2 = 'sz';
                    } else {
                        $duplo2 = 'z';
                    }   
                }
                return $duplo2; 
            }
            
            function check_z($ige) {
                $z = '';
                if (substr($ige, -2) === 'ik') {
                    $ige = str_replace('ik','',$ige);
                }
                if (substr($ige,-2) === 'sz') {
                    $z = 'z'; 
                }
                return $z;
            }
            
            function check_z2($ige,$h1) {
                $z2 = '';
                if (substr($ige, -2) === 'ik') {
                    $ige = str_replace('ik','',$ige);
                }
                if (substr($ige,-2) === 'sz') {
                    if ($h1 !== 'o') {
                        $z2 = 'z';
                    }
                }
                return $z2;
            }
            
            
            function konjugacija($ige) {
                /* $ige je varijabla za uneseni glagol */
                $sug = ('(b|c|d|f|g|h|k|m|p|t|v)');
                $sugl = ('(b|c|d|f|g|h|j|k|l|m|n|p|r|t|v)');                
                $av1 = '';
                $av2 = '';
                $h1 = harmony1($ige);
                $h2 = ($h1 === 'o') ? 'u' : 'ü';
                $h3 = ($h1 === 'o') ? 'o' : 'e';
                $ai = ($h1 === 'o') ? 'a' : 'i';
                $aai = ($h1 === 'o') ? 'á' : 'i';
                $ae = a_e($h1);
                $aaee = aa_ee($h1);
                $ik = check_ik($ige);
                $it = check_it($ige);
                $ige1 = filter_ige_past1($ige,$h1);
                $ige2 = filter_ige_past2($ige, $h1);                
                $ige3 = filter_ige($ige);
                $te = te($ige3,$h1);
                $duplo1 = check_duplo1($ige, $h1);
                $duplo2 = check_duplo2($ige);
                $z = check_z($ige);
                $z2 = check_z2($ige, $h1);
                $inf = inf($ige, $ae);
                $cond = str_replace(substr($inf,-1),'',$inf);
                $imp = imperativ($ige);
                $imp2 = imperativ2($imp);
                
                if ($it === 1) {
                    $av1 = $h1;
                    $av2 = $ae;
                }
                if ((preg_match($sugl, substr($ige,-2,1))) && (preg_match($sug, substr($ige,-2,2)))) {
                    $av1 = $h1;
                    $av2 = $ae;
                }
                echo "<h2>Osnovni oblik: " . "<strong>" . $ige . 
                      "</strong></h2>" . "<br>" . "<h3>Infinitiv: $inf</h3><br>";
                    
                echo "<table id=\"sad\">" .
                     "<tr><td>én</td><td>" . $ige3 . $z . $h1 . "k" . "</td>" .
                     "<td>" . $ige3 . $z . $h1 . "m</td></tr>" .
                     "<tr><td>te</td><td>" . $ige3 . $z . $av2 . $te . "</td>"
                     . "<td>" . $ige3 . $z . $h1 . "d</td></tr>" .
                     "<tr><td>Ön,ő</td><td>" . $ige3 . $z . $ik . "</td>" .
                     "<td>" . $ige3 . $duplo1 . $z2 . $ai . "</td></tr>" .
                     "<tr><td>mi</td><td>" . $ige3 . $z . $h2 . "nk</td>" .
                     "<td>" . $ige3 . $duplo2 . $h2 . "k</td></tr>"
                     . "<tr><td>ti</td><td>" . $ige3 . $z . $av1 . "t" . $h1 . "k</td>" .
                     "<td>" . $ige3 . $duplo1 . $z2 . $aai . "t" . $h3 . "k</td></tr>" . 
                     "<tr><td>ők,Önök</td>" . "<td>" . $ige3 . $z . $av2 . "n" . $ae . "k</td>" .
                     "<td>" . $ige3 . $duplo1 . $z2 . $aai . "k</td></tr>" .
                     "</table>";
                
                echo "<table id=\"pro\">" . 
                     "<tr><td>én</td><td>" . $ige1 . $ae . "m" . "</td>" . 
                     "<td>" . $ige1 . $ae . "m</td></tr>" .
                     "<tr><td>te</td><td>" . $ige1. $aaee . "l</td>" .
                     "<td>" .$ige1 . $ae . "d</td></tr>" . 
                     "<tr><td>Ön,ő</td><td>" . $ige2 . "</td>" . 
                     "<td>" . $ige1 . $ae . "</td></tr>" .
                     "<tr><td>mi</td><td>" . $ige1 . $h2 . "nk</td>" .
                     "<td>" . $ige1 . $h2 . "k</td></tr>" . 
                     "<tr><td>ti</td><td>" . $ige1 . $ae . "t" . $h3 . "k</td><td>"
                     . $ige1 . $aaee . "t" . $h3 . "k</td></tr>" . 
                     "<tr><td>ők,Önök</td><td>" . $ige1 . $ae . "k</td><td>" 
                     . $ige1 . $aaee . "k</td></tr></table>";
                
                echo "<table id=\"kond\"><tr><td>én</td><td>" . $cond . "ék" . 
                     "</td><td>" . $cond . $aaee . "m</td></tr>" .
                     "<tr><td>te</td><td>" . $cond . $aaee . "l</td><td>" .
                     $cond . $aaee . "d</td></tr><tr><td>Ön,ő</td><td>" .
                     $cond . $ae . "</td><td>" . $cond . $aaee . 
                     "</td></tr><tr><td>mi</td><td>" . $cond . $aaee . 
                     "nk</td><td>" . $cond . $aaee . "nk</td></tr><tr><td>"
                     . "ti</td><td>" . $cond . $aaee . "t" . $h3 . "k</td><td>"
                     . $cond . $aaee . "t" . $h3 . "k</td></tr>" . 
                     "<tr><td>ők,Önök</td><td>" . $cond . $aaee . "n" . $ae . 
                     "k</td><td>" . $cond . $aaee . "k</td></tr></table>";
                
                echo "<table id=\"imp\"><tr><td>én</td><td>" . $imp . $ae . 
                     "k</td><td>" . $imp . $ae . "m</td></tr>" .
                     "<tr><td>te</td><td>" . $imp . "(" . $aaee . "l)</td><td>" .
                     $imp2 . "d</td></tr><tr><td>Ön,ő</td><td>" .
                     $imp . $h1 . "n</td><td>" . $imp . $ae . 
                     "</td></tr><tr><td>mi</td><td>" . $imp . $h2 . 
                     "nk</td><td>" . $imp . $h2 . "k</td></tr><tr><td>"
                     . "ti</td><td>" . $imp . $ae . "t" . $h3 . "k</td><td>"
                     . $imp . $aaee . "t" . $h3 . "k</td></tr>" . 
                     "<tr><td>ők,Önök</td><td>" . $imp . $ae . "n" . $ae . 
                     "k</td><td>" . $imp . $aaee . "k</td></tr></table>";
            }
            
            konjugacija($ige);
        ?>
        <a href="index.html"><h3>Nazad</h3></a>
    </body>
</html>
