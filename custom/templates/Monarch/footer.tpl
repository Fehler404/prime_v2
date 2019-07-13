  </div></div>

  <div class="pre-footer text-center">
    <div class="container">
    <hr style="border:1px solid #000;">
      <div class="row">
        
        <div class="col-md-6" style="margin-top:20px">
          <h3>Social</h3>
          <ul class="list-inline social-media-list">
            {foreach from=$SOCIAL_MEDIA_ICONS item=icon}
            <li><a href="{$icon.link}" target="_blank">{$icon.text}</a></li>
            {/foreach}
          </ul>
        </div>
        
        <div class="col-md-6" style="margin-top:20px">
          <h3>Useful Links</h3>
          <ul class="list-inline social-media-list">
            <span class="item"><a href="{$TERMS_LINK}">{$TERMS_TEXT}</a></span><br>
            <span class="item"><a href="{$PRIVACY_LINK}">{$PRIVACY_TEXT}</a></span>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <div id="contact" class="contact-section section text-center" style="background:{$MONARCH_COLOR}">
    <div class="container">
		<div class="row">
		<div class="col-md-6">
          <div class="ui inverted link list">
            <span class="item">&copy; {'Y'|date} {$SITE_NAME}. All Rights Reserved</span>
            <span class="item">Forum software by <a href="https://namelessmc.com">© {'Y'|date} NamelessMC</a></span>
          </div>
        </div>
		<div class="col-md-6">
          <div class="ui inverted link list">
            <span class="item">Designed By:<br><a href="https://github.com/agenthighcastle">HighCastle</a></span>
          </div>
        </div>
		</div>
    </div><!--//containter-->
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

  {if isset($NEW_UPDATE) && ($NEW_UPDATE_URGENT != true)}
    <script src="{$TEMPLATE.path}/js/core/update.js"></script>
  {/if}
</section>
</body>

</html>
