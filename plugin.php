<?php

class pluginYandexMetrica extends Plugin {

	public function init()
	{
		$this->dbFields = array(
			'tagNumber'=>'',
                        'sessionReplay'=>false // Session Replay, scroll map, form analysis
		);
	}

	public function form()
	{
		global $L;

		$html  = '<div class="alert alert-primary" role="alert">';
		$html .= $this->description();
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<label>'.$L->get('yandex-metrica-tag-number').'</label>';
		$html .= '<input name="tagNumber" id="jstagNumber" type="text" value="'.$this->getValue('tagNumber').'">';
		$html .= '</div>';

                $html .= '<div>';
                $html .= '<label>'.$L->get('enable-session-replay').'</label>';
                $html .= '<select name="sessionReplay">';
                $html .= '<option value="true" '.($this->getValue('sessionReplay')===true?'selected':'').'>'.$L->get('enabled').'</option>';
                $html .= '<option value="false" '.($this->getValue('sessionReplay')===false?'selected':'').'>'.$L->get('disabled').'</option>';
		$html .= '</select>';
		$html .= '<span class="tip">'.$L->get('session-replay-records-the-actions-of-site-users').'</span>';
                $html .= '</div>';
		$html .= '<div>';

		return $html;
	}

	public function siteBodyEnd()
	{
		$tagNumber = $this->getValue('tagNumber');
		$sessionReplay = ($this->getValue('sessionReplay')?'true':'false');

$html = <<<EOF
<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
	(function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
	m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
	(window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

	ym($tagNumber, "init", {
	id:$tagNumber,
	clickmap:true,
	trackLinks:true,
	accurateTrackBounce:true,
	webvisor:$sessionReplay
	});
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/$tagNumber" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
EOF;

		return $html;
	}

}