<?php
use B7KP\Entity\Settings;
use B7KP\Library\Lang;
use LastFmApi\Main\LastFm;
use B7KP\Utils\Constants as C;
use B7KP\Utils\Snippets as S;

if($settings instanceof Settings)
{
	isset($settings->style) ? $this->setCssFile($settings->style) : "";
}
else
{
	$settings = new Settings();
}
$style 				= $this->getCssContent();
$js 				= $this->getMainContent();
$show_images 		= $settings->show_images;
$show_dropouts 		= $settings->show_dropouts;
$show_first_image 	= $settings->show_first_image;
$show_playcounts 	= $settings->show_playcounts;
$show_move 			= $settings->show_move;


echo $style;
echo $js;
if($show_first_image && count($list)>0)
{
	$first = $list[0]['item'];
	$get = "get".ucfirst($type)."Info";
	$lfm = new LastFM();
	if($type == "artist")
	{
		$f = $lfm->$get($first->$type, $first->art_mbid);
	}
	else
	{
		$t = substr($type, 0,3)."_mbid";
		$f = $lfm->$get($first->$type, $first->artist, $first->$t);
	}
	if($type == "music")
	{
		if(isset($f["album"]["image"]["large"]) && !empty($f["album"]["image"]["large"]))
		{
			$fimg = $f["album"]["image"]["large"];
		}
		else
		{
			$fa = $lfm->getArtistInfo($f["artist"]["name"], $f["artist"]["mbid"]);
			$fimg = $fa["images"]["large"];
		}
	}
	else
	{
		$fimg = $f["images"]["large"];
	}
	
	echo "<div class='text-center bottomspace-xl'><img src='".$fimg."'/></div>";
}

