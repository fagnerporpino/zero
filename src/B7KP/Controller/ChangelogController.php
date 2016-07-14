<?php
namespace B7KP\Controller;

use B7KP\Model\Model;
use B7KP\Core\Dao;
use B7KP\Core\App;
use B7KP\Entity\User;
use B7KP\Utils\UserSession;
use B7KP\Library\Route;
use B7KP\Library\Options;
use B7KP\Utils\Pass;

class ChangelogController extends Controller
{

	function __construct(Model $factory)
	{
		parent::__construct($factory);
	}

	/**
	* @Route(name=zero_versions|route=/changelog)
	*/
	public function showVersions()
	{
		$dao = Dao::getConn();

		// PLAQUE
		$plaques 	= $dao->run("SELECT COUNT(*) AS t, date FROM plaque GROUP BY date ORDER BY date DESC");
		$userplaque = $dao->run("SELECT COUNT(*) AS t, login FROM plaque, user WHERE plaque.iduser = user.id GROUP BY iduser ORDER BY t DESC LIMIT 0,1");
		$lastplaque = $dao->run("SELECT plaque.*, user.login FROM plaque, user WHERE user.id = plaque.iduser ORDER BY id DESC LIMIT 0, 3");

		$last = $plaques[0];
		usort($plaques, function($a, $b){ return $a->t < $b->t; });
		$biggest = $plaques[0];
		$total = 0;
		foreach ($plaques as $key => $value) { $total += $value->t; }

		// USER
		$users = $dao->run("SELECT COUNT(*) as t FROM user"); 
		$user = $dao->run("SELECT * FROM user ORDER BY id DESC LIMIT 0,1"); 

		// CHART
		$weeks = $dao->run("SELECT COUNT(w.id) AS t, u.login FROM week w, user u WHERE u.id = w.iduser GROUP BY u.id ORDER BY t");
		$biggestuser = $weeks[0];
		$totalweeks = 0;
		foreach ($weeks as $key => $value) {
			$totalweeks += $value->t;
		}
		// art/alb/mus
		$artist = $dao->run("SELECT COUNT(id) AS t, artist FROM artist_charts GROUP BY artist ORDER BY t DESC LIMIT 0, 1");
		$album = $dao->run("SELECT COUNT(id) AS t, album, artist FROM album_charts GROUP BY artist, album ORDER BY t DESC LIMIT 0, 1");
		$music = $dao->run("SELECT COUNT(id) AS t, music, artist FROM music_charts GROUP BY artist, music ORDER BY t DESC LIMIT 0, 1");
		$artist_one = $dao->run("SELECT COUNT(id) AS t, artist FROM artist_charts WHERE rank = 1 GROUP BY artist ORDER BY t LIMIT 0, 1");
		$album_one = $dao->run("SELECT COUNT(id) AS t, album, artist FROM album_charts WHERE rank = 1 GROUP BY artist, album ORDER BY t LIMIT 0, 1");
		$music_one = $dao->run("SELECT COUNT(id) AS t, music, artist FROM music_charts WHERE rank = 1 GROUP BY artist, music ORDER BY t LIMIT 0, 1");

		// SETTINGS
		$options = new Options();
		$limits["art"] = $dao->run("SELECT count(id) AS t, art_limit FROM settings GROUP BY art_limit");
		$limits["alb"] = $dao->run("SELECT count(id) AS t, alb_limit FROM settings GROUP BY alb_limit");
		$limits["mus"] = $dao->run("SELECT count(id) AS t, mus_limit FROM settings GROUP BY mus_limit");
		$cert = $dao->run("SELECT count(id) AS t, avg(alb_cert_gold) as ag, avg(alb_cert_platinum) as ap, avg(alb_cert_diamond) as ad, avg(mus_cert_gold) as mg, avg(mus_cert_platinum) as mp, avg(mus_cert_diamond) as md FROM settings WHERE show_cert = 1 GROUP BY cert_type");
		$cert_c["ag"] = $dao->run("SELECT count(id) AS t FROM settings WHERE show_cert = 1 GROUP BY alb_cert_gold ORDER BY t DESC");
		$cert_c["ap"] = $dao->run("SELECT count(id) AS t FROM settings WHERE show_cert = 1 GROUP BY alb_cert_platinum ORDER BY t DESC");
		$cert_c["ad"] = $dao->run("SELECT count(id) AS t FROM settings WHERE show_cert = 1 GROUP BY alb_cert_diamond ORDER BY t DESC");
		$cert_c["mg"] = $dao->run("SELECT count(id) AS t FROM settings WHERE show_cert = 1 GROUP BY mus_cert_gold ORDER BY t DESC");
		$cert_c["mp"] = $dao->run("SELECT count(id) AS t FROM settings WHERE show_cert = 1 GROUP BY mus_cert_platinum ORDER BY t DESC");
		$cert_c["md"] = $dao->run("SELECT count(id) AS t FROM settings WHERE show_cert = 1 GROUP BY mus_cert_diamond ORDER BY t DESC");

		//$limit = $options->get("B7KP\Entity\Settings", "");
		$vars = array
				(
					"plaque_last_day" 	 => $last->t,
					"plaque_biggest_day" => $biggest,
					"plaque_total"		 => $total,
					"plaque_last" 		 => $lastplaque,
					"user_total"		 => $users[0]->t,
					"user_last"			 => $user[0],
					"user_plaque"		 => $userplaque[0],
					"user_weeks"		 => $biggestuser,
					"weeks_total" 		 => $totalweeks,
					"top_artist"		 => $artist[0],
					"top_album"			 => $album[0],
					"top_music"			 => $music[0],
					"top_artist_one"	 => $artist_one[0],
					"top_album_one"		 => $album_one[0],
					"top_music_one"		 => $music_one[0],
					"limits"			 => $limits,
					"cert_type"			 => $cert,
					"cert_c"			 => $cert_c
				);
		$this->render("zero.php", $vars);
	}

	protected function checkAccess()
	{
		return true;
	}
}
?>