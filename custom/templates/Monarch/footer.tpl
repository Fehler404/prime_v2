  </div></div>
  <div class="ui vertical footer segment" id="footer">
  <div id="contact" class="contact-section section text-center">
    <div class="container">
		<div class="row">
		<div class="col-md-4">
          <div class="ui inverted link list">
            <span class="item">Powered By <a href="https://namelessmc.com">NamelessMC</a></span>
            <span class="item">Template By <a href="https://www.spigotmc.org/members/spiele.25346/">Spiele</a></span>
          </div>
        </div>
    <div class="col-md-4">
            <ul class="list-inline social-media-list">
        <span class="item">&copy; {$SITE_NAME} {'Y'|date}</span><br>
        {foreach from=$SOCIAL_MEDIA_ICONS item=icon}
        <a href="{$icon.link}" target="_blank"><i id="social-{$icon.short}" class="{if $icon.long neq 'envelope'}fab{else}fas{/if} fa-{$icon.long}-square fa-3x social"></i></a>
        {/foreach}
            </ul>
      </div>
		<div class="col-md-4">
          <div class="ui inverted link list">
            <span class="item"><a href="{$TERMS_LINK}">{$TERMS_TEXT}</a></span>
            <span class="item"><a href="{$PRIVACY_LINK}">{$PRIVACY_TEXT}</a></span>
          </div>
        </div>
		</div>
    </div><!--//containter-->
</div>
  </div>

  {if isset($GLOBAL_WARNING_TITLE)}
    <div class="ui medium modal" id="modal-acknowledge">
      <div class="header">
        {$GLOBAL_WARNING_TITLE}
      </div>
      <div class="content">
        {$GLOBAL_WARNING_REASON}
      </div>
      <div class="actions">
        <a class="ui positive button" href="{$GLOBAL_WARNING_ACKNOWLEDGE_LINK}">{$GLOBAL_WARNING_ACKNOWLEDGE}</a>
      </div>
    </div>
  {/if}

  {foreach from=$TEMPLATE_JS item=script}
    {$script}
  {/foreach}
  <script src="{$TEMPLATE.path}/js/bootstrap.min.js"></script>

  {if isset($NEW_UPDATE) && ($NEW_UPDATE_URGENT != true)}
    <script src="{$TEMPLATE.path}/js/core/update.js"></script>
  {/if}

</body>

</html>
