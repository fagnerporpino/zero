<?php 
namespace B7KP\Library;

use B7KP\Core\Dao;
use B7KP\Core\App;
use B7KP\Model\Model;
use B7KP\Entity\User;
use B7KP\Entity\Settings;
use B7KP\Utils\UserSession;

class Lang
{
	const PT_BR = 0;
	const EN_US = 1;

	private function __construct(){}

	static function get($msg_id)
	{
		$lang = Settings::defaultValueFor('lang');
		$dao = Dao::getConn();
		$factory = new Model($dao);
		$user = UserSession::getUser($factory);
		if($user instanceof User)
		{
			$settings = $factory->findOneBy("\B7KP\Entity\Settings", $user->id, "iduser");
			if($settings instanceof Settings)
			{
				$lang = $settings->lang;
			}
		}
		$orig = $msg_id;
		$msg_id = strtolower($msg_id);
		$msg = self::messages();
		if(isset($msg[$msg_id]))
		{
			if(!isset($msg[$msg_id][$lang]))
			{
				return $msg[$msg_id][self::PT_BR];
			}
			else
			{
				return $msg[$msg_id][$lang];
			}
		}
		else
		{
			return $orig;
		}
	}

	static private function messages()
	{
		$messages = array();
		// GERAL
		$messages["mus"][self::PT_BR] = "Música";
		$messages["mus"][self::EN_US] = "Music";
		$messages["mus_x"][self::PT_BR] = "Músicas";
		$messages["mus_x"][self::EN_US] = "Musics";

		$messages["art"][self::PT_BR] = "Artista";
		$messages["art"][self::EN_US] = "Artist";
		$messages["art_x"][self::PT_BR] = "Artistas";
		$messages["art_x"][self::EN_US] = "Artists";

		$messages["alb"][self::PT_BR] = "Álbum";
		$messages["alb"][self::EN_US] = "Album";
		$messages["alb_x"][self::PT_BR] = "Álbuns";
		$messages["alb_x"][self::EN_US] = "Albums";

		$messages["sett"][self::PT_BR] = "Configurações";
		$messages["sett"][self::EN_US] = "Settings";

		$messages["reg"][self::PT_BR] = "Registrar";
		$messages["reg"][self::EN_US] = "Register";

		$messages["reg_alt"][self::PT_BR] = "Data de cadastro";
		$messages["reg_alt"][self::EN_US] = "Register date";

		$messages["about"][self::PT_BR] = "Sobre";
		$messages["about"][self::EN_US] = "About";

		$messages["home"][self::PT_BR] = "Início";
		$messages["home"][self::EN_US] = "Home";

		$messages["country"][self::PT_BR] = "País";
		$messages["country"][self::EN_US] = "Country";

		$messages["logout"][self::PT_BR] = "Sair";
		$messages["logout"][self::EN_US] = "Logout";

		$messages["prof"][self::PT_BR] = "Perfil";
		$messages["prof"][self::EN_US] = "Profile";

		$messages["click"][self::PT_BR] = "Clique";
		$messages["click"][self::EN_US] = "Click";

		$messages["click_h"][self::PT_BR] = "Clique aqui";
		$messages["click_h"][self::EN_US] = "Click here";

		$messages["view"][self::PT_BR] = "Veja mais";
		$messages["view"][self::EN_US] = "View more";

		$messages["submit"][self::PT_BR] = "Enviar";
		$messages["submit"][self::EN_US] = "Submit";

		$messages["save"][self::PT_BR] = "Salvar";
		$messages["save"][self::EN_US] = "Save";

		$messages["edit"][self::PT_BR] = "Editar";
		$messages["edit"][self::EN_US] = "Edit";

		$messages["update"][self::PT_BR] = "Atualizar";
		$messages["update"][self::EN_US] = "Update";

		$messages["remove"][self::PT_BR] = "Remover";
		$messages["remove"][self::EN_US] = "Remove";

		$messages["add"][self::PT_BR] = "Adicionar";
		$messages["add"][self::EN_US] = "Add";

		$messages["u"][self::PT_BR] = "Você";
		$messages["u"][self::EN_US] = "You";

		$messages["ur"][self::PT_BR] = "seu";
		$messages["ur"][self::EN_US] = "your";

		$messages["or"][self::PT_BR] = "ou";
		$messages["or"][self::EN_US] = "or";

		$messages["now"][self::PT_BR] = "agora";
		$messages["now"][self::EN_US] = "now";

		$messages["hv"][self::PT_BR] = "tem";
		$messages["hv"][self::EN_US] = "have";

		$messages["by"][self::PT_BR] = "de";
		$messages["by"][self::EN_US] = "by";

		$messages["hello"][self::PT_BR] = "Olá";
		$messages["hello"][self::EN_US] = "Hello";

		$messages["desatt"][self::PT_BR] = "desatualizada(s)";
		$messages["desatt"][self::EN_US] = "out of date";

		$messages["ch_cm"][self::PT_BR] = "Ver chart completo";
		$messages["ch_cm"][self::EN_US] = "View full chart";

		$messages["pass"][self::PT_BR] = "Senha";
		$messages["pass"][self::EN_US] = "Password";
		$messages["password"][self::PT_BR] = "Senha";
		$messages["password"][self::EN_US] = "Password";

		$messages["yes"][self::PT_BR] = "Sim";
		$messages["yes"][self::EN_US] = "Yes";

		$messages["no"][self::PT_BR] = "Não";
		$messages["no"][self::EN_US] = "No";

		$messages["name"][self::PT_BR] = "Nome";
		$messages["name"][self::EN_US] = "Name";

		$messages["dropouts"][self::PT_BR] = "Saídas";
		$messages["dropouts"][self::EN_US] = "Dropouts";

		$messages["copy"][self::PT_BR] = "Copiar";
		$messages["copy"][self::EN_US] = "Copy";
		$messages["copy_w"][self::PT_BR] = "Copiar sem formatação";
		$messages["copy_w"][self::EN_US] = "Copy without formatting";

		// CHART
		$messages["mov"][self::PT_BR] = "Movimento";
		$messages["mov"][self::EN_US] = "Move";
		$messages["mov_o"][self::PT_BR] = "Movimentação";
		$messages["mov_o"][self::EN_US] = "Move";
		$messages["pk"][self::PT_BR] = "Pico";
		$messages["pk"][self::EN_US] = "Peak";
		$messages["rk"][self::PT_BR] = "Posição";
		$messages["rk"][self::EN_US] = "Rank";
		$messages["wk"][self::PT_BR] = "Semana";
		$messages["wk"][self::EN_US] = "Week";
		$messages["wk_x"][self::PT_BR] = "Semanas";
		$messages["wk_x"][self::EN_US] = "Weeks";
		$messages["play"][self::PT_BR] = "Reprodução";
		$messages["play"][self::EN_US] = "Play";
		$messages["play_x"][self::PT_BR] = "Reproduções";
		$messages["play_x"][self::EN_US] = "Plays";
		$messages["scr"][self::PT_BR] = "Scrobbles";

		// TEXTOS/FRASESComplete the fields below and done.
		$messages["init"][self::PT_BR] = "Complete os campos abaixo e pronto. Para acessar ".App::get('name')." novamente, use seu login na last.fm e a senha que colocar logo abaixo. Ñós <b>não</b> recomendamos usar a mesma senha da sua conta na Last.fm.";
		$messages["init"][self::EN_US] = "Complete the fields below and done. To access ".App::get('name')." again, use your last.fm login and the new password you will insert below. We do <strong>not</strong> recomend to use the same password of your Last.fm account.";

		$messages["conn"][self::PT_BR] = "Conecte ".App::get('name')." com seu Last.fm";
		$messages["conn"][self::EN_US] = "Connect ".App::get('name')." with your Last.fm";

		$messages["wel_to"][self::PT_BR] = "Bem vindo ao";
		$messages["wel_to"][self::EN_US] = "Welcome to";

		$messages["look_at"][self::PT_BR] = "Dê uma olhada nas";
		$messages["look_at"][self::EN_US] = "Take a look at the";

		$messages["up_new_week"][self::PT_BR] = "Atualize novas semanas";
		$messages["up_new_week"][self::EN_US] = "Update new weeks";

		$messages["up_all"][self::PT_BR] = "Atualize tudo";
		$messages["up_all"][self::EN_US] = "Update all";

		$messages["alr"][self::PT_BR] = "Já fez isso?";
		$messages["alr"][self::EN_US] = "You already did that?";

		$messages["no_data"][self::PT_BR] = "Nenhum dado para mostrar aqui.";
		$messages["no_data"][self::EN_US] = "There's no data to show here.";

		$messages["customize"][self::PT_BR] = "<p class='text-muted'>Aqui você pode customizar seus charts.</p>";
		$messages["customize"][self::EN_US] = "<p class='text-muted'>Here you can customize your charts.</p>";

		$messages["error_token"][self::PT_BR] = "Algo deu errado ao checar o seu token. Tente novamente mais tarde.";
		$messages["error_token"][self::EN_US] = "Something went wrong when checking the token. Try again later.";

		$messages["sett_limit"][self::PT_BR] = "<p class='text-muted'>Aqui você pode selecionar o limite de itens para seu chart semanal. Colocando um limite, os itens que ficarem abaixo do mesmo serão ignorados na geração de seus charts, prevenindo que suas tabelas fiquem poluídas, mas se quiser, pode optar por salvar todos os itens disponíveis selecionando a opção 'Max'.</p>";
		$messages["sett_limit"][self::EN_US] = "<p class='text-muted'>Here you can select the item limit of your weekly chart. Putting a limit, items that fall below this limit are ignored when generating your data, preventing your graphics become polluted, but if you want to take advantage of all the data, you can select the 'Max' option.</p>";

		$messages["sett_diff_lw"][self::PT_BR] = "Diferença em relação a semana anterior";
		$messages["sett_diff_lw"][self::EN_US] = "Difference with last week";

		$messages["sett_none"][self::PT_BR] = "Nenhum (escoder)";
		$messages["sett_none"][self::EN_US] = "None (hide)";

		$messages["sett_lw"][self::PT_BR] = "Posição da semana anterior";
		$messages["sett_lw"][self::EN_US] = "Show last week position/plays";

		$messages["sett_pp"][self::PT_BR] = "Diferença em relação a semana anterior (porcentagem) (apenas para execuções)";
		$messages["sett_pp"][self::EN_US] = "Difference with last week (percentage) (only for playcounts)";

		$messages["sett_showimg"][self::PT_BR] = "Mostrar imagens no chart";
		$messages["sett_showimg"][self::EN_US] = "Show images on the chart";

		$messages["sett_showf_img"][self::PT_BR] = "Mostrar imagens do primeiro colocado acima do chart";
		$messages["sett_showf_img"][self::EN_US] = "Show image of the number one in the top of the chart";

		$messages["sett_showdrop"][self::PT_BR] = "Mostrar itens que saíram do chart no final do mesmo";
		$messages["sett_showdrop"][self::EN_US] = "Show dropouts at the end of the chart";

		$messages["sett_move"][self::PT_BR] = "Tipo de 'movimento'";
		$messages["sett_move"][self::EN_US] = "Type of 'move'";

		$messages["not_show"][self::PT_BR] = "Nada para mostrar aqui";
		$messages["not_show"][self::EN_US] = "Nothing to show here.";

		$messages["rec_tra"][self::PT_BR] = "FAIXAS RECENTES";
		$messages["rec_tra"][self::EN_US] = "RECENT TRACKS";

		$messages["sett_plays"][self::PT_BR] = "Mostrar número de execuções";
		$messages["sett_plays"][self::EN_US] = "Show playcounts";

		$messages["new_on"][self::PT_BR] = "Olá, parece que você é novo no Last.fm, você terá esperar até a semana terminar para aproveitar os charts semanais.";
		$messages["new_on"][self::EN_US] = "Hello, looks like you're new in last.fm, you'll have to wait till the week ends.";
		

		return $messages;
	}

}
?>