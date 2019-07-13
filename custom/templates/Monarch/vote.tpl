{include file='header.tpl'}
{include file='navbar.tpl'}

<div class="container">
  <div class="card card-default">
  <div class="card-body">
  {if !empty($WIDGETS)}
	<div class="row">
    <div class="col-md-9">
  {/if}
  
  <div class="card card-default">
  <div class="card-body">
  
	{if isset($MESSAGE_ENABLED)}
	<div class="alert alert-info"><center>{$MESSAGE}</center></div>
	{/if}
	<div class="row">
		{foreach from=$SITES item=site}
		  <div class="col-6">
			<a class="btn btn-lg btn-block btn-primary" href="{$site.url}" target="_blank" role="button">{$site.name}</a>
			</br>
		  </div>
		{/foreach}
	</div>
	
  </div>
  </div>
  
  {if !empty($WIDGETS)}
	  </div>
	  <div class="col-md-3">
	  {foreach from=$WIDGETS item=widget}
		{$widget}<br /><br />
	  {/foreach}
	  </div>
	  </div>
  {/if}
  </div>
  </div>
</div>

{include file='footer.tpl'}