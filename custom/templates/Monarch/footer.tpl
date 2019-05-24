  </div></div>

  <div class="pre-footer">
    <div class="container">
      <div class="row">
        <div class="col-md-4" style="margin-top:20px">
          <h3><i class="fas fa-question-circle"></i> About us</h3>
          <p>AtlanticNetwork has been around since 2016. Our main goal is to provide the best experience for our players, we look forward to meeting you on the island our dear Castaway!</p>
        </div>
        
        <div class="col-md-4" style="margin-top:20px">
          <h3><i class="fas fa-paper-plane"></i> Social</h3>
          <ul class="list-inline social-media-list">
            {foreach from=$SOCIAL_MEDIA_ICONS item=icon}
            <li><a href="{$icon.link}" target="_blank">{$icon.text}</a></li>
            {/foreach}
          </ul>
        </div>
        
        <div class="col-md-4" style="margin-top:20px">
          <h3><i class="fas fa-heart"></i> Support Us</h3>
          <p>We always appreciate any purchases that are made on the server as it shows us that you are enjoying the content we are creating for you, it motivates us to work ever harder to provide a even better experience for you!</p>
          <a class="footerShopButton" href="http://www.example.com/">Visit our Shop!</a>
        </div>
      </div>
    </div>
  </div>

  <div id="contact" class="contact-section section text-center" style="background:{$MONARCH_COLOR}">
    <div class="container">
		<div class="row">
		<div class="col-md-4">
          <div class="ui inverted link list">
            <span class="item">&copy; {'Y'|date} {$SITE_NAME}. All Rights Reserved</span>
            <span class="item">Forum software by <a href="https://namelessmc.com">© {'Y'|date} NamelessMC</a></span>
          </div>
        </div>
    <div class="col-md-4">
        <ul class="list-inline social-media-list">
            <span class="item"><a href="{$TERMS_LINK}">{$TERMS_TEXT}</a></span><br>
            <span class="item"><a href="{$PRIVACY_LINK}">{$PRIVACY_TEXT}</a></span>
        </ul>
      </div>
		<div class="col-md-4">
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

</body>

</html>
