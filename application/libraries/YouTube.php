<?php
class YouTube
{
	public $url;
	public $id;
	
	public function url2id()
	{
		$aux = explode("?",$this->url);
		$aux2 = explode("&",$aux[1]);			
		foreach($aux2 as $campo => $valor)
		{
			$aux3 = explode("=",$valor);
			if($aux3[0] == 'v') $video = $aux3[1];
		}
		return $this->id = $video;
	}
	
	public function url2id_($url)
	{
		$aux = explode("?",$url);
		$aux2 = explode("&",$aux[1]);			
		foreach($aux2 as $campo => $valor)
		{
			$aux3 = explode("=",$valor);
			if($aux3[0] == 'v') $video = $aux3[1];
		}
		return $this->id = $video;
	}
	
	public function thumb_url($tamanho=NULL)
	{
		$tamanho = $tamanho == "large"?"hq":"";				
		$this->url2id();
		return 'http://i1.ytimg.com/vi/'.$this->id.'/'.$tamanho.'default.jpg';
	}
	
	public function thumb($tamanho=NULL)
	{
		$tamanho = $tamanho == "maior"?"hq":"";
		$this->url2id();	
		return '<img src="http://i1.ytimg.com/vi/'.$this->id.'/'.$tamanho.'default.jpg">';			
	}
	
	public function info()
	{	
		$info = array();
		$feedURL = 'http://gdata.youtube.com/feeds/base/videos?q='.$this->id.'&client=ytapi-youtube-search&v=2';    
		$sxml = simplexml_load_file($feedURL);				
		foreach ($sxml->entry as $entry)
		{
			$details = $entry->content;	
			$info["titulo"] = $entry->title;
			break;
		}
		if(isset($details) && !empty($details)) {
			$details_notags = strip_tags($details);
			$texto = explode("From",$details_notags);
			$info["descricao"] = $texto[0];
			if(isset($texto[1])) $aux = explode("Views:",$texto[1]);
			if(isset($aux[1])) $aux2 = explode(" ",$aux[1]);
			if(isset($aux2[0])) $info["views"] = $aux2[0];
			
			if(isset($texto[1])) $aux = explode("Time:",$texto[1]);
			if(isset($aux[1])) $aux2 = explode("More",$aux[1]);
			if(isset($aux2[0])) $info["tempo"] = $aux2[0];
			
			$imgs = strip_tags($details,'<img>');
			$aux = explode("<img",$imgs);
			array_shift($aux);
			array_shift($aux);
			$aux2 = explode("gif\">",$aux[4]);
			array_pop($aux);
			$aux3 = $aux2[0].'gif">';
			$aux[] = $aux3;
			$imagens = '';
			foreach($aux as $campo => $valor)
			{
				$imagens .= '<img'.$valor;
			}
			$info["estrelas"] = $imagens;

			$info['author_name'] = $sxml->entry->author->name;

			$feeduser_URL = $sxml->entry->author->uri;    
			$sxml_user = simplexml_load_file($feeduser_URL);

			$info['author_uri'] = $sxml_user->link[0]['href'];
		}
		return $info;
	}
	
	public function busca($palavra)
	{
		$feedURL = 'http://gdata.youtube.com/feeds/base/videos?q='.$palavra.'&client=ytapi-youtube-search&v=2';    
		$sxml = simplexml_load_file($feedURL);	
		$i=0;
		foreach ($sxml->entry as $entry)
		{
			$details = $entry->content;	
			$info[$i]["titulo"] = $entry->title;	
			$aux = explode($info[$i]["titulo"],$details);			
			$aux2 = explode("<a",$aux[0]);				
			$aux3 = explode('href="',$aux2[1]);
			$aux4 = explode('&',$aux3[1]);
			$info[$i]["link"] = $aux4[0];
			$details_notags = strip_tags($details);
			$texto = explode("From",$details_notags);
			$info[$i]["descricao"] = $texto[0];
			$aux = explode("Views:",$texto[1]);
			$aux2 = explode(" ",$aux[1]);
			$info[$i]["views"] = $aux2[0];
			
			$aux = explode("Time:",$texto[1]);
			$aux2 = explode("More",$aux[1]);
			$info[$i]["tempo"] = $aux2[0];
			
			$imgs = strip_tags($details,'<img>');
			$aux = explode("<img",$imgs);
			array_shift($aux);
			array_shift($aux);
			$aux2 = explode("gif\">",$aux[4]);
			array_pop($aux);
			$aux3 = $aux2[0].'gif">';
			$aux[] = $aux3;
			$imagens = '';
			foreach($aux as $campo => $valor)
			{
				$imagens .= '<img'.$valor;
			}
			$info[$i]["estrelas"] = $imagens;
			$i++;
			break;
		}
		return $info;
	}
	
	public function player($width='640',$height='480')
	{
		$this->url2id();
		return '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0" width="'.$width.'" height="'.$height.'">
	<param name="movie" value="http://www.youtube.com/v/'.$this->id.'?fs=1&egm=1&border=1&hd=1&autoplay=1&color1=cccc00&color2=ffff66&amp;hl=en_US"></param>
	<param name="allowFullScreen" value="true"></param>
	<param name="allownetworking" value="internal"></param>
	<embed src="http://www.youtube.com/v/'.$this->id.'?fs=1&egm=1&border=1&hd=1&autoplay=1&color1=cccc00&color2=ffff66&amp;hl=en_US" type="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer" allownetworking="internal" allowfullscreen="true" width="'.$width.'" height="'.$height.'"></embed>
</object>';
	}
}
?>