if($show_dropouts && $week > 1)
{
	$weekbefore = $week - 1;
	$cond = array("week" => $weekbefore, "iduser" => $this->user->id);
	$lastweek = $this->factory->find("B7KP\Entity\Week", $cond);
	if(count($lastweek) > 0)
	{
		$lastweek = $lastweek[0];
		$subs = substr($type, 0,3)."_limit";
		$limitlw = $settings->$subs;
		$lastw = $this->getWeeklyCharts($lastweek, $type, $limitlw);
	}
	else
	{
		$show_dropouts = false;
	}
}
?>
<table class="chart-table table-fluid topspace-md">
	<tr>
		<th class="cr-col min center">+</th>
		<th class="center"><?php echo Lang::get('rk')?></th>
		<?php if($show_images): ?>
			<th class="center">Img</th>
		<?php ; endif;?>
		<th><?php echo Lang::get('name')?></th>
		<?php if($type != "artist"): ?>
			<th><?php echo Lang::get('art')?></th> 
		<?php ; endif;?>
		<?php if($show_playcounts): ?>
			<th class="center"><?php echo Lang::get('play_x')?></th>
		<?php ; endif;?>
		<th class="center"><?php echo Lang::get('pk')?></th>
		<th class="center"><?php echo Lang::get('wk_x')?></th>
	</tr>
	<?php 
	//var_dump($lastw);
	foreach ($list as $value) {
		$todate 	= $value["stats"]["stats"]["todate"];
		$stats 		= $value["stats"]["chartrun"][$week];
		$item 		= $value["item"];
		if($show_dropouts)
		{
			$thembid = substr($type, 0, 3)."_mbid";

			foreach ($lastw as $k => $v) {
				if(!empty($v["item"]->$thembid) && $v["item"]->$thembid == $item->$thembid)
				{
					unset($lastw[$k]);
					break;
				}
				else
				{
					if($type == "artist")
					{
						if($v["item"]->artist == $item->artist)
						{
							unset($lastw[$k]);
							break;
						}
					}
					else
					{
						if($v["item"]->artist == $item->artist && $v["item"]->$type == $item->$type)
						{
							unset($lastw[$k]);
							break;
						}
					}
				}
			}
		}
		// vars
		$position 	= $stats["rank"]["rank"];
		$move 		= S::getMove($show_move, $stats["rank"]["move"], $stats["rank"]["lw"]);
		$moveclass  = S::getMoveClass($show_move, $move, $position, true);
		$name 		= $item->$type;
		$artist 	= $item->artist;
		$plays 		= $stats["playcount"]["playcount"];
		$playsmove 	= S::getMove($show_move, $stats["playcount"]["move"], $stats["playcount"]["lw"], true);
		$pmclass  	= S::getMoveClass($show_move, $playsmove, $plays, false);
		$playsmove  = C::SHOW_MOVE_LW == $show_move ? "<span class='black'>LW:</span> ".$playsmove : $playsmove; 
		$move  		= C::SHOW_MOVE_LW == $show_move ? "<span class='black'>LW:</span> ".$move : $move;
		if(intval($move) > 0):	$move = "+".$move; endif;
		if(intval($playsmove) > 0):	$playsmove = "+".$playsmove; endif;
		$totalweeks = $todate["weeks"]["total"];
		$peak 		= $todate["overall"]["peak"];
		$t = substr($type, 0,3)."_mbid";
		$mbid = $item->$t;
	?>
	<tr>
		<td class="cr-col min">
			<a class="cr-icon"><i class="ti-stats-up"></i></a>
		</td>
		<td class='rk-col'>
			<?php echo $position;?>
			<br/>
			<span class="<?php echo $moveclass;?>"><?php echo $move;?></span>
		</td>
		<?php if($show_images): ?>
			<td class="getimage" id="rankid<?php echo $position;?>" data-type="<?php echo $type;?>" data-name="<?php echo $name?>" data-mbid="<?php echo $mbid;?>" data-artist="<?php echo $artist;?>"><?php echo S::loader(30);?></td>
		<?php ; endif;?>
		<td class="left"><?php echo $name;?></td>
		<?php 
		if($type != "artist")
		{ 
		?>
			<td class="left"><?php echo $artist;?></td> 
		<?php 
		}
		if($show_playcounts)
		{ 
		?>
			<td class='rk-col'>
				<?php echo $plays;?>
				<br/>
				<span class="<?php echo $pmclass;?>"><?php echo $playsmove;?></span>
			</td>
		<?php 
		}
		?>
		<td><?php echo $peak;?></td>
		<td><?php echo $totalweeks;?></td>
	</tr>
	<tr style="display:none;">
		<td colspan="8">
		Chart-run
		</td>
	</tr>
	<?php
	}
	?>
	<?php 
	if($show_dropouts && count($lastw) > 0)
	{
	?>
	<tr>
		<th colspan="8"><small class="topspace-lg"><?php echo Lang::get('dropouts');?></small></th>
	</tr>
	<?php
		foreach ($lastw as $dropk => $dropv) 
		{
			$dropitem = $dropv["item"];
			$name 	= $dropitem->$type;
			$artist = $dropitem->artist;
			$mbid 	= "";
			$todate = $dropv["stats"]["stats"]["todate"];
			$stats 	= $dropv["stats"]["chartrun"][$week-1];
			$position 	= $stats["rank"]["rank"];
			$plays 		= $stats["playcount"]["playcount"];
			$totalweeks = $todate["weeks"]["total"];
			$peak 		= $todate["overall"]["peak"];
	?>
	<tr class="drops">
		<td class="cr-col min">
			<a class="cr-icon"><i class="ti-stats-up"></i></a>
		</td>
		<td>
			OUT
			<br/>
			<small>LW: <?php echo $position;?></small>
		</td>
		<?php if($show_images): ?>
			<td class="getimage" id="rankout<?php echo $dropk;?>" data-type="<?php echo $type;?>" data-name="<?php echo $name?>" data-mbid="<?php echo $mbid;?>" data-artist="<?php echo $artist;?>"><?php echo S::loader(30);?></td>
		<?php ; endif;?>
		<td class="left"><?php echo $name;?></td>
		<?php 
		if($type != "artist")
		{ 
		?>
			<td class="left"><?php echo $artist;?></td> 
		<?php 
		}
		if($show_playcounts)
		{ 
		?>
			<td>
				OUT
				<br/>
				<small>LW: <?php echo $plays;?></small>
			</td>
		<?php 
		}
		?>
		<td><?php echo $peak;?></td>
		<td><?php echo $totalweeks;?></td>
	</tr>
	<tr style="display:none;">
		<td colspan="8">
		Chart-run
		</td>
	</tr>
	<?php
		}
	}
	?>
</table>
<div style="display:none;"><div id="copyme_alt">dasd</div></div>