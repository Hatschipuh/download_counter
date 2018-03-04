<?php
/*
Download Counter V1.0 02/18
=======================

Version:    1.0  10.03.2018
Autor:      Hertste, Germany, stefan.programmiert@web.de
Website:    Http://www.pc.hertste.de
Copyright:  2018 Stefan H.

Für Bludit Version 2.X

Fragen, Wünsche, Anregungen sind erwünscht
*/




class download2 extends Plugin {

	public function init()
	{
		// Fields and default values for the database of this plugin
		$this->dbFields = array(
		    'nullen'=>False,
		    'an_aus'=>False
		);
	}






	// Method called on the settings of the plugin on the admin area
	public function form()
	{
		global $Language;
		$html = $Language->get('installation').'<br /><br />';


        // === Zählener an / aus
        if ($this->getValue('an_aus') == "1") { //eingeschaltet
            if (!copy(PATH_PLUGINS.'download/downloadcounter.php', PATH_UPLOADS.'downloadcounter.php')) { $html .= "Installation schlug fehl."; }
            // .htaccess muss neu geschrieben werden
  $fp=@fopen(PATH_UPLOADS.'.htaccess',"w+");
  @fwrite($fp,"RewriteEngine On\r\nRewriteRule (^.*\.zip$) ".DOMAIN_UPLOADS."downloadcounter.php?$1 [R=301,L]  ");
  fclose($fp);

            //if (!copy(PATH_PLUGINS."download/htaccess/.htaccess", PATH_UPLOADS.'.htaccess')) { $html .= "Installation schlug fehl."; }
        } else {  //ausgeschaltet
            @unlink(PATH_UPLOADS.'downloadcounter.php');
            @unlink(PATH_UPLOADS.'.htaccess');
        }

if ($this->getValue('nullen') == "1") { // Zählener nullen
    @unlink(PATH_UPLOADS."download_counter/download_counter.csv");
    @rmdir(PATH_UPLOADS."download_counter");
}

        $html .= '<a href="'.DOMAIN_UPLOADS.'download_counter/download_counter.csv">Download Counter Statistik (CSV)</a><br />';


        // === Zähler Ein- Ausschalten
		$html .= '<br /><div>';
		$html .= '<label>'.$Language->get('zaehler_ein_ausschalten').'</label>';
		$html .= ''.$Language->get('zaehler_hinweis').'<br />';
		$html .= '<select name="an_aus" style="width:100px">';
		$html .= '<option value="true" '.($this->getValue('an_aus')===true?'selected':'').'>On</option>';
		$html .= '<option value="false" '.($this->getValue('an_aus')===false?'selected':'').'>Off</option>';
		$html .= '</select> ';
		$html .= '</div><br />';

        // === Zähler Nullen
		$html .= '<div>';
		$html .= '<label>'.$Language->get('zaehler_nullen').'</label>';
		$html .= ''.$Language->get('nullen_hinweis').'<br />';
		$html .= '<select name="nullen" style="width:100px">';
		$html .= '<option value="true" '.($this->getValue('nullen')===true?'selected':'').'>On</option>';
		$html .= '<option value="false" '.($this->getValue('nullen')===false?'selected':'').'>Off</option>';
		$html .= '</select> ';
		$html .= '</div>';


        //echo stripslashes(DOMAIN_UPLOADS.'downloadcounter.php<<----');
  $strURL = $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];


		return $html;
	}


   }

?>
